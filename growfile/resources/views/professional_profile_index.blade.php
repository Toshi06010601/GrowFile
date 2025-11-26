<x-app-layout>
    <section class="bg-white rounded-xl m-5 py-5  px-7 md:px-10">
        <h1 class="text-2xl md:text-3xl font-medium mb-3">Search Result</h1>
        <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
            @foreach ($profiles as $profile)
                <li wire:key="{{ $profile->id }}"
                    class="relative w-full h-56 sm:h-64 bg-white border-2 border-gray-300 rounded-md overflow-hidden">
                    <a href="{{ route('professional_profile.show', $profile->slug) }}" class="flex flex-col items-center">
                        <div class="w-full h-14 overflow-hidden border border-gray-600">
                            <img src="/{{ $profile->background_image_path ? $profile->background_image_path : 'storage/background_photos/default.png' }}"
                                alt="background image" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute top-3 z-10 w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md">
                            <img src="/{{ $profile->profile_image_path }}" alt="profile image"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-0 p-1">
                            <p class="text-sm text-center mt-9 line-clamp-1"><strong>{{ $profile->full_name }}</strong>
                            </p>
                            <p class="text-xs md:text-sm text-center text-gray-700 line-clamp-2">{{ $profile->headline }}</p>
                            <p class="text-xs md:text-sm text-center text-gray-600 line-clamp-1">{{ $profile->location }}</p>
                            <p class="text-xs md:text-sm text-center text-gray-500 line-clamp-3 mt-2">
                                {{ $profile->bio }}
                            </p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="mb-4">
            {{ $profiles->links() }}
        </div>
    </section>

</x-app-layout>
