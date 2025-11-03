@props(['label', 'id', 'name', 'placeholder'])

<div>
    <x-input-label :for="$id" :value="$label" class="text-lg mt-4" />
    <x-textarea-input :id="$id" :name="$name" rows="5" cols="33" class="mt-1 block w-full" :placeholder="$placeholder"
        wire:model="{{ $name }}" />
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
