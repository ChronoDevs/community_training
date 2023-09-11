document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('.toggle-password');
    const passwordField = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
        const fieldType = passwordField.getAttribute('type');
        passwordField.setAttribute('type', fieldType === 'password' ? 'text' : 'password');
        togglePassword.classList.toggle('fa-solid fa-eye-slash');
    });
});

$(document).ready(function () {
    // Add a click event handler to all elements with the 'clickable-link' class
    $('.clickable-link').click(function () {
        // Get the URL from the 'data-url' attribute
        var url = $(this).data('url');

        // Navigate to the URL
        window.location.href = url;
    });
});
