<x-app-layout :title="$title">

    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            Image Classification
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-4">
                    Image Classification
                </h1> --}}

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-200 rounded-lg p-3">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 md:p-5">

                    <p class="text-base md:text-lg text-gray-700 dark:text-gray-300 mb-5 leading-relaxed">
                        Upload an image containing one of the supported fruits:
                        <span class="font-semibold">Apple</span>,
                        <span class="font-semibold">Banana</span>,
                        <span class="font-semibold">Green Paprika</span>,
                        <span class="font-semibold">Orange</span>, or
                        <span class="font-semibold">Tomato</span>.
                    </p>

                    <form
                        action="{{ route('img-classify.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div>

                            <div
                                id="drop-zone"
                                class="w-full
                                       min-h-[180px] md:min-h-[220px]
                                       px-4 py-5
                                       border-2 border-dashed
                                       border-gray-300 dark:border-gray-600
                                       rounded-xl
                                       bg-gray-50 dark:bg-gray-700
                                       hover:bg-gray-100 dark:hover:bg-gray-600
                                       transition
                                       cursor-pointer
                                       flex flex-col justify-center items-center"
                            >

                                <!-- Preview -->
                                <img
                                    id="preview"
                                    class="hidden max-w-xs max-h-40 object-contain rounded-lg shadow mb-3"
                                    alt="Preview Image"
                                >

                                <!-- Upload Icon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-10 h-10 md:w-12 md:h-12 text-gray-400 mb-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                    />
                                </svg>

                                <h3 class="text-lg md:text-xl font-semibold text-gray-700 dark:text-gray-200 mb-1 text-center">
                                    Drag & Drop Image
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-300 text-center">
                                    JPG, JPEG, PNG (Maximum 10 MB)
                                </p>

                                <!-- Input Upload -->
                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                    class="hidden"
                                    required
                                >

                                <!-- Input Camera -->
                                <input
                                    type="file"
                                    id="cameraImage"
                                    accept="image/*"
                                    capture="environment"
                                    class="hidden"
                                >

                                <div class="flex flex-wrap justify-center gap-3 mt-4">

                                    <button
                                        type="button"
                                        id="browseBtn"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                                    >
                                        Browse Image
                                    </button>

                                    <button
                                        type="button"
                                        id="cameraBtn"
                                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition"
                                    >
                                        📷 Open Camera
                                    </button>

                                </div>

                                <p
                                    id="fileName"
                                    class="mt-3 text-xs text-gray-600 dark:text-gray-300 break-all text-center"
                                ></p>

                            </div>

                        </div>

                        <div class="flex justify-end mt-4">

                            <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-semibold transition"
                            >
                                Predict Image
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>

        const dropZone = document.getElementById('drop-zone');

        const imageInput = document.getElementById('image');
        const cameraInput = document.getElementById('cameraImage');

        const browseBtn = document.getElementById('browseBtn');
        const cameraBtn = document.getElementById('cameraBtn');

        const fileName = document.getElementById('fileName');
        const preview = document.getElementById('preview');

        const allowedTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];

        const maxSize = 10 * 1024 * 1024;

        /*
        |--------------------------------------------------------------------------
        | Browse Button
        |--------------------------------------------------------------------------
        */

        browseBtn.addEventListener('click', () => {
            imageInput.click();
        });

        /*
        |--------------------------------------------------------------------------
        | Camera Button
        |--------------------------------------------------------------------------
        */

        cameraBtn.addEventListener('click', () => {
            cameraInput.click();
        });

        /*
        |--------------------------------------------------------------------------
        | Validate Image
        |--------------------------------------------------------------------------
        */

        function validateImage(file)
        {
            if (!allowedTypes.includes(file.type)) {

                alert('Only JPG, JPEG, and PNG images are allowed.');

                return false;
            }

            if (file.size > maxSize) {

                alert('Image size cannot exceed 10 MB.');

                return false;
            }

            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Show Preview
        |--------------------------------------------------------------------------
        */

        function showPreview(file)
        {
            if (!file) return;

            fileName.textContent = file.name;

            const imageUrl = URL.createObjectURL(file);

            preview.src = imageUrl;

            preview.classList.remove('hidden');
        }

        /*
        |--------------------------------------------------------------------------
        | Browse Upload
        |--------------------------------------------------------------------------
        */

        imageInput.addEventListener('change', () => {

            if (!imageInput.files.length) {
                return;
            }

            if (imageInput.files.length > 1) {

                alert('Only one image can be uploaded.');

                imageInput.value = '';

                fileName.textContent = '';

                preview.classList.add('hidden');

                return;
            }

            const file = imageInput.files[0];

            if (!validateImage(file)) {

                imageInput.value = '';

                fileName.textContent = '';

                preview.classList.add('hidden');

                return;
            }

            showPreview(file);

        });

        /*
        |--------------------------------------------------------------------------
        | Camera Upload
        |--------------------------------------------------------------------------
        */

        cameraInput.addEventListener('change', () => {

            if (!cameraInput.files.length) {
                return;
            }

            const file = cameraInput.files[0];

            if (!validateImage(file)) {

                cameraInput.value = '';

                return;
            }

            // Copy image camera ke input utama
            const dataTransfer = new DataTransfer();

            dataTransfer.items.add(file);

            imageInput.files = dataTransfer.files;

            showPreview(file);

        });

        /*
        |--------------------------------------------------------------------------
        | Drag Over
        |--------------------------------------------------------------------------
        */

        dropZone.addEventListener('dragover', (e) => {

            e.preventDefault();

            dropZone.classList.add(
                'border-blue-500',
                'dark:border-blue-400'
            );

        });

        /*
        |--------------------------------------------------------------------------
        | Drag Leave
        |--------------------------------------------------------------------------
        */

        dropZone.addEventListener('dragleave', () => {

            dropZone.classList.remove(
                'border-blue-500',
                'dark:border-blue-400'
            );

        });

        /*
        |--------------------------------------------------------------------------
        | Drop File
        |--------------------------------------------------------------------------
        */

        dropZone.addEventListener('drop', (e) => {

            e.preventDefault();

            dropZone.classList.remove(
                'border-blue-500',
                'dark:border-blue-400'
            );

            const files = e.dataTransfer.files;

            if (!files.length) {
                return;
            }

            if (files.length > 1) {

                alert('Please upload only one image.');

                return;
            }

            const file = files[0];

            if (!validateImage(file)) {
                return;
            }

            const dataTransfer = new DataTransfer();

            dataTransfer.items.add(file);

            imageInput.files = dataTransfer.files;

            showPreview(file);

        });

        /*
        |--------------------------------------------------------------------------
        | Click Drop Zone
        |--------------------------------------------------------------------------
        */

        dropZone.addEventListener('click', (e) => {

            if (
                e.target !== browseBtn &&
                e.target !== cameraBtn
            ) {
                imageInput.click();
            }

        });

        </script>

</x-app-layout>
