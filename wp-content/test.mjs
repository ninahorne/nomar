import { events } from './events.mjs';
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
async function main() {
  const wpEvents = await fetchAllEvents();
  for (const event of events) {
    // check if event exists in wordpress
    
    // find corresponding date by using the event_id field
    // print the event date, start time, and end time for both wordpress and the API
  }
}
