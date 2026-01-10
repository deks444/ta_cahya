

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

export function calendarInit() {
  const calendarWrapper = document.querySelector("#calendar");

  if (calendarWrapper) {
    // Calendar Date variable
    const newDate = new Date();
    const getDynamicMonth = () => {
      const month = newDate.getMonth() + 1;
      return month < 10 ? `0${month}` : `${month}`;
    };

    // Calendar Modal Elements
    const getModalTitleEl = document.querySelector("#event-title");
    const getModalStartDateEl = document.querySelector("#event-start-date");
    const getModalEndDateEl = document.querySelector("#event-end-date");
    const getModalAddBtnEl = document.querySelector(".btn-add-event");
    const getModalUpdateBtnEl = document.querySelector(".btn-update-event");
    const getModalHeaderEl = document.querySelector("#eventModalLabel");

    const calendarsEvents = {
      Danger: "danger",
      Success: "success",
      Primary: "primary",
      Warning: "warning",
    };

    // Calendar Elements and options
    const calendarEl = document.querySelector("#calendar");

    const calendarHeaderToolbar = {
      left: "prev,next addEventButton",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    };

    const calendarEventsList = [
      {
        id: "1",
        title: "Latihan Fisik",
        start: `${newDate.getFullYear()}-${getDynamicMonth()}-01`,
        extendedProps: { calendar: "Danger", coach: "Budi Santoso" },
      },
      {
        id: "2",
        title: "Teknik Dasar",
        start: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
        end: `${newDate.getFullYear()}-${getDynamicMonth()}-10`,
        extendedProps: { calendar: "Success", coach: "Siti Rahma" },
      },
      {
        id: "3",
        title: "Sparring",
        start: `${newDate.getFullYear()}-${getDynamicMonth()}-09T16:00:00`,
        extendedProps: { calendar: "Primary", coach: "Agus Salim" },
      },
      {
        id: "4",
        title: "Review Video",
        start: `${newDate.getFullYear()}-${getDynamicMonth()}-16T16:00:00`,
        extendedProps: { calendar: "Warning", coach: "Dewi Putri" },
      },
      {
        id: "5",
        title: "Latihan Beban",
        start: `${newDate.getFullYear()}-${getDynamicMonth()}-11`,
        end: `${newDate.getFullYear()}-${getDynamicMonth()}-13`,
        extendedProps: { calendar: "Danger", coach: "Rudi Hartono" },
      },
    ];

    // ... (kode lain tetap sama sampai eventContent)

    // Initialize Calendar
    const calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      selectable: true,
      initialView: "dayGridMonth",
      initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
      headerToolbar: calendarHeaderToolbar,
      events: calendarEventsList,
      select: calendarSelect,
      eventClick: calendarEventClick,
      displayEventTime: false, // Hide time display
      dayMaxEvents: true, // Allow "more" link when too many events
      customButtons: {
        addEventButton: {
          text: "Add Event +",
          click: calendarAddEvent,
        },
      },
      // Optional: Custom event content without time
      eventContent(eventInfo) {
        const colorClass = `fc-bg-${eventInfo.event.extendedProps.calendar.toLowerCase()}`
        const coachName = eventInfo.event.extendedProps.coach ? eventInfo.event.extendedProps.coach : '-';
        return {
          html: `
            <div class="event-fc-color flex flex-col justify-start items-start fc-event-main ${colorClass} p-1.5 rounded-md w-full overflow-hidden leading-tight shadow-sm border-l-2 border-white/30">
              <div class="fc-event-title text-xs font-bold w-full truncate mb-0.5" title="${eventInfo.event.title}">${eventInfo.event.title}</div>
              <div class="text-[10px] w-full truncate mb-0.5" title="${coachName}">(${coachName})</div>
              <div class="fc-event-time text-[10px] font-medium opacity-90 whitespace-nowrap">${eventInfo.timeText || 'Full Day'}</div>
            </div>
          `,
        }
      },
    });

    // Update Calendar Event
    // if (getModalUpdateBtnEl) {
    //   getModalUpdateBtnEl.addEventListener("click", () => {
    //     const getPublicID = getModalUpdateBtnEl.dataset.fcEventPublicId;
    //     const getTitleUpdatedValue = getModalTitleEl.value;
    //     const setModalStartDateValue = getModalStartDateEl.value;
    //     const setModalEndDateValue = getModalEndDateEl.value;
    //     const getEvent = calendar.getEventById(getPublicID);
    //     const getModalUpdatedCheckedRadioBtnEl = document.querySelector(
    //       'input[name="event-level"]:checked'
    //     );

    //     const getModalUpdatedCheckedRadioBtnValue =
    //       getModalUpdatedCheckedRadioBtnEl
    //         ? getModalUpdatedCheckedRadioBtnEl.value
    //         : "";

    //     if (getEvent) {
    //       getEvent.setProp("title", getTitleUpdatedValue);
    //       getEvent.setDates(setModalStartDateValue, setModalEndDateValue);
    //       getEvent.setExtendedProp("calendar", getModalUpdatedCheckedRadioBtnValue);
    //     }

    //     closeModal();
    //   });
    // }
    if (getModalUpdateBtnEl) {
      getModalUpdateBtnEl.addEventListener("click", () => {
        const getPublicID = getModalUpdateBtnEl.dataset.fcEventPublicId;
        const getTitleUpdatedValue = getModalTitleEl.value;
        const setModalStartDateValue = getModalStartDateEl.value;
        const setModalEndDateValue = getModalEndDateEl.value;
        const getEvent = calendar.getEventById(getPublicID);
        const getModalUpdatedCheckedRadioBtnEl = document.querySelector(
          'input[name="event-level"]:checked'
        );

        const getModalUpdatedCheckedRadioBtnValue =
          getModalUpdatedCheckedRadioBtnEl
            ? getModalUpdatedCheckedRadioBtnEl.value
            : "";

        if (getEvent) {
          // Remove the old event
          getEvent.remove();

          // Add updated event with all properties
          calendar.addEvent({
            id: getPublicID,
            title: getTitleUpdatedValue,
            start: setModalStartDateValue,
            end: setModalEndDateValue,
            allDay: true,
            extendedProps: { calendar: getModalUpdatedCheckedRadioBtnValue },
          });
        }

        closeModal();
      });
    }

    // Add Calendar Event
    if (getModalAddBtnEl) {
      getModalAddBtnEl.addEventListener("click", () => {
        const getModalCheckedRadioBtnEl = document.querySelector(
          'input[name="event-level"]:checked'
        );

        const getTitleValue = getModalTitleEl.value;
        const setModalStartDateValue = getModalStartDateEl.value;
        const setModalEndDateValue = getModalEndDateEl.value;
        const getModalCheckedRadioBtnValue = getModalCheckedRadioBtnEl
          ? getModalCheckedRadioBtnEl.value
          : "";

        calendar.addEvent({
          id: Date.now().toString(),
          title: getTitleValue,
          start: setModalStartDateValue,
          end: setModalEndDateValue,
          allDay: true,
          extendedProps: { calendar: getModalCheckedRadioBtnValue },
        });

        closeModal();
      });
    }

    // Render Calendar
    calendar.render();

    // Close modal event listeners
    document.querySelectorAll(".modal-close-btn").forEach((btn) => {
      btn.addEventListener("click", closeModal);
    });

    // Close when clicking outside modal
    window.addEventListener("click", (event) => {
      const modal = document.getElementById("eventModal");
      if (event.target === modal) {
        closeModal();
      }
    });
  }
}

export default calendarInit;
