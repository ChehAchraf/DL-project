<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Classes\Session;
use Helpers\Database;
use Classes\Article;

Session::validateSession();

// Initialize database connection
$db = new Database();
$pdo = $db->getConnection();

?>

<?php include 'template/header.php'; ?>
<?php include 'template/hero.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Blog</h1>
            <p class="text-lg text-gray-600">Discover the latest insights and stories</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="col-span-1 md:col-span-2">
                    <input 
                        type="text" 
                        placeholder="Search articles..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        hx-get="helpers/blog_handler.php"
                        hx-trigger="keyup changed delay:500ms"
                        hx-target="#articles-grid"
                        hx-include="[name='category'], [name='sort'], [name='tags']"
                    >
                </div>

                <!-- Category Filter -->
                <div>
                    <select 
                        name="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        hx-get="helpers/blog_handler.php"
                        hx-trigger="change"
                        hx-target="#articles-grid"
                        hx-include="[name='search'], [name='sort'], [name='tags']"
                    >
                        <option value="">All Categories</option>

                    </select>
                </div>

                <!-- Sort Filter -->
                <div>
                    <select 
                        name="sort" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        hx-get="helpers/blog_handler.php"
                        hx-trigger="change"
                        hx-target="#articles-grid"
                        hx-include="[name='search'], [name='category'], [name='tags']"
                    >
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>

            <!-- Tags Filter -->
            <div class="mt-4">
                <div class="flex flex-wrap gap-2" id="tags-container">
                    <button 
                        class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200"
                        hx-get="helpers/blog_handler.php"
                        hx-include="[name='search'], [name='category'], [name='sort']"
                        hx-target="#articles-grid"
                    >
                        All
                    </button>

                </div>
            </div>
        </div>

        <!-- Articles Grid -->
        <div id="articles-grid" hx-get="helpers/blog_handler.php" hx-trigger="load" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Article Card 1 -->
        

        </div>

        <!-- Pagination -->

    </div>

<?php include 'template/footer.php'; ?>