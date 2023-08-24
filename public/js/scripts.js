document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.querySelector(".toggle-password");
    const passwordField = document.querySelector("#password");

    togglePassword.addEventListener("click", function() {
        const fieldType = passwordField.getAttribute("type");
        passwordField.setAttribute("type", fieldType === "password" ? "text" : "password");
        togglePassword.classList.toggle("fa-solid fa-eye-slash");
    });
});
