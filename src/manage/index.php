<?php 
// import the autoLoad
require __DIR__ . '/../../vendor/autoload.php'; 

// calling the classes
use Helpers\Database;
use Classes\Car;
use Classes\Review;
use Classes\User;
use Classes\Admin;
use Classes\Session;
Session::validateSession();
if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
    try {
        $db = new Database();
        $pdo = $db->getConnection();
        $cars = Car::getAllCarsWithCategories($pdo);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
include('../template/header.php') 
?>
    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('dark-mode', document.documentElement.classList.contains('dark'));
        }

        function switchTab(tabName) {
            const tabs = ['dashboard', 'cars', 'reservations', 'clients', 'add-car', 'reviews', 'categories'];
            tabs.forEach(tab => {
                const tabElement = document.getElementById(tab + 'Tab');
                const navElement = document.getElementById(tab + 'NavItem');
                if (tabElement) tabElement.classList.add('hidden');
                if (navElement) navElement.classList.remove('bg-blue-600', 'text-white');
            });
            
            const selectedTab = document.getElementById(tabName + 'Tab');
            const selectedNav = document.getElementById(tabName + 'NavItem');
            if (selectedTab) selectedTab.classList.remove('hidden');
            if (selectedNav) selectedNav.classList.add('bg-blue-600', 'text-white');
        }

        function initCharts() {
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: [12000, 19000, 15000, 22000, 18000, 25000],
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });

            new Chart(document.getElementById('reservationsChart'), {
                type: 'bar',
                data: {
                    labels: ['Pending', 'Approved', 'Completed', 'Cancelled'],
                    datasets: [{
                        label: 'Reservation Status',
                        data: [15, 45, 30, 10],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ]
                    }]
                }
            });
        }

        // Initialize on page load
        window.onload = function() {
            if (localStorage.getItem('dark-mode') === 'true') {
                document.documentElement.classList.add('dark');
            }
            switchTab('dashboard');
            initCharts();
        }

        // // Change reservation status
        // function changeReservationStatus(reservationId, status) {
        //     // Placeholder for AJAX call to update status
        //     alert(`Changing reservation ${reservationId} to ${status}`);
        // }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex">    
    <!-- Sidebar Navigation -->
    <div class="w-64 bg-white dark:bg-gray-800 shadow-xl h-screen fixed left-0 top-0 z-40">
        <div class="p-6 border-b dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h1>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <button 
                        id="dashboardNavItem"
                        onclick="switchTab('dashboard')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-chart-pie mr-3"></i> Dashboard
                    </button>
                </li>
                <li>
                    <button 
                        id="carsNavItem"
                        onclick="switchTab('cars')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-car mr-3"></i> Manage Cars
                    </button>
                </li>
                <li>
                    <button 
                        id="add-carNavItem"
                        onclick="switchTab('add-car')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-plus-circle mr-3"></i> Add New Car
                    </button>
                </li>
                <li>
                    <button 
                        id="reservationsNavItem"
                        onclick="switchTab('reservations')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-calendar-alt mr-3"></i> Reservations
                    </button>
                </li>
                <li>
                    <button 
                        id="clientsNavItem"
                        onclick="switchTab('clients')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-users mr-3"></i> Clients
                    </button>
                </li>
                <li>
                    <button 
                        id="reviewsNavItem"
                        onclick="switchTab('reviews')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-star mr-3"></i> Reviews
                    </button>
                </li>
                <li>
                    <button 
                        id="categoriesNavItem"
                        onclick="switchTab('categories')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-list mr-3"></i> Categories
                    </button>
                </li>
                <li>
                    <button 
                        id="postmanageNavItem"
                        onclick="switchTab('postmanage')" 
                        class="w-full text-left px-4 py-2 rounded hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center"
                    >
                        <i class="fas fa-newspaper mr-3"></i> Post Management
                    </button>
                </li>
            </ul>
        </nav>
        <div class="absolute bottom-0 left-0 w-full p-4">
            <button 
                onclick="toggleDarkMode()" 
                class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 rounded flex items-center justify-center"
            >
                <i class="fas fa-moon dark:hidden mr-2"></i>
                <i class="fas fa-sun hidden dark:inline mr-2"></i>
                Toggle Dark Mode
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="ml-64 flex-1 p-8">
        <!-- Dashboard Tab -->
        <div id="dashboardTab" class="space-y-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Dashboard Overview</h2>
            
            <!-- Quick Stats -->
            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-400">Total Cars</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">52</p>
                        </div>
                        <i class="fas fa-car text-blue-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-400">Active Reservations</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">24</p>
                        </div>
                        <i class="fas fa-calendar-check text-green-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-400">Total Clients</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">187</p>
                        </div>
                        <i class="fas fa-users text-purple-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-400">Monthly Revenue</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">$45,230</p>
                        </div>
                        <i class="fas fa-dollar-sign text-yellow-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4">Monthly Revenue</h3>
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4">Reservation Status</h3>
                    <canvas id="reservationsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <?php 
            try {
                $db = new Database();
                $pdo = $db->getConnection();
                $cars = Car::getAllCarsWithCategories($pdo);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                exit;
            }
        ?>
        <!-- Manage Cars Tab -->
        <div id="carsTab">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Manage Cars</h2>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-900">
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Model</th>
                        <th class="p-4 text-left">Category</th>
                        <th class="p-4 text-left">Daily Rate</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                    <tr class="border-b dark:border-gray-700" id="car-row-<?php echo $car['id']; ?>">
                        <td class="p-4">CAR-<?php echo str_pad($car['id'], 3, '0', STR_PAD_LEFT); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($car['model']); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($car['category_name']); ?></td>
                        <td class="p-4">$<?php echo number_format($car['price'], 2); ?>/day</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs <?php echo $car['availability'] === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo ucfirst($car['availability']); ?>
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex space-x-2">
                                <button 
                                    onclick="openEditCategoryModal(<?php echo $car['id']; ?>, '<?php echo htmlspecialchars($car['model']); ?>')" 
                                    class="text-blue-500 hover:text-blue-700" 
                                    title="Edit Car"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    onclick="deleteCar(<?php echo $car['id']; ?>)"
                                    class="text-red-500 hover:text-red-700" 
                                    title="Delete Car"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Category</h3>
            <button onclick="closeEditModal()" class="text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <!-- Hidden input for category ID -->
            <input type="hidden" id="editCategoryId">

            <!-- Input for category name -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                <input 
                    type="text" 
                    id="editCategoryName" 
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600"
                    placeholder="Enter category name"
                >
            </div>
            
            <!-- Action buttons -->
            <div class="flex justify-end space-x-4">
                <button 
                    onclick="closeEditModal()"
                    class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Cancel
                </button>
                <button 
                    onclick="updateCategory()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Update Category
                </button>
            </div>
        </div>
    </div>
