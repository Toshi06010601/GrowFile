<div class="mt-2 flex justify-center hover:border-green-700 transition duration-150">
    <input type="checkbox" wire:model.live="isFollowing" id="{{ $idPrefix }}-{{ $userId }}" class="hidden peer">
    <label
        for="{{ $idPrefix }}-{{ $userId }}"
        class="
            px-3 rounded-full border-2 border-green-800
            text-green-900  text-xs sm:text-base py-0.5 sm:py-1 cursor-pointer 
            transition duration-150
            peer-checked:bg-green-900         
            peer-checked:text-white          
            peer-checked:font-medium
        ">{{ $isFollowing ? "Following" : "+Follow" }}</label>
</div>
