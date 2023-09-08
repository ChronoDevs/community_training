// Event listener for filter links
filterLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();

        // Remove 'active-link' class from all filter links
        filterLinks.forEach(link => {
            link.classList.remove('active-link');
        });

        // Add 'active-link' class to the clicked filter link
        this.classList.add('active-link');
    });
});
