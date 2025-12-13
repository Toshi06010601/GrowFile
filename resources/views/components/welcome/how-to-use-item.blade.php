@props(['img_path', 'img_alt', 'numbering', 'title', 'sub_title', 'description'])

<li class="flex flex-col md:flex-row items-start justify-between bg-neutral-200 py-8 px-5 sm:px-12 rounded-lg shadow-xl shadow-gray-900">
    <div class="w-full sm:w-5/12 flex flex-col justify-center gap-1 md:gap-3">
        <div class="flex flex-row items-start gap-2 sm:mt-5">
            <div
                class="bg-green-900 size-7 text-center flex justify-center items-center rounded-full text-white text-sm sm:text-lg font-bold">
                {{ $numbering }}
            </div>
            <h3 class="text-xl sm:text-2xl flex-1 text-gray-600 font-semibold text-left">
                {{ $title }}
            </h3>
        </div>
        <p class="text-gray-500 text-lg font-light sm:text-xl">{{ $sub_title }}</p>
        <p class="text-base sm:text-xl font-light text-gray-600 text-left text-wrap">
            {{ $description }}
        </p>
    </div>
    <div class="mt-5 sm:mt-0 overflow-hidden rounded-lg mx-auto sm:mx-0">
        <img src="{{ asset($img_path) }}" alt={{ $img_alt }} class="w-full h-96">
    </div>
</li>
