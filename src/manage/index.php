<?php 
// import the autoLoad
require __DIR__ . '/../../vendor/autoload.php'; 

// calling the classes
use Helpers\Database;
use Classes\Car;
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
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('dark-mode', document.documentElement.classList.contains('dark'));
        }

        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            ['dashboard', 'cars', 'reservations', 'clients', 'add-car'].forEach(tab => {
                document.getElementById(tab + 'Tab').classList.add('hidden');
                document.getElementById(tab + 'NavItem').classList.remove('bg-blue-600', 'text-white');
            });

            // Show selected tab
            document.getElementById(tabName + 'Tab').classList.remove('hidden');
            document.getElementById(tabName + 'NavItem').classList.add('bg-blue-600', 'text-white');
        }

        // Initialize charts
        function initCharts() {
            // Revenue Chart
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

            // Reservations Chart
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
                                    onclick="openEditModal(<?php echo $car['id']; ?>)" 
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

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Showing 1-10 of 50 clients
                </p>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600">
                        Previous
                    </button>
                    <button class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <!-- Include the JavaScript file -->
<script src="../js/useractions.js"></script>
<script src="../js/carAction.js"></script>
<script type="module">
        import { deleteCar, openEditModal, updateCar } from '../js/carManagement.js';
        window.deleteCar = deleteCar;
        window.openEditModal = openEditModal;
        window.updateCar = updateCar;
    </script>
</body>

</html>
<?php }else{
    header("Location: ../index.php");
} ?>