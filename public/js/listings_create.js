const tagsSelect = document.getElementById('tags');
const selectedTagsContainer = document.getElementById('selected-tags');

tagsSelect.addEventListener('change', (event) => {
    selectedTagsContainer.innerHTML = ''; // Clear previous selection

    // Iterate through selected options and create labels with remove buttons
    for (const option of event.target.selectedOptions) {
        const tagLabel = document.createElement('span');
        tagLabel.textContent = option.text;
        tagLabel.classList.add('badge', 'bg-primary', 'me-2', 'mb-2', 'tag-label');

        // Create a remove button (x)
        const removeButton = document.createElement('span');
        removeButton.innerHTML = '&times;';
        removeButton.classList.add('tag-remove-button');
        removeButton.addEventListener('click', () => {
            tagsSelect.querySelector(`option[value="${option.value}"]`).selected = false; // Deselect the option
            tagLabel.remove(); // Remove the label
        });

        tagLabel.appendChild(removeButton);
        selectedTagsContainer.appendChild(tagLabel);
    }
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
