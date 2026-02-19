<div class="mt-2 flex justify-center hover:scale-105 transition duration-150">
    <input type="checkbox" wire:model.live="isFollowing" id="{{ $idPrefix }}-{{ $userId }}" class="hidden peer">
    <label
        for="{{ $idPrefix }}-{{ $userId }}"
        class="
            px-3 rounded-full border-2 border-brand-primary-900
            text-brand-primary-900  text-xs sm:text-base py-0.5 sm:py-1 cursor-pointer hover:border-brand-primary-800
            transition duration-150 hover:opacity-90
            peer-checked:bg-brand-primary-950         
            peer-checked:text-white          
            peer-checked:font-medium
        ">{{ $isFollowing ? "Following" : "+Follow" }}</label>
</div>
