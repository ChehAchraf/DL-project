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