@props([
    'name',
    'show' => false
])

<div
    x-data="{show: false}"
    x-on:open-suggestion.window="show = true"
    x-on:close-suggestion.window="show = false"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="max-h-10 overflow-y-auto px-4 py-6 sm:px-0"
    style="display: {{ $show ? 'block' : 'none' }};"
>

        {{ $slot }}
    </div>
</div>
