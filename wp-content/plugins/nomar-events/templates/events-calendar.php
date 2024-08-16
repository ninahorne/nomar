<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slugify@1.6.6/slugify.min.js"></script>
<script src="/wp-content/plugins/nomar-events/vendor/js/full-calendar.global.min.js"></script>
<script src="/wp-content/plugins/nomar-events/vendor/js/micro-modal.min.js"></script>
<script src="/wp-content/plugins/nomar-events/public/js/nomar-events-public.js"></script>
<link rel="stylesheet" src="/wp-content/plugins/nomar-events/public/css/nomar-events-public.css" />
<div id="filters">
  <select name="category" id="category">
    <option value=""> All Categories</option>
  </select>
  <select name="location" id="location">
    <option value=""> All Locations</option>
  </select>
</div>
<div id="desktopCalendar"></div>
<div id="mobileCalendar"></div>
<div class="modal micromodal-slide" id="eventModal" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="eventModal-title">
      <header class="modal__header">
        <button id="backButton" data-micromodal-close type="button" title="Back" aria-pressed="false" class="modal__back"><span class="fc-icon fc-icon-chevron-left"></span>Back</button>
      </header>
      <main class="modal__content" id="eventModal-content">
        <h2 class="modal__title" id="eventModal-title">
        </h2>

        <div class="modal__details">
          <p class="details__title">Details</p>
          <div class="details__grid">
            <div id="gridLeft" class="grid__left">
              <p class="grid__label">Available Seats:</p>
              <p id="availableSeats"></p>
              <p class="grid__label">Member Price:</p>
              <p id="memberPrice"></p>
              <p class="grid__label">Non-Member Price:</p>
              <p id="nonMemberPrice"></p>

            </div>
            <div id="gridRight" class="grid__right">
              <p class="grid__label">Instructor:</p>
              <p id="instructor"></p>
              <p class="grid__label">Date:</p>
              <p id="date"></p>
              <p class="grid__label">Time</p>
              <p id="time"></p>
            </div>
          </div>


        </div>

        <div class="modal__description">
          <p id="description"></p>

        </div>
        <div class="modal__footer">
          <a href="" target="_blank" id="register">Register</a>

        </div>
      </main>

    </div>
  </div>
</div>