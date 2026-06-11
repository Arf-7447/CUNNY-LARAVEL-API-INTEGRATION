<x-app-layout :title="$title">

    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            Prediction Result
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-5">
                    Image Classification
                </h1> --}}

                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 md:p-5">

                    <div class="grid lg:grid-cols-2 gap-6">

                        {{-- LEFT --}}
                        <div>

                            <img
                                src="{{ $prediction['prediction_result']['image_url'] }}"
                                class="w-full h-[220px] md:h-[280px] object-cover rounded-lg border border-gray-300 dark:border-gray-600"
                                alt="Prediction Result"
                            >

                            <div class="mt-4">

                                <p class="text-green-600 font-semibold mt-1">
                                    Completed Successfully
                                </p>
                                <h3 class="text-base md:text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Response Time :
                                    <span class="text-blue-600">
                                        {{ round(microtime(true) - LARAVEL_START, 2) }} seconds
                                    </span>
                                </h3>
                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="flex flex-col h-full">

                            <div>

                                <h2 class="text-2xl md:text-3xl font-bold mb-3 text-gray-800 dark:text-white">
                                    {{-- Result : --}}
                                    <span class="capitalize text-green-600">
                                        {{ $prediction['prediction_result']['predicted_label'] }}
                                    </span>
                                </h2>

                                {{-- <h3 class="text-lg md:text-xl font-semibold mb-3 text-gray-800 dark:text-white">
                                    Description
                                </h3> --}}

                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm md:text-base text-justify">
                                    {{ $prediction['prediction_result']['image_desc'] }}
                                </p>

                            </div>

                            {{-- Push Button To Bottom --}}
                            <div class="mt-auto flex justify-end pt-6">

                                <a
                                    href="{{ route('img-classify.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition"
                                >
                                    Okkay
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
