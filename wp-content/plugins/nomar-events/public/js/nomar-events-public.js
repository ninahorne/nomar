(function ($) {
  'use strict';
  const apiBaseURL = 'https://nomar.org/wp-json/wp/v2/events';

  $(window).load(async function () {
    MicroModal.init();

    const BLUE = '#142665';
    const YELLOW = '#f99e29';
    const TRANS_BLUE = 'rgba(20, 38, 101, 0.3)';
    const TRANS_YELLOW = 'rgba(249, 158, 41, 0.3)';

    let events = [];
    let eventsCache = [];
    let dayGridCalendar;
    let listWeekCalendar;
    let categories = [];
    let locations = [];

    const addCategories = async (eventCategories) => {
      eventCategories.forEach((cat) => {
        if (!categories.includes(cat)) {
          categories.push(cat);
        }
      });
      categories = categories.sort();
    };

    const addLocations = (eventLocation) => {
      if (!locations.includes(eventLocation)) {
        locations.push(eventLocation);
      }
      locations = locations.sort();
    };

    const setUpFilterDropdowns = () => {
      const categoriesSelect = document.getElementById('category');
      const locationsSelect = document.getElementById('location');

      // Generate dropdown options, including "All Categories" and "All Locations"
      const catHTML = categories
        .map((cat) => `<option value="${cat}">${cat}</option>`)
        .join('');
      const locHTML = locations
        .map((loc) => `<option value="${loc}">${loc}</option>`)
        .join('');

      // Set default options as "All Categories" and "All Locations"
      categoriesSelect.innerHTML = `<option value="" selected>All Categories</option>${catHTML}`;
      locationsSelect.innerHTML = `<option value="" selected>All Locations</option>${locHTML}`;

      // Attach event listeners to dropdowns
      categoriesSelect.addEventListener('change', applyFilters);
      locationsSelect.addEventListener('change', applyFilters);
    };

    const applyFilters = () => {
      const categoryValue = document.getElementById('category').value;
      const locationValue = document.getElementById('location').value;

      // Filter events based on selected category and location
      events = eventsCache.filter((event) => {
        const categoryMatch = categoryValue
          ? event.category_names.includes(categoryValue)
          : true; // If "All Categories" is selected, include all categories
        const locationMatch = locationValue
          ? event.location === locationValue
          : true; // If "All Locations" is selected, include all locations

        return categoryMatch && locationMatch;
      });

      reRenderCalendars();
    };

    const reRenderCalendars = () => {
      dayGridCalendar.removeAllEvents();
      listWeekCalendar.removeAllEvents();

      dayGridCalendar.addEventSource(events);
      listWeekCalendar.addEventSource(events);

      dayGridCalendar.render();
      listWeekCalendar.render();
    };

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
      const timeZone = 'America/Chicago'; // Set the desired time zone

      // Handle MM/DD/YYYY format
      const parts = input.split('/');
      if (parts.length === 3) {
        const [month, day, year] = parts;
        input = `${year}-${month}-${day}`; // Convert to YYYY-MM-DD format
      }

      const options = {
        weekday: 'long',
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        timeZone: timeZone,
      };

      try {
        const formattedDate = new Intl.DateTimeFormat('en-US', options).format(
          new Date(`${input}T00:00:00`),
        );
        return formattedDate;
      } catch (error) {
        console.error('Error formatting date:', error, { input });
        return input; // Return the original input if parsing fails
      }
    };

    const getRightDetailsContent = (event) => {
      const rows = [];
      if (event.instructor_name) {
        rows.push(getRow('Speaker', event.instructor_name));
      }
      console.log(getDate(event.event_date));
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
      if (event.availability) {
        rows.push(getRow('Available Tickets', event.availability));
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

      const descriptionEl = document.getElementById('description');
      descriptionEl.innerHTML = event.event_description;
      const titleEl = document.getElementById('eventModal-title');
      titleEl.innerText = event.event_title;
      const registerEl = document.getElementById('register');
      registerEl.setAttribute('href', event.registration_link);
      const categoryEl = document.getElementById('modalCategories');
      const categories = event.category_names;
      categoryEl.innerHTML = categories
        .map(
          (cat, index) =>
            `<a class="category-pill" href="/category/${
              event.category_slugs?.length ? event.category_slugs[index] : '#'
            }">${cat}</a>`,
        )
        .join('');

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

    // Fetch all pages of events and combine them
    const fetchAllEvents = async () => {
      let allEvents = [];
      let page = 1;
      let perPage = 100;
      let morePages = true;

      while (morePages) {
        const response = await $.ajax({
          url: `${apiBaseURL}?per_page=${perPage}&page=${page}`,
          method: 'GET',
          dataType: 'json',
        });

        allEvents = [...allEvents, ...response];

        if (response.length < perPage) {
          morePages = false;
        } else {
          page++;
        }
      }

      return allEvents;
    };
    const formatDate = (date) => {
      // Check if the input date is a string and handle non-standard formats
      if (date.includes('/')) {
        const splitDate = date.split('/');
        const year = splitDate[2];
        const month = splitDate[1];
        const day = splitDate[0];
        return `${year}-${month}-${day}`;
      } else {
        const splitDate = date.split('-');
        const year = splitDate[0];
        const month = splitDate[1];
        const day = splitDate[2];
        return `${year}-${month}-${day}`;
      }
    };
    // Fetch all events
    try {
      events = await fetchAllEvents();
      let slugSet = new Set();
      events = events.map((event) => {
        let slug = event.slug;
        let index = 1;
        while (slugSet.has(slug)) {
          slug = `${slug}-${index}`;
          index++;
        }
        slugSet.add(slug);
        const date = formatDate(event.event_date);
        return {
          ...event,
          title: event.event_title,
          date,
          color: event.event_type == 'class' ? TRANS_BLUE : TRANS_YELLOW,
          borderColor: event.event_type == 'class' ? BLUE : YELLOW,
          start: `${date}T${event.start_time}`,
          end: `${date}T${event.end_time}`,
          slug,
        };
      });
      eventsCache = events;

      events.forEach((e) => {
        addCategories(e.category_names);
        addLocations(e.location);
      });

      setUpFilterDropdowns();

      checkForOpenEvent();
      const desktopCal = document.getElementById('desktopCalendar');
      const mobileCal = document.getElementById('mobileCalendar');

      dayGridCalendar = getCalendar(desktopCal, 'dayGridMonth');
      listWeekCalendar = getCalendar(mobileCal, 'listMonth');

      dayGridCalendar.render();
      listWeekCalendar.render();
    } catch (error) {
      console.error('Error fetching events:', error);
      $('#api-data').html(
        'An error occurred while fetching data from the API.',
      );
    }
  });
})(jQuery);
