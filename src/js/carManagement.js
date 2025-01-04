export function deleteCar(carId) {
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
            fetch('../helpers/deleteCar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `carId=${carId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`car-row-${carId}`).remove();
                    Swal.fire('Deleted!', 'Car has been deleted.', 'success');
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                Swal.fire('Error!', error.message || 'Failed to delete car', 'error');
            });
        }
    });
}

export function openEditModal(carId) {
    fetch(`../helpers/getCar.php?id=${carId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.message);
            }
            const car = data.data;
            document.getElementById('edit-car-id').value = car.id;
            document.getElementById('edit-model').value = car.model;
            document.getElementById('edit-price').value = car.price;
            document.getElementById('edit-availability').value = car.availability;
            document.getElementById('edit-category').value = car.category;
            document.getElementById('edit-mileage').value = car.mileage;
            document.getElementById('edit-year').value = car.year;
            document.getElementById('edit-fuel-type').value = car.fuel_type;
            document.getElementById('edit-transmission').value = car.transmission;
            document.getElementById('edit-description').value = car.description;
            
            document.getElementById('editCarModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', error.message || 'Failed to fetch car details', 'error');
        });
}

export function updateCar(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    fetch('../helpers/updateCar.php', {
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
            document.getElementById('editCarModal').style.display = 'none';
            Swal.fire('Success!', 'Car updated successfully', 'success')
                .then(() => {
                    window.location.reload();
                });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', error.message || 'Failed to update car', 'error');
    });
}