from flask import Flask
from flask_restful import Api, Resource, reqparse, abort, request
import tweepy as tw
import pandas as pd
import re
import numpy as np
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
import joblib
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score
from sklearn.metrics import confusion_matrix

app = Flask(__name__)
api = Api(app)


def remove_punct(text):
    text = str(text)
    text = re.sub(r'https?:\/\/\S*', '', text, flags=re.MULTILINE)  # link
    text = re.sub(r'[^a-zA-Z0-9_]', ' ', str(text))  # huruf/angka/underline
    text = re.sub(r'\s\s+', ' ', text)  # whitespace
    text = re.sub(r'\b\w(1,2)\b', ' ', text)  # batas antara kata dan non-kata
    text = re.sub(r'[@]', r' ', text)  # menghilangkan @
    text = re.sub(r'[0-9]+', ' ', text)  # angka
    return text

# Tokenize


def tokenize(text):
    return word_tokenize(text)

# Remove Stopword


def stopword_removal(tweet):
    stopword_lists = stopwords.words('indonesian')
    stopword_lists.extend(["yg", "dg", "rt", "dgn", "ny", "d", 'klo',
                           'kalo', 'amp', 'biar', 'bikin', 'bilang',
                           'gak', 'ga', 'krn', 'nya', 'nih', 'sih',
                           'si', 'tau', 'tdk', 'tuh', 'utk', 'ya',
                           'jd', 'jgn', 'sdh', 'aja', 'n', 't',
                           'nyg', 'hehe', 'pen', 'u', 'nan', 'loh', 'rt',
                           '&amp', 'yah', 'jln', 'bs'])
    stopword_lists = set(stopword_lists)

    tweet = [w for w in tweet if not w in stopword_lists]
    return tweet

# Stemming


def stemming_process(tweet):
    factory = StemmerFactory()
    stemmer = factory.create_stemmer()
    tweet = [stemmer.stem(token) for token in tweet]
    return tweet


def prepro(tweet):
    punctuation = remove_punct(tweet)
    tokenisasi = tokenize(punctuation)
    stopword = stopword_removal(tokenisasi)
    stemming = stemming_process(stopword)
    result = pd.DataFrame({'tweet': [str(stemming)]})
    
    tfidf = joblib.load('tfidf_vectorizer.pickle')
    model_naive = joblib.load('model_naive.pickle')
    model_c45 = joblib.load('model_c45.pickle')
    
    ss = TfidfVectorizer(ngram_range=(1,2), vocabulary=tfidf)
    tf_text = ss.fit_transform(result['tweet'])
    
    prediction_naive = model_naive.predict(tf_text.toarray())
    prediction_c45 = model_c45.predict(tf_text.toarray())

    result = [stemming, prediction_naive[0], prediction_c45[0]]
    
    return result

class Preprocessing(Resource):
    def post(self):
        text = request.form.get('text')
        punctuation = remove_punct(text)
        tokenisasi = tokenize(punctuation)
        stopword = stopword_removal(tokenisasi)
        stemming = stemming_process(stopword)
        result = pd.DataFrame({'tweet': [str(stemming)]})
        
        tfidf = joblib.load('tfidf_vectorizer.pickle')
        model_naive = joblib.load('model_naive.pickle')
        model_c45 = joblib.load('model_c45.pickle')
        
        ss = TfidfVectorizer(ngram_range=(1,2), vocabulary=tfidf)
        tf_text = ss.fit_transform(result['tweet'])
        
        prediction_naive = model_naive.predict(tf_text.toarray())
        prediction_c45 = model_c45.predict(tf_text.toarray())
        
        return {"text": text, "punctuation": punctuation, "tokenisasi": tokenisasi, "stopword": stopword, "stemming": stemming, "naive": prediction_naive[0], "c45": prediction_c45[0]}

class Performance(Resource):
    def get(self):
        tfidf = joblib.load('tfidf_vectorizer.pickle')
        model_naive = joblib.load('model_naive.pickle')
        model_c45 = joblib.load('model_c45.pickle')

        data = pd.read_csv('saved_testing_data.csv')
        ss = TfidfVectorizer(ngram_range=(1,2), vocabulary=tfidf)
        tf_text = ss.fit_transform(data['prepro'])

        #Naive Bayes
        predicted_naive = model_naive.predict(tf_text.toarray())

        confusion_naive = confusion_matrix(data['label'], predicted_naive, labels=['positif', 'negatif', 'netral'])

        #C45
        predicted_c45 = model_c45.predict(tf_text.toarray())

        confusion_c45 = confusion_matrix(data['label'], predicted_c45, labels=['positif', 'negatif', 'netral'])

        return {"naive_bayes": confusion_naive.tolist(),"c45": confusion_c45.tolist()}

class Sample(Resource):
    def get(self, data, page):
        if data == 'testing':
            data = pd.read_csv('saved_testing_data.csv')
        elif data == 'training':
            data = pd.read_csv('saved_training_data.csv')

        data = data[['tweet','prepro','label']]
        first = (page - 1)*5
        last = page * 5
        data_range = data.iloc[first:last]
        result = data_range.values.tolist()
        return {"result": result}

class Tweet(Resource):
    def get(self, tweet_id):
        #Twitter key
        api_key = 'FSSjIX9PWtgPkmxAZr5oNN70v'
        api_key_secret = 'ySTNsffGwh8IlALmnhyzQN0gCsD4RF3gW75rQZDNtk2402K5FK'
        access_token = '1314360748865249280-xTyYCvheTzvcvo6RNYD7XUSorTRvB3'
        access_token_secret = 'lSvETMGce9Q9hNr5QUEOyeZ5YBY3ohE5eoyQcoMn5VHgu'

        #Tweet Query/Keyword
        query = 'covid' #kata kunci yang ingin di-crawling

        #Auth
        auth = tw.OAuthHandler(api_key, api_key_secret)
        auth.set_access_token(access_token, access_token_secret)

        api = tw.API(auth, wait_on_rate_limit=True, wait_on_rate_limit_notify=True)

        twitter_data = []

        tweets = api.search(q=query+' -filter:retweets',
                        count=10,
                        since_id=int(tweet_id),
                        lang='id',
                        tweet_mode='extended')

        twitter_data = [[tweet.id, tweet.user.name, tweet.full_text,tweet.created_at] for tweet in tweets]

        result = pd.DataFrame(data=twitter_data,
                 columns=["id","user","tweet","created_at"])

        result['created_at'] = result['created_at'].astype(str)
        
        result_tweet_prepro = []
        predict_naive_bayes = []
        predict_c45 = []
        for ind in result.index:
            tweet_prepro = prepro(result['tweet'][ind])
            result_tweet_prepro += [tweet_prepro[0]]
            predict_naive_bayes += [tweet_prepro[1]]
            predict_c45 += [tweet_prepro[2]]
        
        result['prepro'] = result_tweet_prepro
        result['naive_bayes'] = predict_naive_bayes
        result['c45'] = predict_c45
        
        lastt = result.values.tolist()

        return {"result": lastt}

api.add_resource(Preprocessing, "/prepro")
api.add_resource(Performance, "/performa")
api.add_resource(Sample, "/sample/<string:data>/<int:page>")
api.add_resource(Tweet, "/tweet/<string:tweet_id>")

if __name__ == '__main__':
    app.run(debug=True)