</div>
    <div id="editCarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Car</h3>
            <form id="editCarForm" onsubmit="updateCar(event)" class="mt-4">
                <input type="hidden" id="edit-car-id" name="carId">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-model">
                        Model
                    </label>
                    <input type="text" id="edit-model" name="model" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-price">
                        Daily Rate
                    </label>
                    <input type="number" id="edit-price" name="price" step="0.01" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-category">
                        Category
                    </label>
                    <input type="text" id="edit-category" name="category" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-availability">
                        Availability
                    </label>
                    <select id="edit-availability" name="availability" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="available">Available</option>
                        <option value="unavailable">Not Available</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-mileage">
                        Mileage
                    </label>
                    <input type="number" id="edit-mileage" name="mileage" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-year">
                        Year
                    </label>
                    <input type="number" id="edit-year" name="year" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-fuel-type">
                        Fuel Type
                    </label>
                    <input type="text" id="edit-fuel-type" name="fuel_type" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-transmission">
                        Transmission
                    </label>
                    <input type="text" id="edit-transmission" name="transmission" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-description">
                        Description
                    </label>
                    <textarea id="edit-description" name="description" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Car
                    </button>
                    <button type="button"
                            onclick="document.getElementById('editCarModal').style.display='none'"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
   


        <!-- Add New Car Tab -->
        <div id="add-carTab" class="hidden">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Add New Car</h2>
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow">

            <form class="grid md:grid-cols-2 gap-6" action="../helpers/car_add_handling.php" method="POST" enctype="multipart/form-data">
                <!-- Car Model -->
                <div>
                    <label for="model" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Car Model</label>
                    <input 
                        type="text" 
                        id="model"
                        name="model"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        placeholder="Enter car model" 
                        required
                    >
                </div>

                <!-- Category -->
                 <?php 
                        $db = new Database();
                        $pdo = $db->getConnection();
                        $stmt = $pdo->prepare("SELECT * FROM `categories`");
                        $stmt->execute();
                    
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                       
                 ?>
                <div>
                    <label for="category" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <select 
                        id="category" 
                        name="category_id"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        required
                    >
                        <option value="" disabled selected>Select a category</option>
                        <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Price (Daily Rate)</label>
                    <input 
                        type="number" 
                        id="price"
                        name="price"
                        step="0.01"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        placeholder="Enter daily rate" 
                        required
                    >
                </div>

                <!-- Availability -->
                <div>
                    <label for="availability" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Availability</label>
                    <select 
                        id="availability" 
                        name="availability"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        required
                    >
                        <option value="" disabled selected>Select availability</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                    </div>

                <!-- Mileage -->
                <div>
                    <label for="mileage" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Mileage</label>
                    <input 
                        type="number" 
                        id="mileage"
                        name="mileage"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        placeholder="Enter mileage (km)" 
                        required
                    >
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Year</label>
                    <input 
                        type="number" 
                        id="year"
                        name="year"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        placeholder="Enter year of manufacture" 
                        min="1900" 
                        max="2099" 
                        required
                    >
                </div>

                <!-- Fuel Type -->
                <div>
                    <label for="fuel_type" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Fuel Type</label>
                    <select 
                        id="fuel_type" 
                        name="fuel_type"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        required
                    >
                        <option value="" disabled selected>Select fuel type</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Electric</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>

                <!-- Transmission -->
                <div>
                    <label for="transmission" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Transmission</label>
                    <select 
                        id="transmission" 
                        name="transmission"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        required
                    >
                        <option value="" disabled selected>Select transmission type</option>
                        <option value="manual">Manual</option>
                        <option value="automatic">Automatic</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea 
                        id="description"
                        name="description"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        rows="3"
                        placeholder="Enter car description" 
                        required
                    ></textarea>
                </div>

                <!-- Upload Car Image -->
                <div class="md:col-span-2">
                    <label for="car_image" class="block mb-2 font-medium text-gray-700 dark:text-gray-300">Upload Car Image</label>
                    <input 
                        type="file" 
                        id="car_image"
                        name="car_image"
                        accept="image/*"
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        required
                    >
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2">
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
                    >
                        Add Car
                    </button>
                </div>
            </form>

            </div>
        </div>

        <!-- Reservations Tab -->
        <div id="reservationsTab" class="hidden">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Reservations</h2>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <?php 
                    $db = new Database();
                    $pdo = $db->getConnection();
                    $reservations = Admin::ReservationHandling($pdo);
                ?>
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-900">
                            <th class="p-4 text-left">Reservation ID</th>
                            <th class="p-4 text-left">Client</th>
                            <th class="p-4 text-left">Car</th>
                            <th class="p-4 text-left">Dates</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($reservations)) : ?>
                        <?php foreach ($reservations as $reservation) : ?>
                            </thead>
                    <tbody>
                        <tr class="border-b dark:border-gray-700">
                            <td class="p-4">RES-<?php echo $reservation['id'] ?></td>
                            <td class="p-4"><?php echo $reservation['name'] ?></td>
                            <td class="p-4"><?php echo $reservation['model'] ?></td>
                            <td class="p-4"><?php echo $reservation['start_date']; ?> - <?php echo $reservation['end_date']; ?></td>
                            <td class="p-4">
                                <select 
                                    onchange="changeReservationStatus('<?php echo $reservation['id']; ?>', this.value)"
                                    class="px-2 py-1 rounded bg-yellow-100 text-yellow-800"
                                    data-reservation-id="<?php echo $reservation['id']; ?>"
                                    data-current-status="<?php echo $reservation['status']; ?>"
                                >
                                    <option value="pending" <?php echo $reservation['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo $reservation['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?php echo $reservation['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                            </td>
                            <td class="p-4">
                                <button class="text-blue-500 mr-2" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-red-500" title="Cancel Reservation">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="p-4 text-center">No reservations found.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Clients Tab -->
            <div id="clientsTab" class="hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Clients Management</h2>
                    <div class="flex items-center space-x-4">
                        <input 
                            type="text" 
                            placeholder="Search clients..." 
                            class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                        >
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <?php 
                    try {
                        $admin = new Admin("","","","");
                        $users = $admin->listUsers($pdo);
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                        exit;
                    }
                ?>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-900">
                                <th class="p-4 text-left">ID</th>
                                <th class="p-4 text-left">Name</th>
                                <th class="p-4 text-left">Email</th>
                                <th class="p-4 text-left">Total Reservations</th>
                                <th class="p-4 text-left">Registered Date</th>
                                <th class="p-4 text-left">Role</th>
                                <th class="p-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="border-b dark:border-gray-700" id="user-row-<?php echo $user['id']; ?>">
                                <td class="p-4">CLI-<?php echo str_pad($user['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td class="p-4"><?php echo htmlspecialchars($user['name'] . ' ' . $user['s_name']); ?></td>
                                <td class="p-4"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="p-4">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        3 Reservations
                                    </span>
                                </td>
                                <td class="p-4"><?php echo date('F d, Y', strtotime($user['created_at'])); ?></td>
                                <td class="p-4">
                                    <select 
                                        class="role-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        onchange="updateRole(<?php echo $user['id']; ?>, this.value)"
                                        <?php echo $user['role'] === 'admin' ? 'disabled' : ''; ?>
                                    >
                                        <option value="client" <?php echo $user['role'] === 'client' ? 'selected' : ''; ?>>Client</option>
                                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                </td>
                                <td class="p-4">
                                    <?php if ($user['role'] !== 'admin'): ?>
                                    <button 
                                        class="text-red-500 hover:text-red-700" 
                                        title="Delete User" 
                                        onclick="deleteUser(<?php echo $user['id']; ?>)"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            </div>
            
            

        </div>
        <!-- Reviews Tab -->
    <div id="reviewsTab" class="hidden">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Reviews Management</h2>
        <div class="flex items-center space-x-4">
            <input 
                type="text" 
                placeholder="Search reviews..." 
                class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
            >
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <?php
    try {
        // Fetch reviews from the database using the listReviews method
        $db = new Database();
        $pdo = $db->getConnection();
        $reviews = Review::listReviews($pdo); // Use the listReviews method
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    ?>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900">
                    <th class="p-4 text-left">Review ID</th>
                    <th class="p-4 text-left">Client</th>
                    <th class="p-4 text-left">Car</th>
                    <th class="p-4 text-left">Rating</th>
                    <th class="p-4 text-left">Comment</th>
                    <th class="p-4 text-left">Date</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reviews)) : ?>
                    <?php foreach ($reviews as $review) : ?>
                        <tr class="border-b dark:border-gray-700" data-review-id="<?php echo $review['id']; ?>">
                            <td class="p-4">REV-<?php echo str_pad($review['id'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td class="p-4" data-client-name="<?php echo htmlspecialchars($review['name'] . ' ' . $review['s_name']); ?>">
                                <?php echo htmlspecialchars($review['name'] . ' ' . $review['s_name']); ?>
                            </td>
                            <td class="p-4" data-car-model="<?php echo htmlspecialchars($review['model']); ?>">
                                <?php echo htmlspecialchars($review['model']); ?>
                            </td>
                            <td class="p-4" data-rating="<?php echo $review['rating']; ?>">
                                <div class="flex items-center">
                                    <?php for ($i = 0; $i < $review['rating']; $i++) : ?>
                                        <i class="fas fa-star text-yellow-400"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = $review['rating']; $i < 5; $i++) : ?>
                                        <i class="fas fa-star text-gray-300"></i>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td class="p-4" data-comment="<?php echo htmlspecialchars($review['comment']); ?>">
                                <?php echo htmlspecialchars($review['comment']); ?>
                            </td>
                            <td class="p-4" data-date="<?php echo date('F d, Y', strtotime($review['created_at'])); ?>">
                                <?php echo date('F d, Y', strtotime($review['created_at'])); ?>
                            </td>
                            <td class="p-4">
                                <button 
                                    class="text-blue-500 hover:text-blue-700 mr-2" 
                                    title="View Details"
                                    onclick="viewReviewDetails(<?php echo $review['id']; ?>)"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if($review['is_deleted'] == 0): ?>
                                <button 
                                    class="text-red-500 hover:text-red-700" 
                                    title="Delete Review"
                                    onclick="deleteReview(<?php echo $review['id']; ?>)"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                                <?php if($review['is_deleted'] == 1): ?>
                                <button 
                                    class="text-green-500 hover:text-green-700" 
                                    title="Restore Review"
                                    onclick="restoreReview(<?php echo $review['id']; ?>)"
                                >
                                    <i class="fas fa-undo"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="p-4 text-center">No reviews found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
<div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Add New Category</h3>
            <button onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                <input 
                    id="categoryNameInput"
                    type="text" 
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600"
                    placeholder="Enter category name"
                >
            </div>
            
            <div class="flex justify-end space-x-4">
                <button 
                    onclick="document.getElementById('addCategoryModal').classList.add('hidden')"
                    class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Cancel
                </button>
                <button 
                    onclick="addcategory()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Add Category
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Review Details -->
<div id="reviewDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Review Details</h2>
            <button onclick="document.getElementById('reviewDetailsModal').classList.add('hidden')" class="text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-2">Client Name</label>
                <input 
                    type="text" 
                    id="reviewClientName" 
                    readonly 
                    class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                >
            </div>
            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-2">Car Model</label>
                <input 
                    type="text" 
                    id="reviewCarModel" 
                    readonly 
                    class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                >
            </div>
            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-2">Rating</label>
                <div id="reviewRating" class="flex items-center"></div>
            </div>
            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-2">Comment</label>
                <textarea 
                    id="reviewComment" 
                    readonly 
                    class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                    rows="3"
                ></textarea>
            </div>
            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-2">Date</label>
                <input 
                    type="text" 
                    id="reviewDate" 
                    readonly 
                    class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                >
            </div>
        </div>
    </div>
</div>
<!-- Categories Tab -->
    <div id="categoriesTab" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Categories Management</h2>
            <button onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add Category
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Name</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr class="border-b dark:border-gray-700">
                            <td class="p-4"><?= $category['id'] ?></td>
                            <td class="p-4"><?= htmlspecialchars($category['name']) ?></td>
                            <td class="p-4">
                                <button onclick="openEditCategoryModal(<?= $category['id'] ?>, '<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>')" class="text-blue-500 hover:text-blue-700 mr-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteCategory(<?= $category['id'] ?>)" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="postmanageTab" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Post Management</h2>
        </div>

        <div id="postshowdiv" hx-trigger="load" hx-post="../helpers/articles_admin_handler.php?action=get_post" hx-swap="innerHTML" hx-target="#postshowdiv" class="grid grid-cols-3 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Post Card Template -->
            

        </div>

        <!-- Post Details Modal -->
        <div id="postModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-2xl mx-4">
                <div id="postDetailsContent" class="p-6">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>

        <script>
            function viewPostDetails(postId) {
                const modal = document.getElementById('postModal');
                const content = document.getElementById('postDetailsContent');
                
                // Show modal
                modal.classList.remove('hidden');
                
                // Load post details
                fetch(`../helpers/articles_admin_handler.php?action=post_details&id=${postId}`)
                    .then(response => response.text())
                    .then(html => {
                        content.innerHTML = html;
                    })
                    .catch(error => {
                        content.innerHTML = '<div class="text-red-500">Error loading post details</div>';
                        console.error('Error:', error);
                    });
            }

            function closePostModal() {
                document.getElementById('postModal').classList.add('hidden');
            }

            function approvePost(postId) {
                if (!confirm('Are you sure you want to approve this post?')) return;

                fetch('../helpers/articles_admin_handler.php?action=approve', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${postId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success'
                        }).then(() => {
                            closePostModal();
                            // Refresh the posts list
                            document.getElementById('postshowdiv').dispatchEvent(new Event('htmx:load'));
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Failed to approve post',
                        icon: 'error'
                    });
                });
            }

            function rejectPost(postId) {
                if (!confirm('Are you sure you want to reject this post?')) return;

                fetch('../helpers/articles_admin_handler.php?action=reject', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${postId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success'
                        }).then(() => {
                            closePostModal();
                            // Refresh the posts list
                            document.getElementById('postshowdiv').dispatchEvent(new Event('htmx:load'));
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Failed to reject post',
                        icon: 'error'
                    });
                });
            }

            // Close modal when clicking outside
            document.getElementById('postModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closePostModal();
                }
            });
        </script>
    </div>

    <script>
