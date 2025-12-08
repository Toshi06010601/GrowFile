@props(['label', 'id', 'name'])

<div class="relative overflow-visible">
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" />
    <select :id="$id" class="block w-full border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm" wire:model="{{ $name }}">
        {{ $slot }}
    </select>
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>

