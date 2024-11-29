const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('floatingPassword');

togglePassword.addEventListener('change', () => {
    passwordField.type = togglePassword.checked ? 'text' : 'password';
});
