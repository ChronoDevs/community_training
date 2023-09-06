    // Function to check if any input fields have been modified
    function isFormDirty() {
        var inputs = document.querySelectorAll('.userlist_label');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value !== inputs[i].defaultValue) {
                return true;
            }
        }
        return false;
    }

    // Event listener to show/hide the "Save Changes" button
    document.addEventListener('input', function () {
        var saveButton = document.querySelector('#saveChangesButton');
        if (isFormDirty()) {
            saveButton.style.display = 'block';
        } else {
            saveButton.style.display = 'none';
        }
    });
