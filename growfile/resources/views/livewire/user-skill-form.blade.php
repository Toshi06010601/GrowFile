{{-- modal  --}}
<x-modal name="edit-user-skill" :show="false" focusable>

    <x-modal.icon-close />

    <form wire:submit="{{ $userSkill ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            {{ $userSkill ? 'Edit' : 'Add' }} Skill
        </x-modal.header-title>

        <livewire:SkillSelector wire:model="skill_id" />

        <x-modal.selectbox label="Level" id="level" name="level">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </x-modal.selectbox>

        <x-modal.submit-buttons :name="$userSkill ? 'update' : 'save'" />
    </form>

</x-modal>
