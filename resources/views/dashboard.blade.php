<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="relative h-[calc(100vh-4rem)] flex justify-center items-center overflow-hidden">
        <!-- Background -->
        <img src="{{ asset('images/uohh_cunny.jpg') }}"
            alt="Hero Image"
            class="fixed inset-0 w-full h-full object-cover opacity-50">

        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

                <!-- Biodata -->
                <div class="lg:col-span-2">
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl p-8 h-full">

                        <img
                            src="{{ asset('images/arif-1-1.jpg') }}"
                            alt="Arif Pandu Hidayatulloh"
                            class="w-28 h-28 mx-auto rounded-full object-cover border-2 border-white shadow-lg mb-3">

                        <h1 class="text-2xl font-bold text-center mb-3 text-gray-900 dark:text-white">
                            Arif Pandu Hidayatulloh | 22030001
                        </h1>

                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                            Arif Pandu Hidayatulloh adalah mahasiswa Program Studi Informatika
                            Institut Teknologi Dirgantara Adisutjipto yang memiliki minat pada
                            bidang <strong>Full Stack Programming</strong> dan
                            <strong>Cloud Computing</strong>.
                        </p>

                        <p class="mt-2 text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                            Saat ini sedang mengerjakan proyek tugas akhir berjudul
                            <strong>
                                "Pemanfaatan Google Cloud Computing untuk Pengembangan API
                                Model Machine Learning pada Platform Edukasi CUNNY"
                            </strong>.
                        </p>

                        <p class="mt-2 text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                            Penelitian ini bertujuan untuk mengetahui efektivitas pemanfaatan
                            Google Cloud Platform (GCP) sebagai lingkungan pengembangan dan
                            deployment API Machine Learning guna mendukung proses pembelajaran
                            pada platform edukasi anak CUNNY.
                        </p>

                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="flex flex-col gap-6">

                    <!-- Cloud Computing -->
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl p-6">
                        <h2 class="text-xl font-bold text-blue-600 mb-3">
                            Cloud Computing
                        </h2>

                        <p class="text-gray-700 dark:text-gray-300 text-justify mt-2">
                            Cloud Computing merupakan teknologi yang memungkinkan
                            penyimpanan, pengelolaan, dan pemrosesan data melalui
                            internet tanpa bergantung pada perangkat lokal.
                            Pada penelitian ini digunakan Google Cloud Platform (GCP)
                            sebagai infrastruktur untuk deployment API Machine Learning
                            sehingga sistem dapat diakses secara online, skalabel,
                            dan mudah dikelola.
                        </p>
                    </div>

                    <!-- CUNNY -->
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl p-6">
                        <h2 class="text-xl font-bold text-pink-600 mb-3 mt-2">
                            CUNNY
                        </h2>

                        <p class="text-gray-700 dark:text-gray-300 text-justify">
                            CUNNY merupakan platform edukasi anak yang dirancang untuk
                            membantu proses belajar melalui teknologi digital.
                            Platform ini memanfaatkan Machine Learning untuk memberikan
                            pengalaman belajar yang lebih interaktif dan adaptif.
                            Integrasi API yang berjalan pada Google Cloud Platform
                            memungkinkan layanan pembelajaran dapat diakses secara
                            cepat, stabil, dan efisien.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
