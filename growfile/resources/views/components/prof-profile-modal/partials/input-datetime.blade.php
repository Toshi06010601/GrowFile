@props(['dateLabel', 'dateId', 'dateName', 'timeLabel', 'timeId', 'timeName'])

<div class="flex flex-row justify-start mt-4">
    <div>
        <x-input-label :for="$dateId" :value="$dateLabel" class="text-lg" />
        <x-text-input :id="$dateId" :name="$dateName" type="date" class="mt-1" />
        <x-input-error :messages="$errors->userDeletion->get($dateName)" class="mt-2" />
    </div>
    <div class="ml-20">
        <x-input-label :for="$timeId" :value="$timeLabel" class="text-lg" />
        <x-text-input :id="$timeId" :name="$timeName" type="time" class="mt-1" />
        <x-input-error :messages="$errors->userDeletion->get($timeName)" class="mt-2" />
    </div>
</div>
