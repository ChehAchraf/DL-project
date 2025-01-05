
function openEditCategoryModal(categoryId, categoryName) {
    document.getElementById('editCategoryId').value = categoryId;
    document.getElementById('editCategoryName').value = categoryName;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}

// Function to update category
function updateCategory() {
    const categoryId = document.getElementById('editCategoryId').value;
    const categoryName = document.getElementById('editCategoryName').value;

    if (!categoryName.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Category name is required'
        });
        return;
    }

    // Create XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../helpers/update_category.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Prepare data
    const data = `id=${encodeURIComponent(categoryId)}&name=${encodeURIComponent(categoryName)}`;

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        document.getElementById('editCategoryModal').classList.add('hidden');
                        location.reload();
                    });
                } else {
                    throw new Error(response.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to update category'
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update category'
            });
        }
    };

    xhr.onerror = function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Network error occurred'
        });
    };

    // Send request
    xhr.send(data);
}

// Function to delete category
function deleteCategory(categoryId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../helpers/delete_category.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(response.message);
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Failed to delete category'
                        });
                    }
                }
            };

            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Network error occurred'
                });
            };

            xhr.send(`categoryId=${categoryId}`);
        }
    });
}