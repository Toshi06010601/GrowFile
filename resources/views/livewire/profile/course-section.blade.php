<x-section class="h-full" id="course-section">
    {{-- Header area --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            Courses
        </h2>

        {{-- button to add a new reading log --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click="
                $dispatch('set-course', { id: null , 
                isOwner: {{ $isOwner ? 'true' : 'false' }} });" />
        @endif
    </x-slot>

    {{-- Display study records below --}}
    <ul class="flex flex-col max-h-56 sm:pr-5 border-2 overflow-y-auto rounded-sm text-base sm:text-xl">
        @foreach ($courses as $course)
            <li wire:key="{{ $course->id }}"
                class="relative flex p-1 gap-1 border-b-2 last:border-b-0 items-center bg-white border-brand-secondary-100 transition hover:shadow-lg">
                {{-- Left: Image (responsive) --}}
                <div class="flex justify-center items-center">
                    @if ($course->progress_status == 'in_progress')
                        <img src="{{ asset('images/icons/in-progress.svg') }}" alt="in-progress"
                            class="w-8 px-1 cursor-pointer hover:scale-110">
                    @else
                        <img src="{{ asset('images/icons/completed.svg') }}" alt="completed"
                            class="w-8 px-1 cursor-pointer hover:scale-110">
                    @endif
                </div>

                {{-- Right: Content area --}}
                <div class="flex-1 pl-3 py-2 px-3 flex flex-col">
                    <div class="flex justify-between">
                        {{-- Provider --}}
                        <p class="text-brand-secondary-500 text-xs line-clamp-1">
                            Provided by {{ $course->provider }}
                        </p>
    
                        {{-- Date --}}
                        @if ($course->completion_date)
                            <div class="flex justify-end">
                                <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                    Completed at {{ $course->completion_date->format('d/m/Y') }}
                                </p>
                            </div>
                        @else
                            <div class="flex justify-end">
                                <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                    In progress
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Name --}}
                    <p class="text-base font-semibold text-brand-secondary-900 line-clamp-1">
                        {{ $course->name }}
                    </p>
                </div>


                {{-- Action button --}}
                @if ($isOwner)
                    <button type="button"
                        @click.stop="$dispatch('set-course', { id: {{ $course->id }}, isOwner: true })"
                        class="absolute bottom-1 right-1 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md hover:bg-white hover:shadow-lg transition-all">
                        <svg class="w-4 h-4 text-brand-secondary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                @else
                    <button type="button"
                        @click.stop="$dispatch('set-course', { id: {{ $course->id }}, isOwner: false })"
                        class="absolute bottom-1 right-1 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md hover:bg-white hover:shadow-lg transition-all">
                        <svg class="w-4 h-4 text-brand-secondary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                    </button>
                @endif
            </li>
        @endforeach

    </ul>

</x-section>
