<div>
    {{-- Display Calendar here --}}
    <div class="w-full overflow-hidden">
        <div id="calendar" class="max-w-full"></div>
    </div>

    {{-- Make FullCalendar instance and insert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            window.calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin],
                initialView: 'dayGridMonth',
                firstDay: 1, //Start from Monday

                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                height: 'auto',
                contentHeight: 'auto',
                aspectRatio: window.innerWidth < 768 ? 1 : 1.8,
                events: '/events?userId={{ $userId }}',
                
                // Refetch if view changes
                viewDidMount: function(info) {
                    calendar.refetchEvents();
                },

                eventBackgroundColor: 'rgba(13, 89, 2, 0.8)',
                eventBorderColor: 'rgba(13, 89, 2, 0.8)',
                eventTextColor: '#ffffff'
            });

            window.calendar.render();
        });
    </script>

    <style>
        /* Make calendar more responsive */
        #calendar {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            #calendar {
                font-size: 12px;
            }

            .fc-toolbar-title {
                font-size: 1.2rem !important;
            }

            .fc-button {
                padding: 0.5rem 1rem !important;
                font-size: 0.875rem !important;
            }

            .fc-daygrid-event {
                font-size: 0.75rem !important;
            }
        }

        @media (max-width: 480px) {
            #calendar {
                font-size: 12px;
            }

            .fc-toolbar-title {
                font-size: 1rem !important;
            }

            .fc-button {
                padding: 0.4rem 0.6rem !important;
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
</div>
