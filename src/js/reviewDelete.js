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
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('review_id', reviewId);

            fetch('../helpers/review_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Deleted!',
                        'Your review has been deleted.',
                        'success'
                    ).then(() => {
                        // Reload the page to reflect changes
                        window.location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        data.message || 'Something went wrong!',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Something went wrong!',
                    'error'
                );
            });
        }
    }); 
}