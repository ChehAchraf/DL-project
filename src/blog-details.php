<?php 
    include('template/header.php');
    require __DIR__ . '/../vendor/autoload.php'; 
    use Classes\Session;
    use Classes\Car;
    use Classes\Article;
    use Helpers\Database;
    use Classes\Review;
    use Classes\Comment;
    use Classes\Admin;
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo $id;
        $db = new Database();
        $pdo = $db->getConnection();
        $article = new Article("","");
        $article = $article->getPostDetails($pdo, $id);
        echo "<pre>";
        print_r($article);
        echo "</pre>";
        $comment = new Comment("", "", "");
        $comments = $comment->getCommentsByArticle($pdo, $id);



    }
    
?>

<main class="max-w-4xl mx-auto px-4 py-8">
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Featured Image -->
            <img src="../<?php echo $article['image']; ?>" alt="Blog Post Image" class="w-full h-[400px] object-cover">
            
            <!-- Post Content -->
            <div class="p-8">
                <!-- Post Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo $article['title']; ?></h1>
                    <div class="flex items-center text-gray-600 text-sm">
                        <span class="mr-4">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <?php echo $article['author_name']; ?>
                        </span>
                        <span class="mr-4">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"></path>
                            </svg>
                            <?php echo $article['article_created_at']; ?>
                        </span>
                        <span>
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                            </svg>
                            <?php echo $article['comment_count']; ?> Comments
                        </span>
                    </div>
                </div>

                <!-- Post Body -->
                <div class="prose max-w-none">
                    <div class="text-gray-700 dark:text-gray-300">
                        <?php echo $article['content']; ?>
                    </div>
                </div>

                <!-- Tags -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex flex-wrap gap-2">
                        <?php
                            $tags = explode(',', $article['tags']);
                            foreach ($tags as $tag):
                        ?>
                            <div class="group px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 flex items-center gap-1">
                                <span><?= htmlspecialchars(trim($tag)) ?></span>
                                <input type="hidden" name="tags[]" value="<?= htmlspecialchars(trim($tag)) ?>">
                            </div>
                        <?php 
                            endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </article>



        <!-- Comments Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mt-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Comments (<?php echo $article['comment_count']; ?>)</h3>
            <?php foreach ($comments as $comment): ?>    
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <div class="flex items-start">
                        <img src="https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png" alt="Commenter" class="w-10 h-10 rounded-full mr-4">
                        <div>
                            <div class="flex items-center mb-2">
                                <h4 class="font-semibold text-gray-900 mr-2"><?php echo $comment['user_name']; ?></h4>
                                <span class="text-sm text-gray-600">2 hours ago</span>
                            </div>
                            <p class="text-gray-700"><?php echo $comment['comment']; ?>.</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Comment Form -->
            <div class="mt-8">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h4>
                <form hx-post="helpers/comment_handler.php?action=add" 
                      hx-target="this"
                      hx-swap="outerHTML"
                      class="space-y-4">
                    <div>
                        <textarea name="content" 
                                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                 rows="4" 
                                 placeholder="Your comment"
                                 required></textarea>
                    </div>
                    <input type="hidden" name="article_id" value="<?php echo $id; ?>">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Post Comment
                    </button>
                </form>
            </div>
        </div>
    </main>


<?php include('template/footer.php') ?>