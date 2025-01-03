<?php
session_start();
echo $_SESSION['id'];
// import the autoLoad
require __DIR__ . '/../vendor/autoload.php'; 

// calling the classes
use Helpers\Database;
use Classes\User;
use Classes\Client;
use Classes\Car;
$db = new Database();
$pdo = $db->getConnection();
?>  
<?php if( isset($_SESSION['role']) && $_SESSION['role'] == "client" ){ ?>
<?php include('template/header.php') ?>
<?php include('template/hero.php') ?>

    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Car Image Gallery -->
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $db = new Database();
                    $pdo = $db->getConnection();
                    $car = new Car("","","","","","","","","");
                    $detail = $car->getCarDetails($pdo,$id);

                }  
                ?>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Main Image Section -->
                <div class="p-4">
                    <img id="mainImage" 
                         src="<?php echo $detail['img_path']; ?>" 
                         alt="Car Main Image" 
                         class="w-full h-96 object-cover rounded-lg">
                    
                    <!-- Thumbnail Gallery -->
                    <div class="flex space-x-2 mt-4" id="thumbnailGallery">
                        <!-- Thumbnail images will be added dynamically -->
                    </div>
                </div>

                <!-- Car Details Section -->
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4 dark:text-white" id="carTitle">
                        <?php echo $detail['model']; ?>
                    </h1>

                    <!-- Price and Status -->
                    <div class="flex items-center mb-4">
                        <span class="text-2xl font-semibold text-blue-600 dark:text-blue-400" id="carPrice">
                            <?php echo $detail['price']; ?>
                        </span>
                        <span class="ml-4 px-3 py-1 bg-<?php echo ($detail['availability'] == 'unavailable')? "red" : "green" ?>-100 text-<?php echo ($detail['availability'] == 'unavailable')? "white" : "green" ?>-800 rounded-full" id="carStatus">
                        <?php echo $detail['availability']; ?>
                        </span>
                    </div>

                    <!-- Car Specifications Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Make</p>
                            <p class="font-medium dark:text-white" id="carMake"><?php echo $detail['model']; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Model</p>
                            <p class="font-medium dark:text-white" id="carModel">C-Class</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Year</p>
                            <p class="font-medium dark:text-white" id="carYear"><?php echo $detail['year']; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Mileage</p>
                            <p class="font-medium dark:text-white" id="carMileage"><?php echo $detail['mileage']; ?></p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2 dark:text-white">Description</h3>
                        <p class="text-gray-600 dark:text-gray-300" id="carDescription">
                            <?php echo $detail['description']; ?>.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button id="reserv" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Make a reservation
                        </button>
                    </div>
                </div>
            </div>

            <!-- Additional Features -->
            <div class="p-6 bg-gray-50 dark:bg-gray-700">
                <h3 class="text-2xl font-bold mb-4 dark:text-white">Key Features</h3>
                <div class="grid md:grid-cols-3 gap-4" id="carFeatures">
                    <div class="bg-white dark:bg-gray-600 p-4 rounded-lg shadow-sm">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        <span class="dark:text-white">Automatic Transmission</span>
                    </div>
                    <div class="bg-white dark:bg-gray-600 p-4 rounded-lg shadow-sm">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        <span class="dark:text-white">Leather Seats</span>
                    </div>
                    <div class="bg-white dark:bg-gray-600 p-4 rounded-lg shadow-sm">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        <span class="dark:text-white">Backup Camera</span>
                    </div>
                </div>
            </div>
            

            <?php 
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    try{
                        $client = new Client("","","","","");
                        $carid = $detail['id'];
                        $reviewText = $_POST['description'];
                        $rating = 5;
                        $add_the_review = $client->submitReview($pdo, $carid, $reviewText, $rating);
                        $review_added = "Your Review Has been added seccufully";
                    }catch(Exception $e){
                        $alreadyaddad =  $e->getMessage();
                    }
                }
                
                
                
            ?>
            <!-- Reviews Section -->
            <div class="p-6 bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold dark:text-white">Customer Reviews</h3>
                    <!-- <div class="overall-rating flex items-center">
                        <span class="text-xl font-semibold mr-2">4.5</span>
                        <div class="stars flex">
                            <i class="fas fa-star star active"></i>
                            <i class="fas fa-star star active"></i>
                            <i class="fas fa-star star active"></i>
                            <i class="fas fa-star star active"></i>
                            <i class="fas fa-star-half-alt star active"></i>
                        </div>
                        <span class="ml-2 text-gray-500 dark:text-gray-300">(24 Reviews)</span>
                    </div> -->
                </div>

                <!-- Review List -->
                <!-- <div class="space-y-4" id="reviewContainer">
                    <!-- Individual Review Template -->
                    <!-- <div class="review bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <img src="path/to/user-avatar.jpg" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                                <h4 class="font-semibold dark:text-white">John Doe</h4>
                            </div>
                            <div class="review-rating">
                                <i class="fas fa-star star active"></i>
                                <i class="fas fa-star star active"></i>
                                <i class="fas fa-star star active"></i>
                                <i class="fas fa-star star active"></i>
                                <i class="fas fa-star star inactive"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            Excellent car rental experience! The vehicle was clean, well-maintained, 
                            and performed perfectly during my trip. Highly recommended!
                        </p>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Rented on: June 15, 2024
                        </div>
                    </div>

                    <!-- More Reviews Would Be Added Dynamically -->
                <!-- </div> -->

                <!-- Write a Review Section -->
                <div class="mt-6 bg-white dark:bg-gray-600 p-6 rounded-lg">
                    <h4 class="text-xl font-semibold mb-4 dark:text-white">Write a Review</h4>
                        <form  method="POST" action="" class="space-y-4">
                        <textarea 
                            name = "description"
                            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:text-white" 
                            rows="4" 
                            placeholder="Share your experience..."
                        ></textarea>
                        <?php if(isset($alreadyaddad)): ?>

                                <script>
                                    const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                    });
                                    Toast.fire({
                                    icon: "info",
                                    title: "You Have already reviewed This car"
                                });
                                </script>
                        <?php endif ?>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Modal -->
    <div id="reservationModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-x-hidden overflow-y-auto">
    <div class="relative w-full max-w-md mx-auto my-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-5 border-b dark:border-gray-700">
                <h3 class="text-xl font-semibold dark:text-white">
                    Make a Reservation
                </h3>
                <button onclick="document.getElementById('reservationModal').style.display = 'none';" id="closeReservationModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form method="POST" id="reservationForm" onsubmit="submitReservation(event)" class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Car Selection (if multiple cars) -->
                     <input name="car_id" type="number"  value="<?php echo $detail['id'] ?>">
                     <input name="user_id" type="number"  value="<?php echo $_SESSION['id'] ?>">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Selected Car
                        </label>
                        <input 
                            type="text" 
                            id="carName" 
                            class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600" 
                            value="<?php echo $detail['model']; ?>" 
                            readonly
                        >
                        <!-- <input 
                            type="hidden" 
                            id="carId" 
                            name="car_id"
                        > -->
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Start Date
                        </label>
                            <input 
                                type="date" 
                                id="startDate" 
                                name="start_date" 
                                class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                required
                            >
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                End Date
                            </label>
                            <input 
                                type="date" 
                                id="endDate" 
                                name="end_date" 
                                class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                required
                            >
                        </div>
                    </div>

                    <!-- Pickup Location -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pickup Location
                        </label>
                        <select 
                            id="pickupLocation" 
                            name="pickup_location" 
                            class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required
                        >
                            <option value="">Select Pickup Location</option>
                            <option value="airport">Airport</option>
                            <option value="downtown">Downtown Office</option>
                            <option value="hotel">Hotel Pickup</option>
                        </select>
                    </div>

                    <!-- Return Location -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Return Location
                        </label>
                        <select 
                            id="returnLocation" 
                            name="return_location" 
                            class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required
                        >
                            <option value="">Select Return Location</option>
                            <option value="airport">Airport</option>
                            <option value="downtown">Downtown Office</option>
                            <option value="hotel">Hotel Pickup</option>
                        </select>
                    </div>

                    <!-- Price Calculation (Optional) -->
                    <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg mt-4">
                    <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Car Price</span>
                            <span id="Carprice" class="font-semibold dark:text-white"><?php echo $detail['price'] ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Rental Days</span>
                            <span id="rentalDays" class="font-semibold dark:text-white">0</span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-gray-600 dark:text-gray-300">Total Price</span>
                            <span id="totalPrice" class="font-semibold text-green-600">$0</span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-4 mt-6">
                    <button 
                        onclick="document.getElementById('reservationModal').style.display = 'none';"
                        type="button" 
                        id="cancelReservation" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Confirm Reservation
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>

