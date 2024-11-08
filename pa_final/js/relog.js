const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('sandi');

        togglePassword.addEventListener('click', function () {

            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            this.classList.toggle('fa-eye-slash');
        });