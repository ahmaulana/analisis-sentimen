<div>
    <div class="mt-4">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                <p class="text-xl pb-3 flex items-center">
                    <i class="fas fa-check mr-3"></i> Multinomial Naive Bayes
                </p>
                <div class="p-6 bg-white">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="text-center mx-auto text-emerald-600" colspan="3">Predicted</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="border px-4 py-2 text-emerald-600">Positif</th>
                                <th class="border px-4 py-2 text-emerald-600">Negatif</th>
                                <th class="border px-4 py-2 text-emerald-600">Netral</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['naive_bayes'] as $key => $result)
                            <tr>
                                @if($key == 0)
                                <th class="py-2 text-emerald-600" rowspan="3">Actual</th>
                                @endif
                                <th class="border px-4 py-2 text-emerald-600">{{ ($key == 0) ? 'Positif' : (($key == 1) ? 'Negatif' : 'Netral') }}</th>
                                <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $result[0] }}</td>
                                <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $result[1] }}</td>
                                <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $result[2] }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                @for($i = 0; $i < 6; $i++) <td class="text-center px-4 py-2 text-emerald-600 font-medium">
                                    </td>
                                    @endfor
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">Accuracy</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">
                                    </td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($results['naive_bayes'][0][0] + $results['naive_bayes'][1][1] + $results['naive_bayes'][2][2]) / (array_sum($results['naive_bayes'][0]) + array_sum($results['naive_bayes'][1]) + array_sum($results['naive_bayes'][2])), 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">Precision</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $precision[$i] = round($results['naive_bayes'][$i][$i] / ($results['naive_bayes'][0][$i] + $results['naive_bayes'][1][$i] + $results['naive_bayes'][2][$i]),2) }}</td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($precision[0] + $precision[1] + $precision[2]) / 3,2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">Recall</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $recall[$i] = round($results['naive_bayes'][$i][$i] / ($results['naive_bayes'][$i][0] + $results['naive_bayes'][$i][1] + $results['naive_bayes'][$i][2]),2) }}</td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($recall[0] + $recall[1] + $recall[2]) / 3, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">F1 Score</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $f1_score[$i] = round(2 * $recall[$i] * $precision[$i] / ($recall[$i] + $precision[$i]),2) }}</td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($f1_score[0] + $f1_score[1] + $f1_score[2]) / 3, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
                <p class="text-xl pb-3 flex items-center">
                    <i class="fas fa-check mr-3"></i> C4.5
                </p>
                <div class="p-6 bg-white">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="text-center mx-auto text-emerald-600" colspan="3">Predicted</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="px-4 py-2 text-emerald-600"></th>
                                <th class="border px-4 py-2 text-emerald-600">Positif</th>
                                <th class="border px-4 py-2 text-emerald-600">Negatif</th>
                                <th class="border px-4 py-2 text-emerald-600">Netral</th>
                                <th class="px-4 py-2 text-emerald-600"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['c45'] as $key => $result)
                            <tr>
                                @if($key == 0)
                                <th class="py-2 text-emerald-600" rowspan="3">Actual</th>
                                @endif
                                <th class="border px-4 py-2 text-emerald-600">{{ ($key == 0) ? 'Positif' : (($key == 1) ? 'Negatif' : 'Netral') }}</th>
                                <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $result[0] }}</td>
                                <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $result[1] }}</td>
                                <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $result[2] }}</td>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                            </tr>
                            @endforeach
                            <tr>
                                @for($i = 0; $i < 6; $i++) <td class="text-center px-4 py-2 text-emerald-600 font-medium">
                                    </td>
                                    @endfor
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">Accuracy</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">
                                    </td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($results['c45'][0][0] + $results['c45'][1][1] + $results['c45'][2][2]) / (array_sum($results['c45'][0]) + array_sum($results['c45'][1]) + array_sum($results['c45'][2])), 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">Precision</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $precision[$i] = round($results['c45'][$i][$i] / ($results['c45'][0][$i] + $results['c45'][1][$i] + $results['c45'][2][$i]),2) }}</td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($precision[0] + $precision[1] + $precision[2]) / 3,2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">Recall</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $recall[$i] = round($results['c45'][$i][$i] / ($results['c45'][$i][0] + $results['c45'][$i][1] + $results['c45'][$i][2]),2) }}</td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($recall[0] + $recall[1] + $recall[2]) / 3,2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-center px-4 py-2 text-emerald-600 font-medium"></td>
                                <th class="border px-4 py-2 text-emerald-600">F1 Score</th>
                                @for($i = 0; $i < 3; $i++) <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $f1_score[$i] = round(2 * $recall[$i] * $precision[$i] / ($recall[$i] + $precision[$i]),2) }}</td>
                                    @endfor
                                    <td class="text-center border border-emerald-500 px-4 py-2 text-emerald-600 font-medium font-bold">{{ round(($f1_score[0] + $f1_score[1] + $f1_score[2]) / 3, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full mt-10">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Sample Data Training
        </p>
        <div class="bg-white overflow-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Teks</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Setelah Preprocessing</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Label</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($training_samples['result'] as $key => $training)
                    <tr class="{{ ($key % 2) == 0 ? 'bg-gray-200' : '' }}">
                        <td class="text-left py-3 px-4">{{ $training[0] }}</td>
                        <td class="text-left py-3 px-4">{{ $training[1] }}</td>
                        <td class="text-left py-3 px-4">{{ $training[2] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <ul class="flex justify-center my-4 space-x-3">
                @if($training_page > 1)
                <li>
                    <button wire:click.prevent="pagination('training',-1)" title="« Previous" class="flex items-center px-4 py-2 space-x-3 text-gray-600 transition-colors duration-200 transform border rounded-lg dark:text-gray-200 dark:border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">« Previous</button>
                </li>
                @endif
                @if($training_page != $total_training_page)
                <li>
                    <button wire:click.prevent="pagination('training',1)" title="Next »" class="flex items-center px-4 py-2 space-x-3 text-gray-600 transition-colors duration-200 transform border rounded-lg dark:text-gray-200 dark:border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">Next »</button>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="w-full mt-10">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Sample Data Testing
        </p>
        <div class="bg-white overflow-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Teks</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Setelah Preprocessing</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Label</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($testing_samples['result'] as $key => $testing)
                    <tr class="{{ ($key % 2) == 0 ? 'bg-gray-200' : '' }}">
                        <td class="text-left py-3 px-4">{{ $testing[0] }}</td>
                        <td class="text-left py-3 px-4">{{ $testing[1] }}</td>
                        <td class="text-left py-3 px-4">{{ $testing[2] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <ul class="flex justify-center my-4 space-x-3">
                @if($testing_page > 1)
                <li>
                    <button wire:click.prevent="pagination('testing',-1)" title="« Previous" class="flex items-center px-4 py-2 space-x-3 text-gray-600 transition-colors duration-200 transform border rounded-lg dark:text-gray-200 dark:border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">« Previous</button>
                </li>
                @endif
                @if($testing_page != $total_testing_page)
                <li>
                    <button wire:click.prevent="pagination('testing',1)" title="Next »" class="flex items-center px-4 py-2 space-x-3 text-gray-600 transition-colors duration-200 transform border rounded-lg dark:text-gray-200 dark:border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">Next »</button>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>