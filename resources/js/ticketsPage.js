import './app.js';
import { getAuthHeader } from './app.js';

const ticketStatus = {
  ticket_valid: 'Valid',
  ticket_expired: 'Due',
}

const buildTicketsHtml = (tickets) => {
  console.log(tickets)
  return tickets.map(ticket => {
    return `
      <div class="ticket">
        <h3>${ticket.event.title}</h2>
        <p>${ticket.event.description}</p>
        <span>Date: ${ticket.event.date}</span>
        <span>Location: ${ticket.event.location}</span>
        <span>Price: ${ticket.event.price}</span>
        <span>Ticket Status: ${ticketStatus[ticket.status]}</span>
        <div class="button-wrapper">
          <button class="btn btn-delete" onclick="deleteTicket('${ticket.event_id}')">Delete Ticket</button>
        </div>
      </div>
    `;
  }).join('');
}
const buildErrorHtml = (error) => {
  return `
    <div class='ticket'>
      <h3>Error</h3>
      <p>${error}</p>
    </div>
  `
}

const onSuccess = (res) => {
  const { data } = res.data
  const eventsContainer = document.getElementById('events-container');
  eventsContainer.innerHTML = buildTicketsHtml(data);
}

const onError = (err) => {
  const { data } = err.response.data;
  const eventsContainer = document.getElementById('events-container');
  eventsContainer.innerHTML = buildErrorHtml(data.error);
}

const getTickets = () => {
  axios.get('api/tickets/me', {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(onSuccess).catch(onError);
}

getTickets();