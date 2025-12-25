@props([
    'img_path',
    'img_alt',
    'title',
    'description'
])

<li {{ $attributes->merge(['class' => 'bg-brand-secondary-100 size-72 sm:size-80 p-6 rounded-lg flex flex-col gap-1 shadow-xl shadow-brand-secondary-900']) }}>
    <img src="{{ asset($img_path) }}" alt="{{ $img_alt }}" class="w-12">
    <h3 class="text-xl sm:text-2xl underline font-semibold text-brand-secondary-600 mb-2">{{ $title }}</h3>
    <p class="text-base text-brand-secondary-600">
        {{ $description }}
    </p>
</li>