function submitReservation(event) {
    event.preventDefault(); // Prevent default form submission

    const form = document.getElementById('reservationForm');
    const formData = new FormData(form);

    // Log form data for debugging
    for (const [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'helpers/reservation_handler.php', true);
    
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('Reservation successful:', xhr.responseText);
            alert('Reservation completed successfully!');
        } else {
            console.error('Error occurred:', xhr.statusText);
            alert('Failed to complete the reservation.');
        }
    };

    xhr.onerror = function () {
        console.error('Request error.');
        alert('An error occurred while processing the reservation.');
    };

    xhr.send(formData); // Send the form data
}



const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const rentalDaysSpan = document.getElementById('rentalDays');
    const totalPriceSpan = document.getElementById('totalPrice');

    const pricePerDay = document.getElementById('Carprice').textContent;

    endDateInput.addEventListener('change', () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (isNaN(startDate) || isNaN(endDate) || endDate < startDate) {
            rentalDaysSpan.textContent = "0";
            totalPriceSpan.textContent = "$0";
            return;
        }

        const rentalDays = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;

        rentalDaysSpan.textContent = rentalDays;

        const totalPrice = rentalDays * pricePerDay;
        totalPriceSpan.textContent = `$${totalPrice}`;
    });

        document.getElementById('reserv').addEventListener('click' , function(){
            document.getElementById('reservationModal').style.display = "block";
        })
        const reviewStars = document.querySelectorAll('.review-stars .star');
        
        reviewStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                
                // Reset all stars
                reviewStars.forEach(s => {
                    s.classList.remove('active', 'inactive');
                });
                
                // Activate stars up to clicked star
                reviewStars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.add('inactive');
                    }
                });
            });
        });

        // Review Form Submission (Placeholder)
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Review submission functionality to be implemented');
        });
    </script>
    <?php include('template/footer.php') ?>
    <?php }else{
        header('Location: index.php');
    }
    ?>

    
    