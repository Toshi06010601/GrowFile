import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//Import ChartJS and make it global object
import Chart from 'chart.js/auto';
window.Chart = Chart;

//Import FullCalendarJS and make it global object
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

window.FullCalendar = {
    Calendar: Calendar,
    dayGridPlugin: dayGridPlugin,
    timeGridPlugin: timeGridPlugin,
    interactionPlugin: interactionPlugin
};

//Import SweetAlertJS and make it global object
import Swal from 'sweetalert2';
window.Swal = Swal;
