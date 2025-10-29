<section {{ $attributes->merge([
    'class' => 'space-y-2 p-5 bg-white shadow sm:rounded-lg
',
]) }}>

    <header class="flex flex-row justify-between">
        {{ $header }}
    </header>

    <div>
        {{ $slot }}
    </div>

</section>
