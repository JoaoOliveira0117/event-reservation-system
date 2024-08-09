import { formatDateString } from "./app";

const getCurrentUserId = () => {
  return localStorage.getItem('userId');
}

const ticketStatus = {
  ticket_valid: 'Valid',
  ticket_cancelled: 'Cancelled',
  ticket_due: 'Due',
}

const eventStatus = {
  event_pending: 'Pending',
  event_full: 'Full',
  event_finished: 'Finished',
}

const escapeHtml = (unsafe) => {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

export const eventHtmlBuilder = ({
  id,
  title,
  description,
  date,
  deadline,
  location,
  price,
  attendee_limit,
  tickets_count,
  status,
  created_by,
}, isMyEventsChecked) => {
  return `
    <div class="event">
      <h3>${escapeHtml(title)}</h2>
      <p>${escapeHtml(description)}</p>
      <span>Date: ${formatDateString(escapeHtml(date))}</span>
      <span>Deadline: ${formatDateString(escapeHtml(deadline))}</span>
      <span>Location: ${escapeHtml(location)}</span>
      <span>Attendee Limit: ${attendee_limit}</span>
      <span>Tickets Remaining: ${attendee_limit - tickets_count}</span>
      <span>Price: $${price}</span>
      <span>Status: ${escapeHtml(eventStatus[status])}</span>
      <div class="button-wrapper">
          <button class="btn btn-confirm" onclick="buyTicket('${escapeHtml(id)}')">Buy Ticket</button>
        ${getCurrentUserId() === created_by?.id || isMyEventsChecked ? `
          <button class="btn btn-edit" onclick="updateEvent('${escapeHtml(id)}')">Edit Event</button>
          <button class="btn btn-delete" onclick="deleteEvent('${escapeHtml(id)}')">Delete Event</button>` : ''}
      </div>
    </div>
  `;
}

export const ticketsHtmlBuilder = ({
  status,
  event_id,
  event
}) => {
  console.log(event)
  return `
    <div class="ticket">
      <h3>${escapeHtml(event.title)}</h2>
      <p>${escapeHtml(event.description)}</p>
      <span>Date: ${formatDateString(event.date)}</span>
      <span>Location: ${escapeHtml(event.location)}</span>
      <span>Price: ${event.price}</span>
      <span>Ticket Status: ${ticketStatus[status]}</span>
      <div class="button-wrapper">
        <button class="btn btn-delete" onclick="deleteTicket('${event_id}')">Delete Ticket</button>
      </div>
    </div>
  `;
}