<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Classes\Session;
use Helpers\Database;
use Classes\Article;

Session::validateSession();

// Initialize database connection
$db = new Database();
$pdo = $db->getConnection();

// Get all categories
$stmt = $pdo->query("SELECT * FROM category_blog ORDER BY name");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include 'template/header.php'; ?>
<?php include 'template/hero.php'; ?>

    <div class="container mx-auto px-32 py-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Blog</h1>
            <p class="text-lg text-gray-600">Discover the latest insights and stories</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div class="col-span-1 md:col-span-1">
                    <input 
                        type="text" 
                        name="search"
                        placeholder="Search articles..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        hx-get="helpers/blog_handler.php?action=search"
                        hx-trigger="keyup changed delay:500ms"
                        hx-target="#articles-grid"
                        hx-include="[name='category'], [name='sort']"
                    >
                </div>

                <!-- Category Filter -->
                <div>
                    <select 
                        name="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        hx-get="helpers/blog_handler.php?action=search"
                        hx-trigger="change"
                        hx-target="#articles-grid"
                        hx-include="[name='search'], [name='sort']"
                    >
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sort Filter -->
                <div>
                    <select 
                        name="sort" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        hx-get="helpers/blog_handler.php?action=search"
                        hx-trigger="change"
                        hx-target="#articles-grid"
                        hx-include="[name='search'], [name='category']"
                    >
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Articles Grid -->
        <div id="articles-grid" hx-get="helpers/blog_handler.php?action=search" hx-trigger="load" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Articles will be loaded here -->
        </div>
    </div>

<?php include 'template/footer.php'; ?>