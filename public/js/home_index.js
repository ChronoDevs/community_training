document.addEventListener("DOMContentLoaded", function() {
    const filterLinks = document.querySelectorAll('.filter-link');
    const likeButtons = document.querySelectorAll('.btn-link[id^="like-btn"]');
    const likedButtons = document.querySelectorAll('.btn-link[id^="liked-btn"]');
    const likeCounts = document.querySelectorAll('.like-count[id^="like-count-"]');
    const clickableLinks = document.querySelectorAll('.clickable-link');

    // Function to perform sorting and reload the page
    function performSort(sortBy) {
        // Prevent reloading if the link is already active
        if (document.getElementById(sortBy + '-link').classList.contains('active-link')) {
            return;
        }

        // Replace the current URL with the sorted URL
        const currentUrl = window.location.href;
        const sortedUrl = new URL(currentUrl);
        sortedUrl.searchParams.set('sort', sortBy); // Add a query parameter for sorting
        window.location.href = sortedUrl.toString();
    }

    // Event listener for filter links
    filterLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            filterLinks.forEach(link => {
                link.classList.remove('active-link');
            });
            this.classList.add('active-link');
            const sortBy = this.getAttribute('data-sort');
            performSort(sortBy); // Call the sorting function
        });
    });

    // Event listener for like buttons
    likeButtons.forEach(likeButton => {
        likeButton.addEventListener('click', function(event) {
            event.preventDefault();
            const listingId = this.getAttribute('data-listing-id');
            const likeCountElement = document.getElementById('like-count-' + listingId);

            likeButton.style.display = 'none';

            likedButtons.forEach(likedButton => {
                if (likedButton.getAttribute('data-listing-id') === listingId) {
                    likedButton.style.display = 'block';
                }
            });

            // Send an AJAX request to handle the like action
            $.ajax({
                url: "{{ route('listings.toggle-like') }}", // Update with your route URL
                method: "POST",
                data: { listing_id: listingId, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    // Update the like count on success
                    likeCountElement.innerText = response.likeCount + ' ' + (response.likeCount === 1 ? 'like' : 'likes');
                },
                error: function(error) {
                    console.error(error);
                    // Handle errors here
                }
            });
        });
    });

    // Event listener for clickable links
    clickableLinks.forEach(link => {
        link.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    });
});
