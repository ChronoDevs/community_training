$(document).ready(function () {
    // Function to perform sorting and reload the page
    function performSort(sortBy) {
        // Replace the current URL with the sorted URL
        const currentUrl = window.location.href;
        const sortedUrl = new URL(currentUrl);
        sortedUrl.searchParams.set('sort', sortBy); // Add a query parameter for sorting
        window.location.href = sortedUrl.toString();
    }

    // Click event handler for "Relevant" link
    $('#relevant-link').on('click', function () {
        performSort('relevant'); // Define how you want to sort for "Relevant"
    });

    // Click event handler for "Latest" link
    $('#latest-link').on('click', function () {
        performSort('latest'); // Define how you want to sort for "Latest"
    });

    // Click event handler for "Top" link
    $('#top-link').on('click', function () {
        performSort('top'); // Define how you want to sort for "Top"
    });
});
