{{-- User Skills section --}}
<x-side-section>

    <x-slot name="header">
        <h2 class="text-lg sm:text-xl font-medium text-gray-700">
            Skills
        </h2>

        {{-- button to add a new skill --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-user-skill', { id: null });" />
        @endif
    </x-slot>

    {{-- Display User Skills below --}}
    <ul class="flex flex-col max-h-96 overflow-y-scroll">
        @foreach ($userSkills->take($numOfSkills) as $userSkill)
            <li wire:key="{{ $userSkill->id }}" class="flex flex-row justify-between text-md sm:text-lg">
                <p>
                    {{ $userSkill->skill->name }}
                </p>
                <div class="flex flex-row justify-start gap-5">
                    <div class="flex flex-row gap-0">
                        @for ($i = 0; $i < $userSkill->level; $i++)
                            <img src="/images/icons/filled-drop.svg" alt="skill level" class="w-3">
                        @endfor
                        @for ($i = 0; $i < 5 - $userSkill->level; $i++)
                            <img src="/images/icons/empty-drop.svg" alt="skill level" class="w-3">
                        @endfor
                    </div>
    
                    {{-- Edit icon for the owner --}}
                    @if ($isOwner)
                        <x-section.edit-icon class="w-5"
                            x-on:click="$dispatch('set-user-skill', { id: {{ $userSkill->id }} })" />
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Show All Button if more than 5 skills --}}
    <div class="text-neutral-500 text-sm sm:text-md">
        @if (count($userSkills) > 5)
            @if ($numOfSkills === 5)
                <div class="mt-3 flex flex-row justify-center">
                    <button wire:click="$set('numOfSkills', 1000)" class="cursor-pointer">
                        Show All
                    </button>
                </div>
            @else
                <div class="mt-3 flex flex-row justify-center">
                    <button wire:click="$set('numOfSkills', 5)" class="cursor-pointer">
                        Show Less
                    </button>
                </div>
            @endif
        @endif
    </div>

    </x-section>
