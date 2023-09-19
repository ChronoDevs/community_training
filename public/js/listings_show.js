// Initialize Echo for real-time broadcasting
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

// Function to update the comment section
function updateCommentSection(listingId) {
    $.ajax({
        type: 'GET',
        url: `/comments/${listingId}`, // Replace with your route URL
        dataType: 'json',
        success: function (data) {
            const comments = data.comments;
            const commentList = document.querySelector('#comment-list');

            // Clear existing comments
            commentList.innerHTML = '';

            // Append fetched comments to the comment list
            comments.forEach(function (comment) {
                const commentElement = document.createElement('li');
                commentElement.innerHTML = `
                    <strong>${comment.user.name}</strong>
                    <p>${comment.content}</p>
                `;
                commentList.appendChild(commentElement);
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

// Function to go back to the previous page
function goBack() {
    window.history.back();
}

// Add a click event listener to the 'X' icon
document.getElementById('go-back').addEventListener('click', goBack);

// Call the updateCommentSection function to initially populate comments
const listingId = document.getElementById('listing-id').value;
updateCommentSection(listingId);

// Set up Echo to listen for new comments and update the comment section
window.Echo.channel('comments')
    .listen('CommentPosted', (event) => {
        // Handle new comment by appending it to the comment section
        const comment = event.comment;
        appendComment(comment);
    });

tinymce.init({
    selector: 'textarea#description',
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | removeformat | help',
    menubar: 'file edit view insert format tools table help',
    content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
    height: 300
});
