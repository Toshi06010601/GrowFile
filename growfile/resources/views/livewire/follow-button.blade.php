<div class="mt-2 flex justify-center hover:border-green-700 transition duration-150">
    <input type="checkbox" wire:model.live="isFollowing" id="follow-{{ $userId }}" class="hidden peer">
    <label
        for="follow-{{ $userId }}"
        class="
            px-3 rounded-full border-2 border-green-800
            text-green-900  text-xs sm:text-md py-0.5 cursor-pointer 
            transition duration-150
            peer-checked:bg-green-900         {{-- <-- Apply BG color when checked --}}
            peer-checked:text-white          {{-- <-- Change text color when checked --}}
            peer-checked:font-medium
        ">{{ $isFollowing ? "Following" : "+Follow" }}</label>
</div>
