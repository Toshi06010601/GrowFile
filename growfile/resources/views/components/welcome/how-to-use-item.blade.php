@props(['img_path', 'img_alt', 'numbering', 'title', 'sub_title', 'description'])

<li class="flex flex-col md:flex-row items-start gap-3 bg-neutral-200 py-8 px-5 rounded-lg">
    <div class="flex-1 flex flex-col justify-center gap-1 md:gap-3">
        <div class="flex flex-row items-start gap-2 sm:mt-5">
            <div
                class="bg-green-900 size-8 text-center flex justify-center items-center rounded-full text-white text-sm sm:text-lg font-bold">
                {{ $numbering }}
            </div>
            <h3 class="text-xl md:text-2xl flex-1 text-gray-600 font-semibold text-left">
                {{ $title }}
            </h3>
        </div>
        <p class="text-gray-400 text-lg">{{ $sub_title }}</p>
        <p class="text-md font-thin text-gray-600 text-left text-wrap">
            {{ $description }}
        </p>
    </div>
    <div class="flex-1 overflow-hidden rounded-lg">
        <img src="{{ asset($img_path) }}" alt={{ $img_alt }}>
    </div>
</li>
