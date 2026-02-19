{{-- <div> --}}
<div x-data="{
    calendar: null,
    init() {
        this.mountCalendar();
        window.addEventListener('livewire:navigated', () => this.mountCalendar());
    },
    mountCalendar() {
        const el = document.getElementById('calendar');
        if (!el) return;
        if (this.calendar) {
            this.calendar.destroy();
            this.calendar = null;
        }
        this.calendar = new FullCalendar.Calendar(el, {
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
            viewDidMount: () => this.calendar.refetchEvents(),
            eventBackgroundColor: 'rgba(13, 89, 2, 0.8)',
            eventBorderColor: 'rgba(13, 89, 2, 0.8)',
            eventTextColor: '#ffffff'
        });
        this.calendar.render();
    },
    updateCalendarSize() {
        if (this.calendar) {
            this.calendar.updateSize();
        }
    }
}" @calendar-update-size="updateCalendarSize()" x-init="init()">
    <div class="w-full overflow-hidden">
        <div id="calendar" x-ignore class="max-w-full"></div>
    </div>

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
