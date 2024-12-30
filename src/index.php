<?php

// import the autoLoad
require __DIR__ . '/../vendor/autoload.php'; 

// calling the classes
use Helpers\Database;


$db = new Database();
$pdo = $db->getConnection();



?>

<?php include('template/header.php') ?>
<?php include('template/hero.php') ?>



    <section class="container mx-auto px-32 py-12">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold dark:text-white mb-4">
                Our Available Vehicles
            </h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Choose from our wide range of vehicles. From compact cars to luxury SUVs, we have the perfect ride for every occasion.
            </p>
        </div>

        <!-- Filter Bar -->
        <div class="mb-8 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Category Filter -->
                <select class="w-full p-2 border dark:bg-gray-700 dark:border-gray-600 rounded-md">
                    <option>All Categories</option>
                    <option>Sedan</option>
                    <option>SUV</option>
                    <option>Luxury</option>
                    <option>Compact</option>
                </select>

                <!-- Price Range -->
                <select class="w-full p-2 border dark:bg-gray-700 dark:border-gray-600 rounded-md">
                    <option>Price Range</option>
                    <option>$50 - $100</option>
                    <option>$100 - $200</option>
                    <option>$200 - $300</option>
                    <option>$300+</option>
                </select>

                <!-- Transmission -->
                <select class="w-full p-2 border dark:bg-gray-700 dark:border-gray-600 rounded-md">
                    <option>Transmission</option>
                    <option>Automatic</option>
                    <option>Manualoption>
                </select>

                <!-- Search Input -->
                <input 
                    type="text" 
                    placeholder="Search vehicles..." 
                    class="w-full p-2 border dark:bg-gray-700 dark:border-gray-600 rounded-md"
                >
            </div>
        </div>

        <!-- Vehicle Grid -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Vehicle Card Template -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
                <div class="relative">
                    <img 
                        src="https://images.unsplash.com/photo-1502877338535-766e1452684a?fit=crop&w=800&q=80" 
                        alt="Car" 
                        class="w-full h-56 object-cover"
                    >
                    <div class="absolute top-4 right-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                            New
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold dark:text-white">
                            Toyota Camry
                        </h3>
                        <div class="flex items-center space-x-1 text-yellow-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span>4.5</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-xs">
                                Sedan
                            </span>
                            <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-xs">
                                Automatic
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-blue-600">
                                $85 
                                <span class="text-sm text-gray-500">/ day</span>
                            </span>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">
                            Rent Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Repeat the above card multiple times with different details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
                <!-- Similar structure to the previous card -->
                <div class="relative">
                    <img 
                        src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?fit=crop&w=800&q=80" 
                        alt="Car" 
                        class="w-full h-56 object-cover"
                    >
                    <div class="absolute top-4 right-4">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">
                            Available
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold dark:text-white">
                            Honda CR-V
                        </h3>
                        <div class="flex items-center space-x-1 text-yellow-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span>4.7</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-xs">
                                SUV
                            </span>
                            <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-xs">
                                Automatic
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-blue-600">
                                $120 
                                <span class="text-sm text-gray-500">/ day</span>
                            </span>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">
                            Rent Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add more car cards as needed -->
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-12">
            <div class="inline-flex space-x-2">
                <button class="px-4 py-2 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    Previous
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    1
                </button>
                <button class="px-4 py-2 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    2
                </button>
                <button class="px-4 py-2 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    3
                </button>
                <button class="px-4 py-2 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    Next
                </button>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-32">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold dark:text-white mb-4">
                    Why Choose Our Car Rental?
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    We provide more than just a car. We offer a complete, hassle-free experience that sets us apart from the rest.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Advantage Card 1 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-all group">
                    <div class="bg-blue-100 dark:bg-blue-900 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold dark:text-white mb-4">
                        Competitive Pricing
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        We offer the most competitive rates in the market without compromising on quality or service.
                    </p>
                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                        Learn More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Advantage Card 2 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-all group">
                    <div class="bg-green-100 dark:bg-green-900 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold dark:text-white mb-4">
                        Guaranteed Quality
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Our vehicles are meticulously maintained and undergo rigorous safety checks before each rental.
                    </p>
                    <a href="#" class="text-green-600 dark:text-green-400 hover:underline flex items-center">
                        Our Standards
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Advantage Card 3 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-all group">
                    <div class="bg-purple-100 dark:bg-purple-900 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold dark:text-white mb-4">
                        Flexible Booking
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Easy online booking, multiple pickup locations, and flexible rental periods to suit your needs.
                    </p>
                    <a href="#" class="text-purple-600 dark:text-purple-400 hover:underline flex items-center">
                        Book Now
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Additional Statistics -->
            <div class="mt-16 grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <h4 class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                        500+
                    </h4>
                    <p class="text-gray-600 dark:text-gray-300">
                        Happy Customers
                    </p>
                </div>
                <div>
                    <h4 class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">
                        50+
                    </h4>
                    <p class="text-gray-600 dark:text-gray-300">
                        Vehicle Models
                    </p>
                </div>
                <div>
                    <h4 class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                        24/7
                    </h4>
                    <p class="text-gray-600 dark:text-gray-300">
                        Customer Support
                    </p>
                </div>
                <div>
                    <h4 class="text-4xl font-bold text-red-600 dark:text-red-400 mb-2">
                        0%
                    </h4>
                    <p class="text-gray-600 dark:text-gray-300">
                        Hidden Fees
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-32">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold dark:text-white mb-4">
                    What Our Customers Say
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Hear from our satisfied customers who have experienced the best in car rental services.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial Card 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl shadow-lg relative">
                    <div class="absolute top-0 right-0 m-4 text-yellow-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 italic mb-6">
                        "Incredible service! The car was clean, modern, and exactly what I needed for my road trip. Booking was seamless and the staff was incredibly helpful."
                    </p>
                    
                    <div class="flex items-center">
                        <img 
                            src="https://randomuser.me/api/portraits/women/44.jpg" 
                            alt="Customer" 
                            class="w-12 h-12 rounded-full mr-4 object-cover"
                        >
                        <div>
                            <h4 class="font-bold dark:text-white">Emily Rodriguez</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Marketing Manager
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Card 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl shadow-lg relative">
                    <div class="absolute top-0 right-0 m-4 text-yellow-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 italic mb-6">
                        "I've rented cars from many companies, but this service stands out. The prices are competitive, and the vehicle selection is impressive."
                    </p>
                    
                    <div class="flex items-center">
                        <img 
                            src="https://randomuser.me/api/portraits/men/32.jpg" 
                            alt="Customer" 
                            class="w-12 h-12 rounded-full mr-4 object-cover"
                        >
                        <div>
                            <h4 class="font-bold dark:text-white">Michael Chen</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Business Consultant
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Card 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl shadow-lg relative">
                    <div class="absolute top-0 right-0 m-4 text-yellow-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 italic mb-6">
                        "Perfect for my vacation! The online booking was quick, pickup was smooth, and the car was in excellent condition. Highly recommend!"
                    </p>
                    
                    <div class="flex items-center">
                        <img 
                            src="https://randomuser.me/api/portraits/women/67.jpg" 
                            alt="Customer" 
                            class="w-12 h-12 rounded-full mr-4 object-cover"
                        >
                        <div>
                            <h4 class="font-bold dark:text-white">Sarah Thompson</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Travel Blogger
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial Statistics -->
            <div class="mt-16 bg-blue-50 dark:bg-blue-900/30 rounded-xl p-12 text-center">
                <div class="grid md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                            4.8/5
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Average Customer Rating
                        </p>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">
                            95%
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Customer Satisfaction
                        </p>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                            1000+
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Verified Reviews
                        </p>
                    </div>
                
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    Ready to Start Your Adventure?
                </h2>
                <p class="text-xl mb-10 text-blue-100 max-w-2xl mx-auto">
                    Don't wait another moment. Unlock your perfect ride and create unforgettable memories. 
                    Book now and experience the freedom of the open road!
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="#" class="bg-white text-blue-600 hover:bg-blue-100 px-8 py-4 rounded-full font-bold text-lg transition-all transform hover:scale-105 inline-flex items-center">
                        Book Your Car Now
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="#" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-full font-bold text-lg transition-all transform hover:scale-105 inline-flex items-center">
                        View Our Fleet
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Guarantee Section -->
                <div class="mt-12 flex flex-wrap justify-center items-center space-x-4 text-blue-100">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>No Hidden Fees</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>24/7 Support</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                        </svg>
                        <span>Flexible Booking</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php include('template/footer.php') ?>