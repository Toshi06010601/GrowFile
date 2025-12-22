<x-section>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-medium text-gray-900">
            Study diary
        </h2>
    </x-slot>
    <div class="w-full overflow-hidden">
        <div id="calendar" class="max-w-full"></div>
        {{-- <div id="fc-title-below" class="text-center text-xl font-semibold mt-3 mb-5"></div> --}}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin],
                initialView: 'dayGridMonth',
                firstDay: 1,

                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                height: 'auto',
                contentHeight: 'auto',
                aspectRatio: window.innerWidth < 768 ? 1 : 1.8,
                events: '/events?userId={{ $userId }}',

                // Update title when dates change
                datesSet: function(info) {
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

        /* Force toolbar to wrap and put title on its own line */
        .fc .fc-toolbar {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 1rem !important;
        }

        .fc .fc-toolbar-chunk:nth-child(1) {
            order: 1;
            flex: 0 0 auto;
        }

        .fc .fc-toolbar-chunk:nth-child(2) {
            order: 3;
            flex: 0 0 100%;
            margin-top: 1rem;
        }

        .fc .fc-toolbar-chunk:nth-child(3) {
            order: 2;
            flex: 0 0 auto;
            margin-left: auto;
        }

        .fc .fc-toolbar-title {
            text-align: center;
            font-size: 24px !important;
            font-weight: 400;
            color: #4B5563;
        }
    </style>
</x-section>
