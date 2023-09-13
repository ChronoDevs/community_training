// Function to go back to the previous page
function goBack() {
    window.history.back();
}

// Add a click event listener to the 'X' icon
document.getElementById('go-back').addEventListener('click', goBack);
