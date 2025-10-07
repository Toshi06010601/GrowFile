<x-profile-section.layout sectionTitle="Study Records" modalName="edit-study-record">

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
                            <x-profile-section.partials.tag>Figma</x-profile-section.partials.tag>
                        </li>
                    </ul>
                    <x-profile-section.partials.edit-icon modalName="edit-study-record"></x-profile-section.partials.edit-icon>
                </div>
            </div>
        </li>
    </ul>

</x-profile-section.layout>
