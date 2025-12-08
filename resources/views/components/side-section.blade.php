<section {{ $attributes->merge([
    'class' => 'space-y-2 p-3 bg-gray-100 shadow sm:rounded-lg
',
]) }}>

    <header class="flex flex-row justify-between">
        {{ $header }}
    </header>

    <div>
        {{ $slot }}
    </div>

</section>
