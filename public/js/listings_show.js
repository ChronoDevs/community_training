import Echo from 'laravel-echo'

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// Function to append a new comment to the comment section
function appendComment(comment) {
    const commentList = document.querySelector('#comment-list'); // Add an ID to the comment list
    const newComment = document.createElement('li');
    newComment.innerHTML = `
        <strong>${comment.user.name}</strong>
        <p>${comment.content}</p>
    `;
    commentList.appendChild(newComment);
}

// Initialize Echo and set up the event listener
window.Echo.channel('comments')
    .listen('CommentPosted', (event) => {
        appendComment(event.comment); // Call the appendComment function with the new comment
    });

// Function to go back to the previous page
function goBack() {
    window.history.back();
}

// Add a click event listener to the 'X' icon
document.getElementById('go-back').addEventListener('click', goBack);
