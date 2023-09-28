// Get DOM elements
const tagsSelect = document.getElementById('tags');
const selectedTagsContainer = document.getElementById('selected-tags');

// Event listener for tag removal
selectedTagsContainer.addEventListener('click', (event) => {
    if (event.target.classList.contains('tag-remove-button')) {
        const tagText = event.target.previousSibling.textContent;
        const optionToRemove = Array.from(tagsSelect.options).find(option => option.text === tagText);

        if (optionToRemove) {
            optionToRemove.selected = false; // Deselect the option
            event.target.parentElement.remove(); // Remove the label
        }
    }
});

// Event listener for tag selection
tagsSelect.addEventListener('change', () => {
    selectedTagsContainer.innerHTML = '';

    for (const option of tagsSelect.selectedOptions) {
        const tagLabel = document.createElement('span');
        tagLabel.textContent = option.text;
        tagLabel.classList.add('badge', 'bg-primary', 'me-2', 'mb-2', 'tag-label');

        const removeButton = document.createElement('span');
        removeButton.innerHTML = '&times;';
        removeButton.classList.add('tag-remove-button');

        tagLabel.appendChild(removeButton);
        selectedTagsContainer.appendChild(tagLabel);
    }
});

// Initialize TinyMCE editor
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
