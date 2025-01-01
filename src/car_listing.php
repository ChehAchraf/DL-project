<?php 
    include('template/header.php');
    require __DIR__ . '/../vendor/autoload.php'; 
    use Classes\Car;
    use Helpers\Database;
    
?>
<?php include('template/hero.php') ?>
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-100 transition-colors duration-300">
    <!-- Header Section -->
    <header class="bg-white dark:bg-gray-800 shadow-md py-6 px-32">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Our Car Fleet</h1>

            <!-- Search and Filter Container -->
            <div class="flex items-center space-x-4">
        <!-- Search Input -->
        <div class="relative">
            <input
                id="searchInput"
                type="text"
                placeholder="Search cars..."
                class="w-64 px-4 py-2 border rounded-full 
                    bg-white dark:bg-gray-700 
                    text-gray-800 dark:text-gray-200
                    border-gray-300 dark:border-gray-600
                    focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="absolute right-3 top-3 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Filter Dropdown -->
        <div class="relative">
            <select id="categoryDropdown"
                    class="appearance-none w-48 px-4 py-2 border rounded-full 
                        bg-white dark:bg-gray-700 
                        text-gray-800 dark:text-gray-200
                        border-gray-300 dark:border-gray-600
                        focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Luxury">Luxury</option>
                <option value="Compact">Compact</option>
                <option value="sport">Sport</option>
                <option value="classic">Classic</option>
            </select>
            <svg class="absolute right-3 top-3 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
</div>


        </div>
    </header>

    <!-- Car Listing Grid -->
     <?php 
        $db = new Database();
        $pdo = $db->getConnection();
        $cars = Car::getAllCars($pdo);
     ?>
    <main class="container mx-auto px-32 py-12">
    <div id="carsContainer" class="grid md:grid-cols-3 gap-8 py-12">
    <!-- AJAX will populate this -->
    </div>
                <div id="OldContainerCars" class="grid md:grid-cols-3 gap-8">
                    <!-- Car Card Template -->
                    <?php foreach($cars as $car): ?>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden 
                        transform transition hover:scale-105 hover:shadow-xl">
                            <div class="relative">
                                <img
                                    src="<?php echo $car['img_path'] ?>"
                                    alt="Luxury Sedan"
                                    class="w-full h-56 object-cover">
                                <div class="absolute top-4 left-4 flex space-x-2">
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                        <?php echo $car['category_name'] ?>
                                    </span>
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                        Certified Pre-Owned
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4 bg-yellow-400 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <?php echo ($car['mileage'] < 100) ? "low mileage" : "high mileage" ?>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo $car['model'] ?></h3>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-gray-600 dark:text-gray-300">(4.5/5)</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 mb-4">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                        <?php echo $car['transmission'] ?>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        5 Seats
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                        <?php echo $car['year'] ?>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-300">Mileage</span>
                                        <span class="text-gray-800 dark:text-gray-200 font-semibold"><?php echo $car['mileage'] ?> miles</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-gray-600 dark:text-gray-300">Fuel type</span>
                                        <span class="text-green-600 font-semibold"><?php echo $car['fuel_type'] ?></span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-300">Price</span>
                                        <span class="block text-xl font-bold text-green-600 dark:text-green-400">
                                            Starts at $<?php echo $car['price'] ?>/day
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-gray-600 dark:text-gray-300 text-sm">Total Price</span>
                                        <span class="block text-lg font-bold text-gray-800 dark:text-white">
                                        <?php echo $car['price'] ?>/week
                                        </span>
                                    </div>
                                </div>

                                <div class="flex space-x-4">
                                    <button class="flex-1 bg-blue-500 text-white py-3 rounded-lg 
                                                hover:bg-blue-600 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                                        </svg>
                                        Book Now
                                    </button>
                                    <button class="flex-1 border border-blue-500 text-blue-500 
                                                dark:border-blue-400 dark:text-blue-400
                                                py-3 rounded-lg hover:bg-blue-50 
                                                dark:hover:bg-blue-900 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </main>
    </div>

<!-- Dark Mode Toggle (Optional) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const carsContainer = document.getElementById('carsContainer');
    const searchInput = document.getElementById('searchInput');
    const categoryDropdown = document.getElementById('categoryDropdown');

    const performSearch = () => {
        document.getElementById('OldContainerCars').style.display = "none"
        const search = searchInput.value.trim(); 
        const category = categoryDropdown.value; 

        let conn = new XMLHttpRequest();
        conn.open(
            "get",
            `helpers/search_hanling.php?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}`,
            true
        );

        conn.onreadystatechange = function () {
            if (conn.readyState === 4 && conn.status === 200) {
                carsContainer.innerHTML = conn.responseText;
            }
        };
        conn.send();
    };
    searchInput.addEventListener('input', performSearch);
    categoryDropdown.addEventListener('change', performSearch);
});

</script>
<?php include('template/footer.php') ?>