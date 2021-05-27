import requests

BASE = 'http://127.0.0.1:5000/'

# response = requests.put(BASE + "video/1", {"likes": 10, "name": "alan", "views": 100000})
# print(response.json())
#test = input("Masukkan Input:")
response = requests.get(BASE + "tweet")
#response = requests.post(BASE + "prepro", {"text": test})
print(response.json())