@props(['fileName'])

<div class="my-12 text-center">
    <img src="{{ asset("images/icons/{$fileName}") }}" alt="" class="h-12 w-12 mx-auto">
    <p class="mt-2 text-base text-brand-secondary-600">{{ $slot }}</p>
</div>