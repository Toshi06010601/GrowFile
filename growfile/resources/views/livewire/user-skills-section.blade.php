{{-- User Skills section --}}
<x-side-section>

    <x-slot name="header">
        <h2 class="text-xl font-medium text-gray-700">
            Skills
        </h2>

        {{-- button to add a new skill --}}
        <x-section.add-icon x-data=""
            x-on:click="
                $dispatch('set-user-skill', { id: null });" />
    </x-slot>

    {{-- Display User Skills below --}}
    <ul class="flex flex-col max-h-96 overflow-y-scroll">
        @foreach ($userSkills as $userSkill)
            <li wire:key="{{ $userSkill->id }}" class="flex flex-row justify-between">
                <p>
                    {{ $userSkill->skill->name }}
                </p>
                <div class="flex flex-row gap-0">
                    @for ($i = 0; $i < $userSkill->level; $i++)
                        <img src="/images/icons/filled-drop.svg" alt="skill level" class="w-3">
                    @endfor
                    @for ($i = 0; $i < 5 - $userSkill->level; $i++)
                        <img src="/images/icons/empty-drop.svg" alt="skill level" class="w-3">
                    @endfor
                </div>
                {{-- Edit icon --}}
                <x-section.edit-icon class="w-5" x-on:click="$dispatch('set-user-skill', { id: {{ $userSkill->id }} })" />
            </li>
        @endforeach
    </ul>

    </x-section>