function viewReviewDetails(reviewId) {
    // Find the review data from the table row
    const row = document.querySelector(`tr[data-review-id="${reviewId}"]`);
    if (!row) return;

    // Get the modal
    const modal = document.getElementById('reviewDetailsModal');
    if (!modal) return;

    // Get the data from the row
    const clientName = row.querySelector('[data-client-name]').getAttribute('data-client-name');
    const carModel = row.querySelector('[data-car-model]').getAttribute('data-car-model');
    const rating = parseInt(row.querySelector('[data-rating]').getAttribute('data-rating'));
    const comment = row.querySelector('[data-comment]').getAttribute('data-comment');
    const date = row.querySelector('[data-date]').getAttribute('data-date');

    // Populate the modal
    document.getElementById('reviewClientName').value = clientName;
    document.getElementById('reviewCarModel').value = carModel;
    
    // Update rating stars
    const ratingDiv = document.getElementById('reviewRating');
    ratingDiv.innerHTML = Array(5).fill(0).map((_, i) => 
        `<i class="fas fa-star ${i < rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`
    ).join('');
    
    document.getElementById('reviewComment').value = comment;
    document.getElementById('reviewDate').value = date;

    // Show the modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function deleteCategory(categoryId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this category. This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../helpers/delete_category.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("category_id=" + encodeURIComponent(categoryId));

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Category deleted successfully!',
                        }).then(() => {
                            location.reload(); // Reload the page to reflect the deleted category
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Failed to delete category: ' + response.error,
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the category.',
                    });
                }
            };
        }
    });
}
// Function to add a category
function addcategory() {
    var name = document.getElementById('categoryNameInput').value;

    // Validate the category name
    if (!validateCategoryName(name)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Category name cannot be empty or just spaces.',
        });
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../helpers/add_category.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("name=" + encodeURIComponent(name));

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category added successfully!',
                }).then(() => {
                    closeModal(); // Close the modal
                    location.reload(); // Reload the page to reflect the new category
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to add category: ' + response.error,
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding the category.',
            });
        }
    };
}
</script>

    <!-- Modal for Client Details (can be dynamically populated) -->
    <div id="clientDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Client Details</h2>
                <button onclick="document.getElementById('clientDetailsModal').classList.add('hidden')" class="text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-600 dark:text-gray-300 mb-2">Full Name</label>
                    <input 
                        type="text" 
                        value="John Doe" 
                        readonly 
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                    >
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-300 mb-2">Email</label>
                    <input 
                        type="email" 
                        value="john.doe@example.com" 
                        readonly 
                        class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600"
                    >
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-300 mb-2">Reservations</label>
                    <ul class="border rounded dark:border-gray-600 divide-y dark:divide-gray-600">
                        <li class="px-4 py-2">RES-001: Toyota Camry (July 15-22, 2024)</li>
                        <li class="px-4 py-2">RES-003: Honda Civic (August 5-10, 2024)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
