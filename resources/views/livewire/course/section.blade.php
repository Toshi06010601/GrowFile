<x-section class="h-full" id="course-section">
    {{-- Header area --}}
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-brand-secondary-900">
            Courses
        </h2>

        {{-- button to add a new reading log --}}
        @if ($isOwner)
            <x-section.add-icon x-data=""
                x-on:click.stop="
                $dispatch('set-course', { id: null });" />
        @endif
    </x-slot>

    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load courses. Please try again.</x-loading-error>
    @endif

    {{-- Display courses below --}}
    @if (!$hasError)
        {{-- Display if courses data exists --}}
        @if (count($this->courses) > 0)
            <ul class="flex flex-col max-h-56  border-2 overflow-y-auto rounded-sm text-base sm:text-xl">
                @foreach ($this->courses as $course)
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
                                @if ($course->progress_status === 'completed')
                                    <div class="flex justify-end items-center gap-2">
                                        <p class="text-brand-secondary-500 text-xs line-clamp-1">
                                            Completed
                                            {{ $course->completion_date ? 'at ' . $course->completion_date->format('d/m/Y') : '' }}
                                        </p>
                                        @if ($course->certificate_url)
                                            <a href="{{ $course->certificate_url }}" target="blank">
                                                <img src="{{ asset('images/icons/course.svg') }}" alt=""
                                                    class="size-4 mx-auto">
                                            </a>
                                        @endif
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
                                <a href="{{ $course->course_url }}" target="blank">
                                    {{ $course->name }}
                                </a>
                            </p>
                        </div>


                        {{-- Action button --}}
                        @if ($isOwner)
                            <x-section.edit-icon x-data=""
                                x-on:click.stop="$dispatch('set-course', { id: {{ $course->id }} })"
                                class="absolute bottom-1 right-1" />
                        @endif
                    </li>
                @endforeach
            @else
                {{-- Display if no courses exists --}}
                <x-no-data-to-display fileName="course.svg">No courses to display</x-no-data-to-display>
        @endif
    @endif


    </ul>

</x-section>
