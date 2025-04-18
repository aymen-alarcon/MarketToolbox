<?php 
    include 'header.php'; 
    session_start();

    $rooms = [
        'kitchen' => 3,
        'bedroom' => 2,
        'livingroom' => 1
    ];

    $products_by_room = [];
    $max_display = 6;

    $sql_all = "
        SELECT p.*, COALESCE(AVG(r.rating), 0) AS average_rating
        FROM products p
        LEFT JOIN ratings_reviews r ON p.ProductID = r.ProductID
        GROUP BY p.ProductID
        ORDER BY average_rating DESC
        LIMIT 6
    ";
    $stmt_all = $pdo->prepare($sql_all);
    $stmt_all->execute();
    $top_products = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rooms as $room_name => $room_id) {
        $sql = "
            SELECT p.*, COALESCE(AVG(r.rating), 0) AS average_rating
            FROM products p
            LEFT JOIN ratings_reviews r ON p.ProductID = r.ProductID
            WHERE p.room = :room_id
            GROUP BY p.ProductID
            ORDER BY average_rating DESC
            LIMIT 6
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();

        $products_by_room[$room_name] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $sql_sellers = "
        SELECT u.UserID, u.username, pp.image_url 
        FROM users u 
        JOIN profile_pictures pp ON u.UserID = pp.UserID 
        WHERE pp.image_type = 1 AND pp.is_deleted = 0 
        LIMIT 3
    ";
    $stmt_sellers = $pdo->prepare($sql_sellers);
    $stmt_sellers->execute();
    $top_sellers = $stmt_sellers->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="hero">
    <div class="hero-content">
        <h1>MARKETOOLBOX</h1>
        <h2>Visualisez, Évaluez, Construisez - Votre Mobilier Simplifié!</h2>
    </div>
    <br>
    <div class="scrolldown">
        <div class="chevrons">
            <div class="chevrondown"></div>
            <div class="chevrondown"></div>
        </div>
    </div>
</section>

<section class="gallery">
    <div class="filter-buttons">
        <button class="filter-button active" data-room="all">All</button>
        <button class="filter-button" data-room="kitchen">Kitchen</button>
        <button class="filter-button" data-room="bedroom">Bedroom</button>
        <button class="filter-button" data-room="livingroom">Living Room</button>
    </div>
    <div id="no-products-message" class="no-products-message"></div>
    <div class="row p-5" id="gallery-container">
        <?php foreach ($top_products as $product): ?>
            <div class="col-md-4 gallery-item all">
                <?php
                    $color_images = json_decode($product['colors_images'], true);
                    $image_url = !empty($color_images[0]['image']) ? $color_images[0]['image'] : 'default-image.jpg';
                ?>
                <img src="<?php echo htmlspecialchars($image_url, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid w-100 h-100" style="object-fit: cover;">
                <div class="overlay">
                    <h3><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <div class="links">
                        <a href="preview_product.php?ProductID=<?php echo $product['ProductID']; ?>"><i class="bi bi-eye-fill"></i></a>
                        <a href="#"><i class="bi bi-telephone-fill"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="blog-section">
    <h2>A look at our Top Sellers</h2>
    <div class="blog-container">
        <?php foreach ($top_sellers as $seller): ?>
            <div class="blog-card">
                <img src="<?php echo htmlspecialchars($seller['image_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture of <?php echo htmlspecialchars($seller['username'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="blog-content">
                    <h3><?php echo htmlspecialchars($seller['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p>Meet one of our top sellers, <?php echo htmlspecialchars($seller['username'], ENT_QUOTES, 'UTF-8'); ?>, known for their outstanding work and highly-rated products.</p>
                    <div class="blog-meta">
                        <span>Top Seller</span>
                        <span>Furniture Expert</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productsByRoom = <?php echo json_encode($products_by_room); ?>;
        const allProducts = <?php echo json_encode($top_products); ?>;

        function updateNoProductsMessage(message) {
            const noProductsMessageElement = document.getElementById('no-products-message');
            noProductsMessageElement.textContent = message;
        }

        function filterSelection(room) {
            const galleryContainer = document.getElementById('gallery-container');
            galleryContainer.innerHTML = ''; 

            let products;
            if (room === 'all') {
                products = allProducts;
            } else {
                products = productsByRoom[room];
            }

            if (products.length === 0) {
                updateNoProductsMessage('No products available for this filter.');
            } else {
                updateNoProductsMessage('');
                products.forEach(product => {
                    const colorImages = JSON.parse(product.colors_images);
                    const imageUrl = colorImages && colorImages[0] && colorImages[0].image ? colorImages[0].image : 'default-image.jpg';

                    const productItem = `
                        <div class="col-md-4 gallery-item ${room}">
                            <img src="${imageUrl}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                            <div class="overlay">
                                <h3>${product.name}</h3>
                                <div class="links">
                                    <a href="preview_product.php?ProductID=${product.ProductID}"><i class="bi bi-eye-fill"></i></a>
                                    <a href="#"><i class="bi bi-telephone-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    `;
                    galleryContainer.innerHTML += productItem;
                });
            }
        }

        const filterButtons = document.querySelectorAll('.filter-button');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                const room = this.getAttribute('data-room');
                filterSelection(room);
            });
        });

        filterSelection('all');
    });
</script>
<?php include 'footer.php'; ?>