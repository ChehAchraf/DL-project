<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Helpers\Database;
use Classes\Session;
use Classes\Article;

Session::validateSession();

$db = new Database();
$pdo = $db->getConnection();

try {
    $article = new Article("", "", "", "");
    $articles = $article->listArticles($pdo);
    foreach ($articles as $article) {
        $html = "<div class='bg-white rounded-lg shadow-lg overflow-hidden'>
        <!-- Article Image -->
        <img src='../{$article['image']}' alt='{$article['title']}' class='w-full h-48 object-cover'>
        <!-- Article Content -->
        <div class='p-6'>
            <!-- Article Title -->
            <h3 class='text-xl font-bold mb-2'>{$article['title']}</h3>
            <!-- Article Description -->
            <p class='text-gray-700 mb-4'>
                {$article['content']}
            </p>
            <!-- Article Metadata -->
            <div class='flex items-center space-x-4 text-sm text-gray-600'>
                <!-- Category -->
                <span class='bg-blue-100 text-blue-800 px-2 py-1 rounded'>{$article['category_name']}</span>
                <!-- Tags -->
                <span class='bg-green-100 text-green-800 px-2 py-1 rounded'>{$article['tags']}</span>
            </div>
            <!-- Article Date -->
            <p class='text-sm text-gray-500 mt-4'>Posted on: </p>
        </div>
    </div>";
    echo $html;
    }


} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}