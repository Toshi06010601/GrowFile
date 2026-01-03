<section {{ $attributes->merge([
    'class' => 'w-full space-y-2 p-4 sm:p-8 bg-white shadow rounded-lg
',
]) }}>

    <header class="flex flex-row justify-between">
        {{ $header }}
    </header>

    <div class="max-w-full w-full">
        {{ $slot }}
    </div>

</section>
