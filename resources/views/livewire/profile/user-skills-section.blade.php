{{-- User Skills section --}}
<x-side-section>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-brand-secondary-700">
            Skills
        </h2>

        {{-- button to add a new skill --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click.stop="
                $dispatch('set-user-skill', { id: null });" />
        @endif
    </x-slot>

    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load user skills. Please try again.</x-loading-error>
    @endif

    {{-- Display user skills below --}}
    @if (!$hasError)
        {{-- Display if user skill data exists --}}
        @if (count($this->userSkills) > 0)
            <ul class="flex flex-col max-h-96 overflow-y-scroll gap-0.5">
                @foreach ($this->userSkills->take($numOfSkills) as $userSkill)
                    <li wire:key="{{ $userSkill->id }}"
                        class="flex flex-row justify-between items-center text-brand-secondary-600 text-base">
                        <p>
                            {{ $userSkill->skill->name }}
                        </p>
                        <div class="flex flex-row justify-start gap-2">
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
                                <x-section.edit-icon-without-bg
                                    x-on:click.stop="$dispatch('set-user-skill', { id: {{ $userSkill->id }} })" />
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Show All Button if more than 5 skills --}}
            <div class="text-neutral-500 text-base">
                @if (count($this->userSkills) > 5)
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
        @else
            {{-- Display if no user skill exists --}}
            <x-no-data-to-display fileName="skill.svg">No skills to display</x-no-data-to-display>
        @endif
    @endif

    </x-section>
