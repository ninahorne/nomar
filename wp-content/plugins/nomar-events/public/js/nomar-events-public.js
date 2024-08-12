(function ($) {
  'use strict';
  const apiURL =
    'https://api.tangilla.com/event/v1/feed/4420/live?include_current_month_events=true';

  $(window).load(function () {
    MicroModal.init();

    const BLUE = '#142665';
    const YELLOW = '#f99e29';
    const TRANS_BLUE = 'rgba(20, 38, 101, 0.3)';
    const TRANS_YELLOW = 'rgba(249, 158, 41, 0.3)';

    let events;
    let dayGridCalendar;
    let listWeekCalendar;

    const formatMoney = (input = 0) => {
      return '$' + input?.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    };
    const getRow = (label, value) =>
      `<div class="grid__row"><p class="grid__label">${label}: </p> <p>${value}</p></div>`;
    const getFormattedTime = (timeString) => {
      const [hours, minutes] = timeString.split(':').map(Number);

      let formattedTime;

      if (hours === 12 && minutes === 0) {
        formattedTime = `12pm`; // Noon
      } else if (hours === 0 || hours === 24) {
        formattedTime = `12am`; // Midnight
      } else if (hours < 12) {
        formattedTime = `${hours === 0 ? '12' : hours}:${
          minutes < 10 ? '0' : ''
        }${minutes}am`;
      } else {
        formattedTime = `${hours === 12 ? '12' : hours - 12}:${
          minutes < 10 ? '0' : ''
        }${minutes}pm`;
      }

      return formattedTime;
    };

    const getTimeString = (start, end) => {
      return `${getFormattedTime(start)} - ${getFormattedTime(end)}`;
    };
    const getDate = (input) => {
      const timeZone = 'UTC'; // Set your desired time zone here

      const options = {
        weekday: 'long',
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        timeZone: timeZone,
      };

      const formattedDate = new Intl.DateTimeFormat('en-US', options).format(
        new Date(`${input}T00:00:00.000Z`),
      );
      return formattedDate;
    };

    const getRightDetailsContent = (event) => {
      const rows = [];
      if (event.instructor_name) {
        rows.push(getRow('Speaker', event.instructor_name));
      }

      rows.push(getRow('Date', getDate(event.event_date)));
      rows.push(
        getRow('Time', getTimeString(event.start_time, event.end_time)),
      );
      rows.push(getRow('Location', event.location));
      if (event.location_type == 'physical') {
        rows.push(
          getRow('Address', event.location_address?.replaceAll(' ,', ',')),
        );
        if (event.room) {
          rows.push(getRow('Room', event.room));
        }
      }

      return rows.join('');
    };
    const getLeftDetailsContent = (event) => {
      const rows = [];
      if (event.capacity && event.registered) {
        rows.push(
          getRow('Available Tickets', event.capacity - event.registered),
        );
      }
      if (event.member_price != null && event.member_price != undefined) {
        rows.push(getRow('Member Price', formatMoney(event.member_price)));
      }
      if (event.price != null && event.price != undefined) {
        rows.push(getRow('Non-Member Price', formatMoney(event.price)));
      }
      if (event.member_only) {
        rows.push(getRow('Members Only', 'Yes'));
      }
      if (event.event_type == 'class') {
        rows.push(getRow('CE Type', event.ce_type_name));
        rows.push(getRow('CE Credits', event.ce_credits));
      }
      return rows.join('');
    };

    const getCalendar = (el, initialView) => {
      const cal = new FullCalendar.Calendar(el, {
        initialView,
        events,
        eventDisplay: 'block',
        eventClassNames: 'tangilla-event',
        headerToolbar: {
          start: 'prev',
          center: 'title',
          end: 'next',
        },

        eventClick: function (info) {
          const slug = info.event._def.extendedProps.slug;
          const currentUrl = window.location.href;
          const urlParams = new URLSearchParams(window.location.search);

          urlParams.set('event', slug);
          const updatedUrl =
            currentUrl.split('?')[0] + '?' + urlParams.toString();

          window.history.replaceState({}, '', updatedUrl);

          openEvent(slug);
        },
        views: {
          dayGridMonth: {
            titleFormat: { month: 'long' },
          },
        },
        dayHeaderFormat: {
          weekday: 'long',
        },
      });
      return cal;
    };

    const openEvent = (slug) => {
      const event = events.find((event) => event.slug == slug);
      const modalId = 'eventModal';
      const gridLeft = document.getElementById('gridLeft');
      const gridRight = document.getElementById('gridRight');

      gridLeft.innerHTML = getLeftDetailsContent(event);
      gridRight.innerHTML = getRightDetailsContent(event);

      const modalEl = document.getElementById(modalId);
      const descriptionEl = document.getElementById('description');
      descriptionEl.innerHTML = event.event_description;
      const titleEl = document.getElementById('eventModal-title');
      titleEl.innerText = event.event_title;
      const registerEl = document.getElementById('register');
      registerEl.setAttribute('href', event.registration_link);

      MicroModal.show(modalId, {
        onClose: () => {
          function removeQueryParam(paramName) {
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);
            url.searchParams.delete(paramName);
            var updatedUrl = url.toString();
            window.history.replaceState({}, '', updatedUrl);
          }

          // Call the function to remove the "event_id" query parameter
          removeQueryParam('event');
        },
      });
    };

    const checkForOpenEvent = () => {
      const urlParams = new URLSearchParams(window.location.search);
      const event_id = urlParams.get('event');
      if (event_id) {
        openEvent(event_id);
      }
    };
    $.ajax({
      url: apiURL,
      method: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log({ data });
        let slugSet = new Set();
        events = data.map((event) => {
          let slug = slugify(`${event.event_title}`, {
            lower: true,
          });
          let index = 1;
          while (slugSet.has(slug)) {
            slug = `${slug}-${index}`;
            index++;
          }
          slugSet.add(slug);
          return {
            ...event,
            title: event.event_title,
            date: event.event_date,
            color: event.event_type == 'class' ? TRANS_BLUE : TRANS_YELLOW,
            borderColor: event.event_type == 'class' ? BLUE : YELLOW,
            start: `${event.event_date}T${event.start_time}`,
            end: `${event.event_date}T${event.end_time}`,
            slug,
          };
        });

        checkForOpenEvent();
        const desktopCal = document.getElementById('desktopCalendar');
        const mobileCal = document.getElementById('mobileCalendar');

        dayGridCalendar = getCalendar(desktopCal, 'dayGridMonth');
        listWeekCalendar = getCalendar(mobileCal, 'listMonth');

        dayGridCalendar.render();
        listWeekCalendar.render();
      },
      error: function (xhr, status, error) {
        // Handle any errors that occur during the AJAX request
        console.error('Error: ' + error);
        $('#api-data').html(
          'An error occurred while fetching data from the API.',
        );
      },
    });
  });
})(jQuery);
