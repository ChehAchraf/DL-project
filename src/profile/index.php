<?php include('../template/header.php') ?>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md">
            <div class="p-6 border-b dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <img 
                        id="userProfilePic" 
                        src="path/to/default-avatar.png" 
                        alt="Profile" 
                        class="w-16 h-16 rounded-full object-cover"
                    >
                    <div>
                        <h2 id="userName" class="text-xl font-semibold dark:text-white">
                            John Doe
                        </h2>
                        <p id="userEmail" class="text-gray-500 dark:text-gray-400">
                            john.doe@example.com
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#" 
                           data-tab="profile" 
                           class="dashboard-tab flex items-center p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-user mr-3 text-blue-500"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           data-tab="reservations" 
                           class="dashboard-tab flex items-center p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-car mr-3 text-green-500"></i>
                            Reservations
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           data-tab="reviews" 
                           class="dashboard-tab flex items-center p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-star mr-3 text-yellow-500"></i>
                            My Reviews
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           data-tab="settings" 
                           class="dashboard-tab flex items-center p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                            Settings
                        </a>
                    </li>
                </ul>

                <!-- Dark Mode Toggle -->
                <div class="mt-6 pt-4 border-t dark:border-gray-700">
                    <button id="darkModeToggle" class="w-full flex items-center justify-center p-3 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <i id="darkModeIcon" class="fas fa-moon mr-3"></i>
                        Toggle Dark Mode
                    </button>
                </div>

                <!-- Logout -->
                <div class="mt-4">
                    <button id="logoutBtn" class="w-full flex items-center justify-center p-3 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-10 overflow-y-auto">
            <!-- Dynamic Content Sections -->
            <div id="profileTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">Profile Information</h1>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                            <input type="text" id="fullNameInput" 
                                   class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="emailInput" 
                                   class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <!-- More profile fields -->
                    </div>
                    <button class="mt-6 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Update Profile
                    </button>
                </div>
            </div>

            <div id="reservationsTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">My Reservations</h1>
                <div id="reservationsList" class="space-y-4">
                    <!-- Reservation cards will be dynamically populated -->
                </div>
            </div>

            <div id="reviewsTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">My Reviews</h1>
                <div id="reviewsList" class="space-y-4">
                    <!-- Review cards will be dynamically populated -->
                </div>
            </div>

            <div id="settingsTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">Account Settings</h1>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                    <!-- Settings content -->
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab Management
        const tabs = document.querySelectorAll('.dashboard-tab');
        const contents = document.querySelectorAll('.dashboard-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remove active states
                tabs.forEach(t => t.classList.remove('bg-blue-100', 'dark:bg-gray-700'));
                contents.forEach(c => c.classList.add('hidden'));

                // Activate current tab
                this.classList.add('bg-blue-100', 'dark:bg-gray-700');
                document.getElementById(`${targetTab}Tab`).classList.remove('hidden');
            });
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');

        darkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            
            if (document.documentElement.classList.contains('dark')) {
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
            } else {
                darkModeIcon.classList.remove('fa-sun');
                darkModeIcon.classList.add('fa-moon');
            }

            // Optional: Save preference to localStorage
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        });

        // Logout functionality
        document.getElementById('logoutBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Logout',
                text: 'Are you sure you want to log out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php'; // Redirect to logout script
                }
            });
        });

        // Load initial tab (Profile)
        document.querySelector('[data-tab="profile"]').click();
    });
    </script>
