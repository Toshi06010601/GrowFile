{{-- User Skills section --}}
<x-side-section>

    <x-slot name="header">
        <h2 class="text-xl font-medium text-gray-700">
            Experiences
        </h2>

        {{-- button to add a new skill --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-experience', { id: null });" />
        @endif

    </x-slot>

    {{-- Display User Skills below --}}
    <ul class="flex flex-col max-h-96 overflow-y-scroll">
        @foreach ($experiences as $experience)
            <li wire:key="{{ $experience->id }}" class="flex flex-col justify-start mb-4 last:mb-0">
                <div class="flex flex-row justify-between">
                    <h3 class="text-black">
                        {{ $experience->company_name }}
                    </h3>

                    {{-- Edit icon --}}
                    @if ($isOwner)
                        <x-section.edit-icon class="w-5"
                            x-on:click="$dispatch('set-experience', { id: {{ $experience->id }} })" />
                    @endif
                </div>
                <div class="mt-1 text-gray-700">
                    {{ $experience->start_month->format('M Y') }} - {{ $experience->end_month ? $experience->end_month->format('M Y') : "Present" }}
                </div>
                <div class="mt-1 text-gray-700">
                    {{ $experience->role }}
                </div>
                <div class="mt-1 text-gray-600">
                    {{ Str::limit($experience->description, 100) }}
                </div>

            </li>
        @endforeach
    </ul>

    </x-section>
