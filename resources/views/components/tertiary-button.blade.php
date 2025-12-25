<button type="button"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-[#374151] border border-brand-secondary-700 hover:bg-[#4b5563] focus:z-10 focus:outline-none transition-colors']) }}>
    {{ $slot }}
</button>
