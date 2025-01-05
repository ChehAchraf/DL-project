// Function to open edit modal
function openEditModal(carId) {
    fetch(`../helpers/getCar.php?id=${carId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const car = data.data;
                // Show the edit modal
                const modal = document.getElementById('editCarModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Populate the form fields
                document.getElementById('editCarId').value = car.id;
                document.getElementById('editBrand').value = car.brand;
                document.getElementById('editModel').value = car.model;
                document.getElementById('editYear').value = car.year;
                document.getElementById('editPrice').value = car.price;
                document.getElementById('editCategory').value = car.category_id;
                document.getElementById('editDescription').value = car.description;
                
                // Show current image if it exists
                const currentImageContainer = document.getElementById('currentCarImage');
                if (car.image) {
                    currentImageContainer.innerHTML = `<img src="${car.image}" class="h-20 w-20 object-cover rounded">`;
                } else {
                    currentImageContainer.innerHTML = 'No image available';
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to fetch car details'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching car details'
            });
        });
}

// Function to update car
function updateCar(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    
    fetch('../helpers/updateCar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Car updated successfully!'
            }).then(() => {
                document.getElementById('editCarModal').classList.add('hidden');
                location.reload(); // Reload to show updated data
            });
        } else {
            throw new Error(data.message || 'Failed to update car');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Failed to update car'
        });
    });
}

// Function to delete car
function deleteCar(carId) {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Car has been deleted.',
                    }).then(() => {
                        location.reload(); // Reload to show updated list
                    });
                } else {
                    throw new Error(data.message || 'Failed to delete car');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to delete car'
                });
            });
        }

function deleteCar(carId) {
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
            fetch('../helpers/car_delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`car-row-${carId}`).remove();
                    Swal.fire('Deleted!', data.message, 'success');
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to delete car', 'error');
            });
        }
    });
}

// Function to open edit modal
function openEditModal(carId) {
    fetch(`../helpers/getCar.php?car_id=${carId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const car = data.car;
                document.getElementById('edit-car-id').value = car.id;
                document.getElementById('edit-model').value = car.model;
                document.getElementById('edit-price').value = car.daily_rate;
                document.getElementById('edit-category').value = car.category_id;
                document.getElementById('edit-availability').value = car.availability;
                document.getElementById('edit-mileage').value = car.mileage;
                document.getElementById('edit-year').value = car.year;
                document.getElementById('edit-fuel-type').value = car.fuel_type;
                document.getElementById('edit-transmission').value = car.transmission;
                document.getElementById('edit-description').value = car.description;
                
                document.getElementById('editCarModal').style.display = 'block';
            } else {
                Swal.fire('Error!', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Failed to load car details', 'error');
        });
}

// Function to update car
function updateCar(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('editCarForm'));
    
    fetch('../helpers/car_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('editCarModal').style.display = 'none';
            Swal.fire('Success!', data.message, 'success').then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', error.message || 'Failed to update car', 'error');
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