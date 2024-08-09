import './app.js';
import { getAuthHeader, formatDateString } from './app.js';
import { eventHtmlBuilder } from './htmlBuilder.js';

let isMyEventsChecked = false

const eventStatus = {
  event_pending: 'Pending',
  event_full: 'Full',
  event_finished: 'Finished',
}

const buildEventsHtml = (events) => {
  return events.map(event => eventHtmlBuilder(event, isMyEventsChecked)).join('');
}
const buildErrorHtml = (error) => {
  return `
    <div class='event'>
      <h3>Error</h3>
      <p>${error}</p>
    </div>
  `
}

const onSuccess = (res) => {
  const { data } = res.data
  const eventsContainer = document.getElementById('events-container');
  eventsContainer.innerHTML = buildEventsHtml(data);
}

const onError = (err) => {
  console.log(err)
  const { data } = err.response.data;
  const eventsContainer = document.getElementById('events-container');
  eventsContainer.innerHTML = buildErrorHtml(data.error);
}

const getEvents = () => {
  isMyEventsChecked = document.getElementById('my-events').checked;
  
  axios.get(`api/events${isMyEventsChecked ? '/me' : ''}`, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(onSuccess).catch(onError);
}

getEvents();

document.getElementById('my-events').addEventListener('change', async () => await getEvents());