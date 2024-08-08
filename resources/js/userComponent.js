import './app.js';
import { getAuthHeader } from './app.js';

const getCurrentUserId = () => {
  return localStorage.getItem('userId');
}

const onSuccess = (res) => {
  const { data } = res.data;
  const userName = document.getElementById('user-name');
  userName.innerHTML = data.username;
}

const getUser = () => {
  axios.get('/api/users/' + getCurrentUserId(), {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(onSuccess).catch(console.log);
}

document.getElementById('user-logout').addEventListener('click',  () => {
  axios.post('/api/logout', {
    headers: {
      Authorization: getAuthHeader()
    }
  }).then(() => {
    localStorage.removeItem('access_token');
    localStorage.removeItem('userId');
    window.location.href = '/';
  }).catch(console.log);
});

getUser();