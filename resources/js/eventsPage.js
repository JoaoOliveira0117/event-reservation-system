import './app.js';
import { getAuthHeader } from './app.js';

let isMyEventsChecked = false

const eventStatus = {
  event_pending: 'Pending',
  event_full: 'Full',
  event_finished: 'Finished',
}

const getCurrentUserId = () => {
  return localStorage.getItem('userId');
}

const buildEventsHtml = (events) => {
  return events.map(event => {
    return `
      <div class="event">
        <h3>${event.title}</h2>
        <p>${event.description}</p>
        <span>Date: ${event.date}</span>
        <span>Deadline: ${event.deadline}</span>
        <span>Location: ${event.location}</span>
        <span>Attendee Limit: ${event.attendee_limit}</span>
        <span>Tickets Remaining: ${event.attendee_limit - event.tickets_count}</span>
        <span>Price: ${event.price}</span>
        <span>Status: ${eventStatus[event.status]}</span>
        <div class="button-wrapper">
            <button class="btn btn-confirm" onclick="buyTicket('${event.id}')">Buy Ticket</button>
          ${getCurrentUserId() === event.created_by?.id || isMyEventsChecked ? `
            <button class="btn btn-edit" onclick="updateEvent('${event.id}')">Edit Event</button>
            <button class="btn btn-delete" onclick="deleteEvent('${event.id}')">Delete Event</button>` : ''}
        </div>
      </div>
    `;
  }).join('');
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