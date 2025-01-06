document.getElementById('articleForm').addEventListener('submit', submitArticle);

async function submitArticle(event) {
    event.preventDefault();
    
    try {
        const form = document.getElementById('articleForm');
        const data = new FormData(form);
        
        const response = await fetch('../helpers/article_handler.php', {
            method: 'POST',
            body: data
        });

        // Check if response is OK
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Get the response text for debugging
        const responseText = await response.text();
        
        // Try to parse the JSON
        let jsonData;
        try {
            jsonData = JSON.parse(responseText);
        } catch (e) {
            console.error('Failed to parse JSON response:', responseText);
            throw new Error('Invalid JSON response from server');
        }

        if (jsonData.success) {
            await Swal.fire('Success!', jsonData.message, 'success');
            window.location.reload();
        } else {
            throw new Error(jsonData.message || 'Unknown error occurred');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire('Error!', error.message || 'Failed to submit article', 'error');
    }
}

function DeleteArticle(article_id) {
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
            formData.append('article_id', article_id);

            fetch('../helpers/article_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to delete article');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', error.message || 'Failed to delete article', 'error');
            });
        }
    });
}