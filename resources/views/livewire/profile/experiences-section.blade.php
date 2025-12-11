{{-- User Skills section --}}
<x-side-section>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Experiences
        </h2>

        {{-- button to add a new skill for owner --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-experience', { id: null });" />
        @endif

    </x-slot>

    {{-- Display User Skills below --}}
    <ul class="flex flex-col">
        @foreach ($experiences as $experience)
            <li wire:key="{{ $experience->id }}" class="flex flex-col justify-start mb-4 last:mb-0 text-base font-normal text-gray-600">

                {{-- Experience item header --}}
                <div class="flex flex-row justify-between">

                    <h3 class="text-lg sm:text-xl font-medium">
                        {{ $experience->company_name }}
                    </h3>

                    {{-- Edit icon for owner of the profile --}}
                    @if ($isOwner)
                        <x-section.edit-icon class="w-5"
                            x-on:click="$dispatch('set-experience', { id: {{ $experience->id }} })" />
                    @endif
                </div>

                {{-- Role --}}
                <div>
                    {{ $experience->role }}
                </div>

                {{-- Work period --}}
                <div>
                    {{ $experience->start_month->format('M Y') }} -
                    {{ $experience->end_month ? $experience->end_month->format('M Y') : 'Present' }}
                </div>

                {{-- Work description (Shorten to 100 if longer) --}}
                @if (Str::length($experience->description) > 100)
                    <div x-data="{ open: true }" class="mt-1">
                        <p x-show="open">{{ Str::limit($experience->description, 100, '') }} <button @click="open = false">...see
                                more</button></p>
                        <p x-show="!open">{{ $experience->description, 100 }} <button @click="open = true">...see less</button></p>
                    </div>
                @else
                    <p>{{ $experience->description }}</p>
                @endif

            </li>
        @endforeach
    </ul>

    </x-section>
