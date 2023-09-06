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
