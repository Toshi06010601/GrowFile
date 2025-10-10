@props([
    'wireAction'
])

<img src=" {{ asset('images/icons/edit-pen.svg') }}" alt="edit-icon"
    class="w-7 px-1 cursor-pointer hover:scale-110" x-data=""
    wire:click="{{ $wireAction }}"
    >
