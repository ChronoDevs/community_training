const newCategoryButton = document.getElementById('newCategoryButton');
const closeButton = document.getElementById('closeButton');
const adminHeader = document.querySelector('.admin-header');
const adminCard = document.querySelector('.admin-card');
const newCategoryForm = document.getElementById('newCategoryForm');

newCategoryButton.addEventListener('click', () => {
    adminHeader.style.display = 'none';
    adminCard.style.display = 'none';
    newCategoryForm.style.display = 'block';
});

closeButton.addEventListener('click', () => {
    adminHeader.style.display = 'flex'; // Adjust this to your header display type
    adminCard.style.display = 'block';
    newCategoryForm.style.display = 'none';
});

function confirmDelete() {
    if (confirm("Are you sure you want to delete this category?")) {
        document.getElementById('deleteCategoryForm').submit();
    }
}
