<?php include('template/header.php') ?>
    <!-- Hero Section -->
    <div class="relative h-[600px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80')">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative z-10 container mx-auto px-32 flex flex-col justify-center h-full">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold text-white mb-6 leading-tight">
                    Discover Your Perfect Ride
                </h1>
                <p class="text-xl text-gray-200 mb-8">
                    Explore our wide range of vehicles and book your dream car for an unforgettable journey.
                </p>
                <div class="flex space-x-4">
                    <a href="#booking" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Book Now
                    </a>
                    <a href="#" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg hover:bg-white hover:text-gray-900 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Section -->
    <div id="booking" class="container mx-auto px-32 py-16 grid md:grid-cols-2 gap-12">
        <!-- Car Selection Card -->
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden transform transition-all hover:scale-105">
            <div id="selectedCarCard" class="p-6">
                <div class="flex items-center mb-6">
                    <img id="selectedCarImage" src="https://via.placeholder.com/350x200" alt="Selected Car" class="w-full h-48 object-cover rounded-lg">
                </div>
                <div>
                    <h2 id="selectedCarName" class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
                        Select a Car
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 dark:text-gray-300">Daily Rate</p>
                            <p id="selectedCarPrice" class="text-xl font-bold text-blue-600">--</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-300">Category</p>
                            <p id="selectedCarCategory" class="text-lg">--</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p id="selectedCarDescription" class="text-gray-600 dark:text-gray-300">
                            Please select a car from the available options.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8">
            <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">
                Booking Details
            </h2>
            <form id="bookingForm" class="space-y-6">
                <!-- Personal Information -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-600 dark:text-gray-300">First Name</label>
                        <input 
                            type="text" 
                            required 
                            class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="John"
                        >
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-600 dark:text-gray-300">Last Name</label>
                        <input 
                            type="text" 
                            required 
                            class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                            placeholder="Doe"
                        >
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <label class="block mb-2 text-gray-600 dark:text-gray-300">Email Address</label>
                    <input 
                        type="email" 
                        required 
                        class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                        placeholder="john.doe@example.com"
                    >
                </div>

                <!-- Booking Dates -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-gray-600 dark:text-gray-300">Pickup Date</label>
                        <input 
                            type="date" 
                            required 
                            class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                        >
                    </div>
                    <div>
                        <label class="block mb-2 text-gray-600 dark:text-gray-300">Return Date</label>
                        <input 
                            type="date" 
                            required 
                            class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                        >
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span>Daily Rate</span>
                        <span id="dailyRateDisplay">$0</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Number of Days</span>
                        <span id="numberOfDaysDisplay">0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total Cost</span>
                        <span id="totalCostDisplay">$0</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-4 rounded-lg hover:bg-blue-700 transition text-lg font-semibold"
                >
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>

    <script>
        // Placeholder for car selection logic
        function selectCar(carName, price, category, description, imageUrl) {
            document.getElementById('selectedCarName').textContent = carName;
            document.getElementById('selectedCarPrice').textContent = `$${price}/day`;
            document.getElementById('selectedCarCategory').textContent = category;
            document.getElementById('selectedCarDescription').textContent = description;
            document.getElementById('selectedCarImage').src = imageUrl;
            document.getElementById('dailyRateDisplay').textContent = `$${price}`;
        }

        // Calculate total cost
        function calculateTotalCost() {
            const pickupDate = new Date(document.querySelector('input[type="date"]:nth-child(1)').value);
            const returnDate = new Date(document.querySelector('input[type="date"]:nth-child(2)').value);
            const dailyRate = parseFloat(document.getElementById('selectedCarPrice').textContent.replace('$', '').replace('/day', ''));
            
            const timeDiff = Math.abs(returnDate.getTime() - pickupDate.getTime());
            const numberOfDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            document.getElementById('numberOfDaysDisplay').textContent = numberOfDays;
            document.getElementById('totalCostDisplay').textContent = `$${(dailyRate * numberOfDays).toFixed(2)}`;
        }

        // Add event listeners
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('change', calculateTotalCost);
        });

        // Example car selection (you would typically do this dynamically)
        selectCar(
            'Toyota Camry', 
            45, 
            'Sedan', 
            'Comfortable mid-size sedan perfect for city and highway driving.', 
            'https://via.placeholder.com/350x200'
        );
    </script>

<?php include('template/footer.php') ?>
