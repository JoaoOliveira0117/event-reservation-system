import './bootstrap';

export const getAuthHeader = () => {
  return `Bearer ${localStorage.getItem('access_token')}`;
}

const onError = (err) => {
  if (err.response.data.message) {
    return alert(err.response.data.message);
  }
  
  return alert(Object.values(err.response.data.data)[0])
}

window.buyTicket = (eventId) => {
  axios.post('/api/tickets/' + eventId, {
    status: 'ticket_valid'
  }, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(() => alert('Ticket has been bought successfully!')).catch(onError);
}

window.deleteTicket = (eventId) => {
  axios.delete('/api/tickets/' + eventId, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(() => location.reload()).catch(onError);
}

window.deleteEvent = (eventId) => {
  axios.delete('/api/events/' + eventId, {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(() => location.reload()).catch(onError);
}

window.updateEvent = (eventId) => {
  window.location.href = '/events/' + eventId;
}