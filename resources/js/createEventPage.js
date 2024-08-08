import './app.js';
import { getAuthHeader } from './app.js';

const setErrors = ({ title = 'Error!!', description = '', deadline = '', date = '', location = '', price = '', attendee_limit = '' }) => {
  const titleError = document.getElementById('title-error');
  const descriptionError = document.getElementById('description-error');
  const deadlineError = document.getElementById('deadline-error');
  const dateError = document.getElementById('date-error');
  const locationError = document.getElementById('location-error');
  const priceError = document.getElementById('price-error');
  const attendeeLimitError = document.getElementById('attendee_limit-error');

  titleError.textContent = title?? title[0];
  descriptionError.textContent = description?? description[0];
  deadlineError.textContent = deadline?? deadline[0];
  dateError.textContent = date?? date[0];
  locationError.textContent = location?? location[0];
  priceError.textContent = price?? price[0];
  attendeeLimitError.textContent = attendee_limit?? attendee_limit[0];
}

const onSuccess = () => {
  alert('Event created successfully');
  window.location.href = 'events'
}

const onError = (err) => {
  const { data } = err.response.data;
  setErrors(data);
}

document.getElementById('event-form').addEventListener('submit', async e => {
  e.preventDefault();

  const title = document.getElementById('title').value;
  const description = document.getElementById('description').value;
  const deadline = document.getElementById('deadline').value;
  const date = document.getElementById('date').value;
  const location = document.getElementById('location').value;
  const price = parseFloat(document.getElementById('price').value);
  const attendeeLimit = parseInt(document.getElementById('attendee_limit').value);

  setErrors({})

  axios.post('/api/events', {
    title,
    description,
    deadline,
    date,
    location,
    price,
    attendee_limit: attendeeLimit,
    status: 'event_pending'
  }, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(onSuccess).catch(onError)
})