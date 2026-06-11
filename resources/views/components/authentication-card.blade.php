<img src="{{ asset('images/uohh_cunny.jpg') }}"
        alt="Hero Image" class="fixed inset-0 w-full h-full object-cover opacity-50">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div class="relative z-10">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg relative z-10">
        {{ $slot }}
    </div>
</div>
