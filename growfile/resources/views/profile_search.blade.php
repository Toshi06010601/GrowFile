<x-app-layout>
    <section class="bg-white rounded-xl m-5 py-5 px-10">
        <h1 class="text-3xl font-medium mb-3">Search Result</h1>
        <ul class="flex flex-row gap-2 flex-wrap">
            @foreach ($profiles as $profile)
                <li wire:key="{{ $profile->id }}" class="relative w-38 bg-white border-2 border-gray-300 rounded-md">
                    <a href="" class="flex flex-col items-center">
                        <div class="w-full h-14 overflow-hidden border border-gray-600">
                            <img src="{{ $profile->background_image_path ? $profile->background_image_path : 'storage/background_photos/default.png' }}"
                                alt="background image" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute top-3 z-10 w-20 h-20 rounded-full overflow-hidden border border-gray-300">
                            <img src="{{ $profile->profile_image_path }}" alt="profile image"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-0 p-1">
                            <p class="text-sm text-center mt-9"><strong>{{ $profile->full_name }}</strong></p>
                            <p class="text-sm text-center text-gray-500">{{ $profile->headline }}</p>
                            <p class="text-sm text-center text-gray-500">{{ $profile->location }}</p>
                            <div class="w-32">
                                <p class="text-sm text-center text-gray-500" class="text-wrap">
                                    {{ Str::limit($profile->bio, 50) }}</p>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

</x-app-layout>
