<div>
    <div>
        <div class="w-full my-6 pr-0">
            <p class="text-xl pb-6 flex items-center">
                <i class="fas fa-list mr-3"></i> Input Teks
            </p>
            <div class="leading-loose">
                <form wire:submit.prevent="predict" class="p-4 bg-white rounded shadow-xl">
                    @csrf
                    <div class="mt-2 mx-4">
                        <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" wire:model="text" rows="3" placeholder="Masukkan teks..."></textarea>
                        @error('text') <span class="error text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 text-center">
                        <button class="px-4 py-1 text-white font-light tracking-wider bg-blue-700 rounded" type="submit">Prediksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($active)
    <div class="w-full mt-4">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Preprocessing
        </p>
        <div class="bg-white overflow-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Teks</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Punctuation</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tokenisasi</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Stopword</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Stemming</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr>
                        <td class="text-left py-3 px-4">{{ $result['text'] }}</td>
                        <td class="text-left py-3 px-4">{{ $result['punctuation'] }}</td>
                        <td class="text-left py-3 px-4">
                            @foreach($result['tokenisasi'] as $key => $data)
                            "{{ $data }}"@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="text-left py-3 px-4">
                            @foreach($result['stopword'] as $key => $data)
                            "{{ $data }}"@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="text-left py-3 px-4">
                            @foreach($result['stemming'] as $key => $data)
                            "{{ $data }}"@if(!$loop->last), @endif
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex flex-wrap mt-4">
        <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-check mr-3"></i> Multinomial Naive Bayes
            </p>
            <div class="p-6 bg-white">
                <img src="{{ asset('image/'. $result['naive'] .'.png') }}" class="object-contain h-48 w-full">
            </div>
        </div>
        <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-check mr-3"></i> C4.5
            </p>
            <div class="p-6 bg-white">
                <img src="{{ asset('image/'. $result['c45'] .'.png') }}" class="object-contain h-48 w-full">
            </div>
        </div>
    </div>
    @endif
</div>