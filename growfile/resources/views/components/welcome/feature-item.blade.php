@props([
    'img_path',
    'img_alt',
    'title',
    'description'
])

<li {{ $attributes->merge(['class' => 'bg-neutral-200 w-full sm:w-64 h-72 md:h-64 p-4 rounded-lg flex flex-col gap-1']) }}>
    <img src="{{ asset($img_path) }}" alt="{{ $img_alt }}" class="w-12">
    <h3 class="text-xl underline font-semibold text-gray-600">{{ $title }}</h3>
    <p class="text-md font-thin text-gray-600">
        {{ $description }}
    </p>
</li>
