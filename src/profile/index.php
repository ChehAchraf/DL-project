<?php 
    require __DIR__ . '/../../vendor/autoload.php'; 

    // calling the classes
    use Helpers\Database;
    use Classes\Car;
    use Classes\User;
    use Classes\Client;
    use Classes\Admin;
    use Classes\Session;
    Session::validateSession();
    $db = new Database();
    $pdo = $db->getConnection();
    $user_id = $_SESSION['id'];
    $client = new Client("","","","",$user_id);
    $get_user_info = $client->getuserinformation($pdo,$user_id);
    $getuserreservationinfo = $client->getreservationinformation($pdo,$user_id);



include('../template/header.php'); 

?>
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
                            <?php echo $get_user_info['name']; ?>
                        </h2>
                        <p id="userEmail" class="text-gray-500 dark:text-gray-400">
                            <?php echo $get_user_info['email']; ?>
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
                            <input type="text" id="fullNameInput" value="<?php echo $get_user_info['name'] . ' ' . $get_user_info['s_name']; ?>"
                                   class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="emailInput" value="<?php echo $get_user_info['email']; ?>"
                                   class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>
                    <button class="mt-6 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Update Profile
                    </button>
                </div>
            </div>

            <div id="reservationsTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">My Reservations</h1>
                <div id="reservationsList" class="space-y-4">
                    <!-- Active Reservations -->
                    <?php foreach ($getuserreservationinfo as $reservation): ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold dark:text-white"><?php echo $reservation['car_model']; ?></h3>
                                    <p class="text-gray-600 dark:text-gray-400">Reservation #: RES<?php echo $reservation['id']; ?></p>
                                    <div class="mt-2">
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <i class="fas fa-calendar-alt mr-2"></i><?php echo $reservation['start_date']; ?> - <?php echo $reservation['end_date']; ?>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <i class="fas fa-map-marker-alt mr-2"></i>Pickup Location: <?php echo $reservation['pickup_location'];?> || Return Location: <?php echo $reservation['return_location']; ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-<?php echo $reservation['status'] === 'approved' ? 'green' : ($reservation['status'] === 'pending' ? 'yellow' : 'red'); ?>-100 text-white-800 rounded-full"><?php echo $reservation['status']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Past Reservation -->

                </div>
            </div>
            <?php 
                $getuserreviews = $client->getuserreviews($pdo,$user_id);
            ?>
            <div id="reviewsTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">My Reviews</h1>
                <div id="reviewsList" class="space-y-4">
                    <?php foreach ($getuserreviews as $review): ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400">
                                    <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="ml-2 text-gray-600 dark:text-gray-400"><?php echo $review['rating']; ?></span>
                            </div>
                            <h3 class="text-xl font-semibold dark:text-white"></h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">
                                <?php echo $review['comment']; ?>
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2"><?php echo $review['created_at']; ?></p>
                            <a href="#" class="text-blue-500 hover:underline" onclick="deleteReview(<?php echo $review['id']; ?>)">Delete</a>
                        </div>
                    <?php endforeach; ?>    
                </div>
            </div>

            <div id="settingsTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">Account Settings</h1>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                    <!-- Notification Settings -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 dark:text-white">Notification Preferences</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Email Notifications</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 dark:text-gray-300">SMS Notifications</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Password Change -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 dark:text-white">Change Password</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                                <input type="password" class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                                <input type="password" class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                                <input type="password" class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            </div>
                            <button class="mt-4 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                                Update Password
                            </button>
                        </div>
                    </div>
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
<script src="../js/reviews.js"></script>
<script src="../js/reviewDelete.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>