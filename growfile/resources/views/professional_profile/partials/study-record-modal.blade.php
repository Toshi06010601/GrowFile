<x-prof-profile-modal.layout name="edit-study-record" route="profile.destroy" title="Edit study record" :show="$errors->userDeletion->isNotEmpty()"
    focusable>

    <x-prof-profile-modal.partials.input-text label="Project Name" id="project-name" name="project-name" placeholder="Project Name" required />

    <x-prof-profile-modal.partials.input-text label="Description" id="description" name="description" placeholder="What have you worked on?" />

    <x-prof-profile-modal.partials.input-datetime dateLabel="Start Date" dateId="start-date" dateName="start-date" timeLabel="Start Time"
        timeId="start-time" timeName="start-time">
    </x-prof-profile-modal.partials.input-datetime>

    <x-prof-profile-modal.partials.input-datetime dateLabel="End Date" dateId="end-date" dateName="end-date" timeLabel="end Time"
        timeId="end-time" timeName="end-time">
    </x-prof-profile-modal.partials.input-datetime>

</x-prof-profile-modal.layout>
