import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction'; // for selectable
import dayGridPlugin from '@fullcalendar/daygrid'; // for dayGridMonth view
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import itLocale from "@fullcalendar/core/locales/es";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    if (calendarEl != null) {
        var datos = JSON.parse(calendarEl.getAttribute("data"));
        let calendar = new Calendar(calendarEl, {
            locale: itLocale,
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            initialView: "timeGridWeek",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek",
            },
            events: datos,
        });

        calendar.render();
    }
});