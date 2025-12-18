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
                plugins: [FullCalendar.dayGridPlugin],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek'
                },
                events: '/events', // サーバー側のイベントデータを取得するAPI
                eventBackgroundColor: 'rgba(22, 101, 52, 0.9)', // green-600 with opacity
                eventBorderColor: 'rgba(22, 101, 52, 1)', // green-600 solid
                eventTextColor: '#ffffff'
            });
            calendar.render();
        });
    </script>
</x-section>