function changeReservationStatus(reservationId, newStatus) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../helpers/update_status.php?id=' + reservationId + '&status=' + newStatus, true);
    
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log("Status updated successfully");
                } else {
                    console.error("Error updating status");
                }
            };
            
            xhr.send(); 
    }


    </script>
    <!-- Include the JavaScript files -->
    <script src="../js/useractions.js"></script>
    <script src="../js/carAction.js"></script>
    <script src="../js/reviews.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        import { deleteCar, openEditModal, updateCar } from '../js/carManagement.js';
        window.deleteCar = deleteCar;
        window.openEditModal = openEditModal;
        window.updateCar = updateCar;

        // Move the viewReviewDetails function here
        window.viewReviewDetails = function(reviewId) {
            // Find the review data from the table row
            const row = document.querySelector(`tr[data-review-id="${reviewId}"]`);
            if (!row) return;

            // Get the modal
            const modal = document.getElementById('reviewDetailsModal');
            if (!modal) return;

            // Get the data from the row
            const clientName = row.querySelector('[data-client-name]').getAttribute('data-client-name');
            const carModel = row.querySelector('[data-car-model]').getAttribute('data-car-model');
            const rating = parseInt(row.querySelector('[data-rating]').getAttribute('data-rating'));
            const comment = row.querySelector('[data-comment]').getAttribute('data-comment');
            const date = row.querySelector('[data-date]').getAttribute('data-date');

            // Populate the modal
            document.getElementById('reviewClientName').value = clientName;
            document.getElementById('reviewCarModel').value = carModel;
            
            // Update rating stars
            const ratingDiv = document.getElementById('reviewRating');
            ratingDiv.innerHTML = Array(5).fill(0).map((_, i) => 
                `<i class="fas fa-star ${i < rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`
            ).join('');
            
            document.getElementById('reviewComment').value = comment;
            document.getElementById('reviewDate').value = date;

            // Show the modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    </script>
<!-- Add Category Modal -->

<script src="../js/cate.js"></script>
</body>

</html>


<?php 
    $categories = $admin->listCategories($pdo);
?>



<?php
}else{
    header("Location: ../index.php");
    exit();
}
?>