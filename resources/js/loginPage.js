import './app.js';

const setErrors = ({ email = '', username = '', password = '', error = '' }) => {
  const emailError = document.getElementById('email-error');
  const passwordError = document.getElementById('password-error');
  const loginError = document.getElementById('login-error');

  emailError.textContent = email ?? email[0];
  passwordError.textContent = password ?? password[0];
  loginError.textContent = error ?? error[0];
}

const onSuccess = (res) => {
  const { data } = res.data;
  localStorage.setItem('access_token', data.access_token);
  localStorage.setItem('userId', data.user.id);
  window.location.href = '/events';
}

const onError = (err) => {
  const { data } = err.response.data;

  setErrors(data);
}

document.getElementById('login-form').addEventListener('submit', async e => {
  e.preventDefault();

  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  setErrors({})

  axios.post('/api/login', {
    email,
    password,
  }).then(onSuccess).catch(onError)
})