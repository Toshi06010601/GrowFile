<section {{ $attributes->merge([
    'class' => 'space-y-2 p-8 bg-white shadow sm:rounded-lg
',
]) }}>

    <header class="flex flex-row justify-end">
        {{ $header }}
    </header>

    <div>
        {{ $slot }}
    </div>

</section>
