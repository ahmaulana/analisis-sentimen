<div>
    <div class="w-full mt-4">
        <div class="text-right my-2">
            <button wire:click="refreshTweet" title="Refresh" class="bg-gray-500 px-4 py-2 space-x-3 text-white transition-colors duration-200 transform border rounded-lg dark:border-gray-200 hover:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none" {{ $loader ? 'disabled=""' : '' }}>
                <div wire:loading>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                Refresh
            </button>
        </div>
        <div class="bg-white overflow-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">User</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tweet</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Setelah Preprocessing</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Prediksi Naive Bayes</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Prediksi C4.5</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" wire:init="loadTweets">
                    @if($loader)
                    <tr>
                        <td colspan="5" class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">
                            <div class="border border-light-blue-300 shadow rounded-md p-4 w-full mx-auto">
                                <div class="animate-pulse flex space-x-4">
                                    <div class="flex-1 space-y-4 py-1">
                                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                        <div class="space-y-2">
                                            <div class="h-4 bg-gray-200 rounded"></div>
                                            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach($results as $tweet)
                    <tr>
                        <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $tweet[1] }}</td>
                        <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $tweet[2] }}</td>
                        <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">
                            @foreach($tweet[4] as $key => $data)
                            "{{ $data }}"@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $tweet[5] }}</td>
                        <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $tweet[6] }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>