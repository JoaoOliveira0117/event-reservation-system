import './app.js';
import { getAuthHeader } from './app.js';
import { ticketsHtmlBuilder } from './htmlBuilder.js';

const buildTicketsHtml = (tickets) => tickets.map(ticket => ticketsHtmlBuilder(ticket)).join('');

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
  const eventsContainer = document.getElementById('tickets-container');
  eventsContainer.innerHTML = buildTicketsHtml(data);
}

const onError = (err) => {
  console.log(err)
  const { data } = err.response.data;
  const eventsContainer = document.getElementById('tickets-container');
  eventsContainer.innerHTML = buildErrorHtml(data.error);
}

const getTickets = () => {
  axios.get('/api/tickets/me', {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(onSuccess).catch(onError);
}

getTickets();