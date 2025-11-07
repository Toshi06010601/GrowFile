{{-- modal  --}}
<x-modal name="edit-user-skill" :show="$errors->userDeletion->isNotEmpty()" focusable>

    <x-modal.icon-close />

    <form wire:submit="{{ $userSkill ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            {{ $userSkill ? 'Edit' : 'Add' }} Skill
        </x-modal.header-title>

        <livewire:SkillSelector wire:model="skill_id" />

        <x-modal.input-text label="Level" id="level" name="level" placeholder="Enter Skill Level" />

        <x-modal.submit-buttons :name="$userSkill ? 'update' : 'save'" />
    </form>

</x-modal>
