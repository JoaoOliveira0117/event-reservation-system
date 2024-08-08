import './app.js';
import { getAuthHeader } from './app.js';

const getLocationUuid = () => {
  const path = window.location.pathname;
  const match = path.match(/\/events\/([0-9a-fA-F\-]{36})/);
  const uuid = match ? match[1] : 'invalid';
  return uuid;
}

const setErrors = ({ title = '', description = '', deadline = '', date = '', location = '', price = '', attendee_limit = '' }) => {
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
  alert('Event updated successfully');
}

const onError = (err) => {
  const { data } = err.response.data;
  setErrors(data);
}

document.getElementById('event-form').addEventListener('submit', async e => {
  e.preventDefault();
  const uuid = getLocationUuid();

  const title = document.getElementById('title').value;
  const description = document.getElementById('description').value;
  const deadline = document.getElementById('deadline').value;
  const date = document.getElementById('date').value;
  const location = document.getElementById('location').value;
  const price = parseFloat(document.getElementById('price').value);
  const attendeeLimit = parseInt(document.getElementById('attendee_limit').value);
  const status = document.getElementById('status').value;

  setErrors({})

  axios.put('/api/events/' + uuid, {
    title,
    description,
    deadline,
    date,
    location,
    price,
    attendee_limit: attendeeLimit,
    status
  }, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(onSuccess).catch(onError)
})

const getCurrentEvent = () => {
  const uuid = getLocationUuid();

  axios.get('/api/events/' + uuid, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(res => {
    const {data} = res.data;

    document.getElementById('title').value = data.title;
    document.getElementById('description').value = data.description;
    document.getElementById('deadline').value = new Date(data.deadline).toISOString().slice(0, 16);
    document.getElementById('date').value = new Date(data.date).toISOString().slice(0, 16);
    document.getElementById('location').value = data.location;
    document.getElementById('price').value = data.price;
    document.getElementById('attendee_limit').value = data.attendee_limit;
  }).catch(onError);
}

getCurrentEvent();