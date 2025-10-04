<header class="flex flex-row justify-between">
    <h2 class="text-2xl font-medium text-gray-900">
        {{ __('Study Records') }}
    </h2>
    <img src=" {{ asset('images/icons/add.svg') }}" alt="add-icon" class="w-7 px-1 cursor-pointer hover:scale-110"
        x-data="" x-on:click="$dispatch('open-modal', 'edit-study-record')">
</header>

<ul class="flex flex-col max-h-96 pr-5 overflow-y-scroll">
    <li class="flex flex-col p-3 gap-1 border shadow-md rounded-md">
        <div class="flex justify-between">
            <h2>Today</h2>
            <h2>3h15m</h2>
        </div>
        <hr class="h-0.5 border-none bg-gray-500">
        <div class="flex flex-col gap-1">
            <p>Learn about Figma</p>
            <div class="flex flex-row justify-between">
                <ul>
                    <li>
                        <x-tag>Figma</x-tag>
                    </li>
                </ul>
                <img src=" {{ asset('images/icons/edit-pen.svg') }}" alt="edit-icon"
                    class="w-7 px-1 cursor-pointer hover:scale-110" x-data=""
                    x-on:click="$dispatch('open-modal', 'edit-study-record')">
            </div>
        </div>
    </li>
</ul>
