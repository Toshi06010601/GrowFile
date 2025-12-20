<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            Study diary
        </h2>
    </x-slot>
    <div class="w-full overflow-hidden">
        <div id="calendar" class="max-w-full"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // Helper function to update title
            function updateTitle(start, end, viewType) {
                var titleEl = document.querySelector('.fc-toolbar-title');
                var isMobile = window.innerWidth < 768;

                var endDate = new Date(end);
                endDate.setDate(endDate.getDate() - 1);
                var startYear = start.getFullYear();
                var endYear = endDate.getFullYear();

                if (viewType === 'timeGridWeek') {
                    titleEl.textContent = startYear === endYear ? startYear : `${startYear}-${endYear}`;
                } else {
                    var currentDate = calendar.getDate();
                    titleEl.textContent = currentDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: isMobile ? 'short' : 'long'
                    });
                }
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin],
                initialView: window.innerWidth < 768 ? 'timeGridWeek' : 'dayGridMonth',

                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },

                height: 'auto',
                contentHeight: 'auto',
                aspectRatio: window.innerWidth < 768 ? 1 : 1.8,

                views: {
                    timeGridWeek: {
                        dayHeaderFormat: {
                            weekday: 'short',
                            month: 'numeric',
                            day: 'numeric',
                            omitCommas: true
                        }
                    },
                    dayGridMonth: {
                        dayHeaderFormat: window.innerWidth < 768 ? {
                            weekday: 'narrow'
                        } : {
                            weekday: 'short'
                        }
                    }
                },

                events: '/events',

                // Update title when dates change
                datesSet: function(info) {
                    updateTitle(info.start, info.end, calendar.view.type);
                    calendar.refetchEvents();
                },

                eventBackgroundColor: 'rgba(22, 101, 52, 0.9)',
                eventBorderColor: 'rgba(22, 101, 52, 1)',
                eventTextColor: '#ffffff'
            });

            calendar.render();
        });
    </script>

    <style>
        /* Make calendar more responsive */
        #calendar {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            #calendar {
                font-size: 12px;
            }

            .fc-toolbar-title {
                font-size: 1.2rem !important;
            }

            .fc-button {
                padding: 0.3rem 0.5rem !important;
                font-size: 0.875rem !important;
            }

            .fc-daygrid-event {
                font-size: 0.75rem !important;
            }
        }

        @media (max-width: 480px) {
            #calendar {
                font-size: 11px;
            }

            .fc-toolbar-title {
                font-size: 1rem !important;
            }

            .fc-button {
                padding: 0.25rem 0.4rem !important;
                font-size: 0.75rem !important;
            }
        }
    </style>
</x-section>
