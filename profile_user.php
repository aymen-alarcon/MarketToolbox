<?php
    include 'header.php';
    session_start();

    if (isset($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];
        $logged_in_user_id = $_SESSION['UserID'];

        $sql = "SELECT * FROM users WHERE UserID = :UserID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            echo "User not found.";
            exit;
        }

        $sql_images = "SELECT * FROM profile_pictures WHERE UserID = :UserID";
        $stmt_images = $pdo->prepare($sql_images);
        $stmt_images->bindValue(':UserID', $UserID, PDO::PARAM_INT);
        $stmt_images->execute();
        $images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

        $isProfileImageDeleted = true;
        $isBackgroundImageDeleted = true;

        $defaultProfileImage = 'https://via.placeholder.com/80?text=Add+Profile+Image';
        $defaultBackgroundImage = 'https://via.placeholder.com/1000x400?text=Add+Background+Image';

        $profileImageUrl = $defaultProfileImage;
        $backgroundImageUrl = $defaultBackgroundImage;

        foreach ($images as $image) {
            if ($image['image_type'] == 1 && $image['is_deleted'] == 0) {
                $profileImageUrl = $image['image_url'];
                $isProfileImageDeleted = false;
            } elseif ($image['image_type'] == 2 && $image['is_deleted'] == 0) {
                $backgroundImageUrl = $image['image_url'];
                $isBackgroundImageDeleted = false;
            }
        }

        $sql = "SELECT AVG(rating) as average_rating, COUNT(ReviewID) as rating_count FROM ratings_reviews WHERE UserID = :UserID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $rating_data = $stmt->fetch(PDO::FETCH_ASSOC);

        $average_rating = floor($rating_data['average_rating']);
        $rating_count = $rating_data['rating_count'];

        $sql_products = "
            SELECT p.*, 
                COALESCE(FLOOR(AVG(r.rating)), 0) as average_rating, 
                COUNT(r.ReviewID) as rating_count
            FROM products p
            LEFT JOIN ratings_reviews r ON p.ProductID = r.ProductID
            WHERE p.UserID = :UserID
            GROUP BY p.ProductID
            LIMIT 3
        ";
        $stmt_products = $pdo->prepare($sql_products);
        $stmt_products->bindValue(':UserID', $UserID, PDO::PARAM_INT);
        $stmt_products->execute();
        $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "User not logged in.";
        exit;
    }
?>
<div class="position-relative" style="height: 70vh;">
    <div class="position-relative w-100 h-75">
        <img src="<?php echo htmlspecialchars($backgroundImageUrl, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid w-100 h-75" style="object-fit: cover;">
    </div>
    <div class="card mt-5">
        <div class="user text-center">
            <div class="profile">
                <img src="<?php echo htmlspecialchars($profileImageUrl, ENT_QUOTES, 'UTF-8'); ?>" class="rounded-circle" width="80">
            </div>
        </div>
        <div class="mt-5 text-center">
            <h4 class="mb-0"><?php echo htmlspecialchars($user['fullname'], ENT_QUOTES, 'UTF-8'); ?></h4>
            <span class="text-muted d-block mb-2">Los Angeles</span>
            <button class="btn btn-primary btn-sm follow">Follow</button>
            <div class="d-flex justify-content-between align-items-center mt-4 px-4">
                <div class="stats">
                    <h6 class="mb-0">Followers</h6>
                    <span>8,797</span>
                </div>
                <div class="stats">
                    <h6 class="mb-0">Projects</h6>
                    <span>142</span>
                </div>
                <div class="stats">
                    <h6 class="mb-0">Ranks</h6>
                    <span>129</span>
                </div>
            </div>
            <br>
            <div class="text-center">
                <h4>Overall Rating: <?php echo $average_rating; ?> / 10 (<?php echo $rating_count; ?>)</h4>
            </div>
        </div>
    </div>
    <?php if ($logged_in_user_id != $UserID): ?>
    <div class="mt-3 text-center">
        <h5>Submit a Rating</h5>
        <form action="submit_rating.php" method="post">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (0-10):</label>
                <input type="number" id="rating" name="rating" min="0" max="10" step="1" class="form-control w-25 mx-auto" required>
            </div>
            <input type="hidden" name="UserID" value="<?php echo $UserID; ?>">
            <input type="hidden" name="RatedBy" value="<?php echo $logged_in_user_id; ?>">
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
    </div>
    <?php endif; ?>
</div>
<div class="products">
    <div class="row" id="product-list">
        <?php foreach ($products as $product): ?>
        <div class="col-md-4 d-flex justify-content-center product-item">
            <div class="product-container m-2">
                <div class="product-image">
                    <?php 
                        $colorsImages = json_decode($product['colors_images'], true);
                        $firstImage = !empty($colorsImages) ? $colorsImages[0]['image'] : 'path/to/default/image.png'; 
                    ?>
                    <a href="preview_product.php?ProductID=<?php echo $product['ProductID']; ?>">
                        <img src="<?php echo htmlspecialchars($firstImage, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </a>
                </div>
                <div class="product-info text-center p-2">
                    <h6><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                    <p>DH<?php echo number_format($product['price'], 2); ?></p>
                    <span>Rating: <?php echo htmlspecialchars($product['average_rating'], ENT_QUOTES, 'UTF-8'); ?> / 10 (<?php echo htmlspecialchars($product['rating_count'], ENT_QUOTES, 'UTF-8'); ?>)</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center my-4">
        <button id="load-more" class="btn btn-primary"><i class="bi bi-arrow-bar-down"></i> Load More</button>
    </div>
</div>
<script>
    let offset = 3;

    document.getElementById('load-more').addEventListener('click', function () {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'load_more_products.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status === 200) {
                const productList = document.getElementById('product-list');
                productList.innerHTML += this.responseText;
                offset += 3;
            }
        };

        xhr.send('UserID=<?php echo $UserID; ?>&offset=' + offset);
    });

    var myModal = new bootstrap.Modal(document.getElementById('uploadImageModal'));
        myModal.show();
</script>
<?php include 'footer.php'; ?>