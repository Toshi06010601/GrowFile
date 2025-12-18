<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            Study calendar
        </h2>
    </x-slot>
    <div id="calendar"></div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin],
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: '/events',
                // Refetch if view changes
                viewDidMount: function(info) {
                    calendar.refetchEvents();
                },
                eventBackgroundColor: 'rgba(22, 101, 52, 0.9)', // green-600 with opacity
                eventBorderColor: 'rgba(22, 101, 52, 1)', // green-600 solid
                eventTextColor: '#ffffff'
            });
            calendar.render();
        });
    </script>
</x-section>
