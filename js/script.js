document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');
    const otpForm = document.querySelector('.otp-form');
    const formTitle = document.getElementById('form-title');

    // Toggle form
    document.getElementById('show-signup').addEventListener('click', (e) => {
        e.preventDefault();
        showForm('signup');
    });

    document.getElementById('show-login').addEventListener('click', (e) => {
        e.preventDefault();
        showForm('login');
    });

    function showForm(type) {
        [loginForm, signupForm, otpForm].forEach(f => f.classList.remove('active'));

        if (type === 'signup') {
            signupForm.classList.add('active');
            formTitle.textContent = "Create an Account";
        } else if (type === 'login') {
            loginForm.classList.add('active');
            formTitle.textContent = "Welcome to our Community!";
        } else if (type === 'otp') {
            otpForm.classList.add('active');
            formTitle.textContent = "Email Confirmation";
        }
    }

    // Password toggle
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetInput = document.getElementById(toggle.dataset.target);
            const type = targetInput.getAttribute('type') === 'password' ? 'text' : 'password';
            targetInput.setAttribute('type', type);
            toggle.textContent = type === 'password' ? '👁️' : '🙈';
        });
    });
    document.querySelectorAll('.input-box input').forEach(input => {
        input.addEventListener('input', () => {
            const error = input.parentElement.querySelector('.error-text');
    
            if (error) {
                const isValid =
                    (input.type === 'email' && validateEmail(input.value)) ||
                    (input.type === 'password' && input.value.length >= 6) ||
                    (input.type === 'text' && input.value.trim() !== '');
    
                if (isValid) {
                    error.remove();
                }
            }
        });
    });
    
    // Login form validation
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        const email = document.getElementById('loginEmail');
        const password = document.getElementById('loginPassword');

        if (!validateEmail(email.value)) {
            e.preventDefault();
            showError(email, "Invalid email address.");
        }

        if (password.value.length < 6) {
            e.preventDefault();
            showError(password, "Password must be at least 6 characters.");
        }
    });

    // Signup form validation
    document.getElementById('signupForm').addEventListener('submit', function (e) {
        const username = document.getElementById('signupUsername');
        const email = document.getElementById('signupEmail');
        const password = document.getElementById('signupPassword');
        const terms = document.getElementById('termsCheckbox');
        const role = document.getElementById('signupRole');

        let valid = true;

        if (username.value.trim() === '') {
            showError(username, "Username is required.");
            valid = false;
        }

        if (!validateEmail(email.value)) {
            showError(email, "Invalid email address.");
            valid = false;
        }

        if (password.value.length < 6) {
            showError(password, "Password must be at least 6 characters.");
            valid = false;
        }

        if (!terms.checked) {
            alert("You must agree to the terms and conditions.");
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            if (role.value === '') {
                showError(role, "Please select a role.");
                valid = false;
            }
            
        } else {
            e.preventDefault();
            showForm('otp'); // Simulate email confirmation
        }
    });

    // Dummy OTP validation
    document.getElementById('otpForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const otp = document.getElementById('otpInput').value.trim();
        if (otp === '' || otp.length !== 6) {
            alert("Please enter a valid 6-digit OTP.");
        } else {
            alert("Email confirmed! Welcome aboard 🚀");
            showForm('login');
        }
    });

    function showError(inputEl, message) {
        if (inputEl.tagName === 'SELECT') {
            inputEl.classList.add('input-error');
        } else {
            inputEl.classList.add('input-error');
        }
        
        removeOldError(inputEl);
        const error = document.createElement('span');
        error.classList.add('error-text');
        error.innerText = message;
        inputEl.parentElement.appendChild(error);
    }

    function removeOldError(inputEl) {
        inputEl.classList.remove('input-error');
        const existingError = inputEl.parentElement.querySelector('.error-text');
        if (existingError) {
            existingError.remove();
        }
    }

    function validateEmail(email) {
        const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        return pattern.test(email.toLowerCase());
    }

    // Initially show login
    showForm('login');
    // Forgot Password logic
const forgotPasswordLink = document.querySelector('.remember-forgot a');

const forgotForm = document.getElementById('forgot-password-form');
const backToLogin = document.getElementById('back-to-login');

forgotPasswordLink.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.classList.remove('active');
    signupForm.classList.remove('active');
    forgotForm.classList.add('active');
    document.getElementById('form-title').style.display = 'none';
});

backToLogin.addEventListener('click', (e) => {
    e.preventDefault();
    forgotForm.classList.remove('active');
    loginForm.classList.add('active');
    document.getElementById('form-title').style.display = 'block';
});
const forgotFormElement = document.querySelector('#forgot-password-form form');
const confirmationScreen = document.getElementById('confirmation-screen');
const confirmationEmailSpan = document.getElementById('user-reset-email');
const confirmationBackLogin = document.getElementById('confirmation-back-login');

forgotFormElement.addEventListener('submit', (e) => {
    e.preventDefault();

    const emailInput = document.getElementById('reset-email');
    const email = emailInput.value.trim();

    if (validateEmail(email)) {
        // Hide Forgot Password form
        forgotForm.classList.remove('active');

        // Update message with user's email
        confirmationEmailSpan.textContent = email;

        // Show confirmation screen
        confirmationScreen.classList.add('active');
    } else {
        // Handle invalid email - show inline error or alert
        alert("Please enter a valid email address.");
    }
});

confirmationBackLogin.addEventListener('click', (e) => {
    e.preventDefault();
    confirmationScreen.classList.remove('active');
    loginForm.classList.add('active');
    document.getElementById('form-title').style.display = 'block';
});

});
