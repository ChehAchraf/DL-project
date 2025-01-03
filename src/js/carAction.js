function deleteCar(id) {
    if (!confirm('Are you sure you want to delete this car?')) {
        return;
    }

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('carId', id);

    xhr.open('POST', '../helpers/delete_car.php', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById(`car-row-${id}`).remove();
                } else {
                    alert(response.error || 'Failed to delete car');
                }
            } else {
                alert('An error occurred while deleting the car');
            }
        }
    };

    xhr.send(formData);
}
