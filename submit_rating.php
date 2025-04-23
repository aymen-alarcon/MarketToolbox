<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['UserID'])) {
        $errorMessage = urlencode('You have to be logged in to review a product.');
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=true&message={$errorMessage}");
        exit;
    }

    if (isset($_POST['rate'], $_POST['ProductID']) && isset($_POST['review'])) {
        $rating = intval($_POST['rate']);
        $productID = intval($_POST['ProductID']);
        $review = trim($_POST['review']);
        $userID = $_SESSION['UserID'];

        $stmt = $pdo->prepare("
            INSERT INTO ratings_reviews (ProductID, UserID, rating, review_text, DateAdded) 
            VALUES (:productID, :userID, :rating, :review, NOW())
            ON DUPLICATE KEY UPDATE 
                rating = VALUES(rating), 
                review_text = VALUES(review_text), 
                DateAdded = NOW()  -- Update the DateAdded to current time on duplicate
        ");

        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $successMessage = urlencode('Rating submitted successfully!');
            header("Location: preview_product.php?ProductID=" . urlencode($productID) . "&success=true&message={$successMessage}");
            exit;
        } else {
            echo "Error submitting rating and review.";
        }
    } else {
        echo "Rating or review text is missing.";
    }
} else {
    echo "Invalid request method.";
}
?>
