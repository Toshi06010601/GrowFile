<button type="button"
        {{ $attributes->merge([
        'class' => 'p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md cursor-pointer hover:scale-110 hover:bg-white hover:shadow-lg transition-all'])}}>
        <img src="{{ asset('images/icons/edit-pen-with-bg.svg') }}" alt="edit-icon" class="size-4 text-brand-secondary-600">
</button>