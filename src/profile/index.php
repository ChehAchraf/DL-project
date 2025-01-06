<?php 
    require __DIR__ . '/../../vendor/autoload.php'; 

    // calling the classes
    use Helpers\Database;
    use Classes\Car;
    use Classes\User;
    use Classes\Client;
    use Classes\Admin;
    use Classes\Session;
    use Classes\Article;
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
                           data-tab="articles" 
                           class="dashboard-tab flex items-center p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-newspaper mr-3 text-red-500"></i>
                            my articles
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           data-tab="addarticles" 
                           class="dashboard-tab flex items-center p-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-newspaper mr-3 text-red-500"></i>
                            Add Article
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

            <div id="articlesTab" class="dashboard-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold dark:text-white">My Articles</h1>
                    <button onclick="window.location.href='#addarticlesTab'" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Article
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    try {
                        $articles = new Article("", $_SESSION['id']);
                        $userArticles = $articles->getAllArticles($pdo);
                        
                        foreach ($userArticles as $article) {
                            ?>
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <!-- Article Image -->
                                <div class="relative h-48 bg-gray-200">
                                    <?php if ($article['image']): ?>
                                        <img src="../<?php echo htmlspecialchars($article['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($article['title']); ?>" 
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute top-2 right-2">
                                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                            <?php echo htmlspecialchars($article['category_name'] ?? 'Uncategorized'); ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Article Content -->
                                <div class="p-6">
                                    <h2 class="text-xl font-semibold mb-2 dark:text-white">
                                        <?php echo htmlspecialchars($article['title']); ?>
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                        <?php echo htmlspecialchars(substr($article['content'], 0, 150)) . '...'; ?>
                                    </p>
                                    
                                    <!-- Author and Actions -->
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                By <?php echo htmlspecialchars($article['author_name']); ?>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="editArticle(<?php echo $article['id']; ?>)" 
                                                    class="text-blue-500 hover:text-blue-600 dark:text-blue-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteArticle(<?php echo $article['id']; ?>)" 
                                                    class="text-red-500 hover:text-red-600 dark:text-red-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        
                        if (empty($userArticles)) {
                            echo '<div class="col-span-full text-center py-10 bg-white dark:bg-gray-800 rounded-lg shadow">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No articles</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new article</p>
                                    <div class="mt-6">
                                        <button onclick="window.location.href=\'#addarticlesTab\'" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            New Article
                                        </button>
                                    </div>
                                </div>';
                        }
                    } catch (Exception $e) {
                        echo '<div class="col-span-full p-4 text-center text-red-500 bg-white dark:bg-gray-800 rounded-lg shadow">
                                Error loading articles: ' . htmlspecialchars($e->getMessage()) . '
                            </div>';
                    }
                    ?>
                </div>
            </div>
            
            <div id="addarticlesTab" class="dashboard-content hidden">
                <h1 class="text-3xl font-bold mb-6 dark:text-white">Add Article</h1>
                <div id="addarticlesList" class="space-y-4">
                <h1 class="text-2xl font-bold mb-6 text-center">Create a New Article</h1>
                    <form id="articleForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <!-- Title Input -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter article title"
                            />
                        </div>
                        <!-- Content Input -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea
                                id="content"
                                name="content"
                                rows="4"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Write your article content here"
                            ></textarea>
                        </div>
                        <!-- Image Upload -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/jpeg, image/png, image/gif"
                                required
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <p class="text-xs text-gray-500 mt-1">Allowed formats: JPEG, PNG, GIF. Max size: 5MB.</p>
                        </div>
                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                Create Article
                            </button>
                        </div>
                    </form> 
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
<script src="../js/articles.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>