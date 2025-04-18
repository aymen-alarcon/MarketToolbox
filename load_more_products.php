<?php
    include 'db.php';

    if (isset($_POST['UserID']) && isset($_POST['offset'])) {
        $UserID = $_POST['UserID'];
        $offset = $_POST['offset'];

        $sql_products = "
            SELECT p.*, 
                COALESCE(FLOOR(AVG(r.rating)), 0) as average_rating, 
                COUNT(r.ReviewID) as rating_count
            FROM products p
            LEFT JOIN ratings_reviews r ON p.ProductID = r.ProductID
            WHERE p.UserID = :UserID
            GROUP BY p.ProductID
            LIMIT 3 OFFSET :offset
        ";
        $stmt_products = $pdo->prepare($sql_products);
        $stmt_products->bindValue(':UserID', $UserID, PDO::PARAM_INT);
        $stmt_products->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt_products->execute();
        $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($products)) {
            foreach ($products as $product) {
                $colorsImages = json_decode($product['colors_images'], true);
                $firstImage = !empty($colorsImages) ? $colorsImages[0]['image'] : 'path/to/default/image.png'; 
                ?>
                <div class="col-md-4 d-flex justify-content-center product-item">
                    <div class="product-container m-2">
                        <div class="product-image">
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
                <?php
            }
        }
    }
?>