@props(['name', 'title', 'options'])

<div>
    <div class = "font-medium text-brand-secondary-700 ml-1 text-lg mt-4">
        {{ $title }}
    </div>

    @foreach ($options as $option)
        <div>
            <input type="radio" id="{{ $option['id'] }}" wire:model="{{ $name }}" value="{{ $option['value'] }}"/>
            <label for="{{ $option['id'] }}">{{ $option['label'] }}</label>
        </div>
    @endforeach
    <div>
        @error($name)
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>
</div>
