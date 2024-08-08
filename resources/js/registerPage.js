import './app.js';

const setErrors = ({ email = '', username = '', password = '', error = '' }) => {
  const emailError = document.getElementById('email-error');
  const usernameError = document.getElementById('username-error');
  const passwordError = document.getElementById('password-error');
  const registerError = document.getElementById('register-error');

  emailError.textContent = email ?? email[0];
  passwordError.textContent = password ?? password[0];
  usernameError.textContent = username ?? username[0];
  registerError.textContent = error ?? error[0];
}

const onSuccess = (res) => {
  alert('Registration successful');
  document.getElementById('register-form').reset();
  setErrors({});
  window.location.herf = 'login';
}

const onError = (err) => {
  const { data } = err.response.data;
  setErrors(data);
}

document.getElementById('register-form').addEventListener('submit', async e => {
  e.preventDefault();

  const email = document.getElementById('email').value;
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  setErrors({});

  axios.post('api/register', {
    email,
    username,
    password,
  }).then(onSuccess).catch(onError)
})