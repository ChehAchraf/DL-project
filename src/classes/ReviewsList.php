<?php
namespace Classes;

class ReviewsList {
    public static function render($pdo, $carId) {
        $stmt = $pdo->prepare("
            SELECT r.*, u.name, u.s_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.car_id = :car_id AND r.is_deleted = FALSE 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute(['car_id' => $carId]);
        $reviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        ob_start();
        ?>
        <div class="reviews-container max-w-4xl mx-auto p-4">
            <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
            
            <!-- Review Form -->
            <form id="reviewForm" onsubmit="submitReview(event)" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-8">
                <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">
                        Rating
                    </label>
                    <select name="rating" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Rating</option>
                        <?php for($i = 5; $i >= 1; $i--): ?>
                            <option value="<?php echo $i; ?>"><?php echo str_repeat('★', $i) . str_repeat('☆', 5-$i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                        Your Review
                    </label>
                    <textarea 
                        name="comment" 
                        required 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        rows="4"
                        placeholder="Write your review here..."
                    ></textarea>
                </div>
                
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Submit Review
                    </button>
                </div>
            </form>

            <!-- Reviews List -->
            <div class="reviews-list space-y-4">
                <?php foreach($reviews as $review): ?>
                    <div class="review-item bg-white shadow-md rounded p-4" data-review-id="<?php echo $review['id']; ?>">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <div class="font-bold">
                                    <?php echo htmlspecialchars($review['name'] . ' ' . $review['s_name']); ?>
                                </div>
                                <div class="text-yellow-400">
                                    <?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5-$review['rating']); ?>
                                </div>
                            </div>
                            <?php if($review['user_id'] == $_SESSION['id']): ?>
                                <div class="flex space-x-2">
                                    <button onclick="editReview(<?php echo $review['id']; ?>)" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteReview(<?php echo $review['id']; ?>)" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-700"><?php echo htmlspecialchars($review['comment']); ?></p>
                        <div class="text-sm text-gray-500 mt-2">
                            <?php echo date('F j, Y', strtotime($review['created_at'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
?>
