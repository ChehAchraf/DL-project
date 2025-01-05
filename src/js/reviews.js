
function submitReview(event) {
    event.preventDefault();
    const form = document.getElementById('reviewForm');
    const formData = new FormData(form);

    fetch('../helpers/review_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Review submitted successfully!',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                location.reload(); 
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Failed to submit review'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while submitting the review'
        });
        console.error('Error:', error);
    });
}

function editReview(reviewId) {
    const reviewItem = document.querySelector(`[data-review-id="${reviewId}"]`);
    const commentText = reviewItem.querySelector('p').textContent;
    
    const newComment = prompt('Edit your review:', commentText);
    if (newComment === null || newComment === commentText) return;

    fetch('helpers/review_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=edit&review_id=${reviewId}&comment=${encodeURIComponent(newComment)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Review updated successfully!',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Failed to update review'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating the review'
        });
        console.error('Error:', error);
    });
}

function deleteReview(reviewId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../helpers/review_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete&review_id=${reviewId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your review has been deleted.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message || 'Failed to delete review'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the review'
                });
                console.error('Error:', error);
            });
        }
    });
}

function restoreReview(reviewId) {
    fetch('../helpers/review_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=restore&review_id=${reviewId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Restored!',
                text: 'Your review has been restored.',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({            
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Failed to restore review'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while restoring the review'
        }); 
        console.error('Error:', error);
    });
}