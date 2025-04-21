<?php
    include 'header.php';

    if (isset($_GET['ProductID'])) {
        $productID = intval($_GET['ProductID']);

        $stmt = $pdo->prepare("
            SELECT products.*, rooms.room_name_en
            FROM products 
            JOIN rooms ON products.room = rooms.room_id 
            WHERE products.ProductID = :productID
        ");
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $name = htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8');
                $price = number_format($product['price'], 2);
                $height = htmlspecialchars($product['height'], ENT_QUOTES, 'UTF-8');
                $width = htmlspecialchars($product['width'], ENT_QUOTES, 'UTF-8');
                $material = htmlspecialchars($product['material'], ENT_QUOTES, 'UTF-8');
                $roomName = htmlspecialchars($product['room_name_en'], ENT_QUOTES, 'UTF-8');
                $colors = $product['colors_images'];
                $userID = $product['UserID'];

                $userStmt = $pdo->prepare("
                    SELECT username
                    FROM users 
                    WHERE UserID = :userID
                ");

                $pfp = $pdo->prepare("SELECT image_url FROM profile_pictures WHERE UserID = :userID AND image_type = 1 AND is_deleted = 0");
                $pfp->execute(['userID' => $userID]);
                $profilePicture = $pfp->fetchColumn();

                if (!$profilePicture) {
                    $profilePicture = 'path/to/default/profile/image.jpg';
                }

                $ratinguser = $pdo->prepare("SELECT AVG(Rating) AS average_rating FROM user_ratings WHERE UserID = :userID");
                $ratinguser->execute(['userID' => $userID]);
                $averageRating = $ratinguser->fetchColumn();

                if (!$averageRating) {
                    $averageRating = 'No ratings yet';
                } else {
                    $averageRating = number_format($averageRating, 1);
                }

                $userStmt = $pdo->prepare("SELECT username FROM users WHERE UserID = :userID");
                $userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $userStmt->execute();
                $user = $userStmt->fetch(PDO::FETCH_ASSOC);

                $username = htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');
                $profileImage = htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8');

                $loggedInUserID = $_SESSION['UserID'];
                $ratingStmt = $pdo->prepare("
                    SELECT rating, review_text 
                    FROM ratings_reviews 
                    WHERE ProductID = :productID AND UserID = :userID
                ");
                $ratingStmt->bindParam(':productID', $productID, PDO::PARAM_INT);
                $ratingStmt->bindParam(':userID', $loggedInUserID, PDO::PARAM_INT);

                if ($ratingStmt->execute()) {
                    $userRating = $ratingStmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $userRating = null;
                }
            } else {
                echo "No product found with ProductID: " . $productID;
                exit();
            }
        } else {
            echo "Error in SQL query.";
            exit();
        }
    } else {
        echo "ProductID not set.";
        exit();
    }

    $existingReviewText = '';
    $query = $pdo->prepare("SELECT rating, review_text FROM ratings_reviews WHERE ProductID = :productID AND UserID = :userID");
    $query->execute(['productID' => $productID, 'userID' => $loggedInUserID]);
    $review = $query->fetch(PDO::FETCH_ASSOC);

    $existingRating = $review ? $review['rating'] : 0;
    $existingReview = $review ? $review['review_text'] : '';
?>
<div class="body">
    <div class="containe">

        <div class="imgBx">
            <div class="row">
                <div class="col-md-2">
                    <span class="room-name"><?php echo htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>

                <div class="col-md-10 user-info">
                    <a href="profile_user.php?UserID=<?php echo $userID; ?>">
                        <img src="<?php echo $profileImage; ?>" alt="<?php echo $username; ?>'s profile picture" class="user-profile-picture" />
                    </a>
                    <div class="user-details">
                        <p><?php echo $username; ?></p>
                        <p>Rating: <?php echo $userRating; ?> ⭐</p>
                    </div>
                </div>
            </div>

            <img id="product-image" src="" alt="<?php echo $name; ?>" style="width: 90%; opacity: 1; transition: opacity 0.5s; margin-top: 3rem; margin-left: 3rem;">
        </div>
        <div class="details">
            <div class="content w-100 h-100">
                <h2><?php echo $name; ?><br>
                    <span><?php echo ucfirst($material); ?> Collection</span>
                </h2>
                <p>
                    Height: <?php echo $height; ?> cm<br>
                    Width: <?php echo $width; ?> cm<br>
                    Room Type: <?php echo $roomName; ?>
                </p>
                <p class="product-colors">Available Colors:
                    <?php
                    $colorsArray = json_decode($colors, true);
                    if (is_array($colorsArray)) {
                        foreach ($colorsArray as $colorItem) {
                            $color = htmlspecialchars($colorItem['color'], ENT_QUOTES, 'UTF-8');
                            $colorImage = htmlspecialchars($colorItem['image'], ENT_QUOTES, 'UTF-8');
                            echo "<span style='background-color: $color;' "
                                . "data-color-sec='$color' "
                                . "data-color-primary='$color' "
                                . "data-pic='$colorImage'></span>";
                        }
                    }
                    ?>
                </p>
                <div class="d-flex align-items-center justify-content-between">
                    <h3><?php echo $price; ?> DH</h3>
                    <button>Buy Now</button>
                </div>
                <div class="rating-system">
                    <form method="POST" action="submit_rating.php">
                        <div class="rating my-4">
                            <input type="hidden" name="ProductID" value="<?php echo $productID; ?>"/>
                            <input type="radio" id="star5" name="rate" value="5" <?php echo ($existingRating == 5) ? 'checked' : ''; ?>  />
                            <label title="Excellent!" for="star5">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input value="4" name="rate" id="star4" type="radio"  <?php echo ($existingRating == 4) ? 'checked' : ''; ?> />
                            <label title="Great!" for="star4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input value="3" name="rate" id="star3" type="radio"  <?php echo ($existingRating == 3) ? 'checked' : ''; ?> />
                            <label title="Good" for="star3">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input value="2" name="rate" id="star2" type="radio"  <?php echo ($existingRating == 2) ? 'checked' : ''; ?> />
                            <label title="Okay" for="star2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input value="1" name="rate" id="star1" type="radio"  <?php echo ($existingRating == 1) ? 'checked' : ''; ?> />
                            <label title="Bad" for="star1">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                        </div>

                        <div id="review-modal" class="modal">
                            <div class="modal-content">
                                <span class="close-button">&times;</span>
                                <h2>Submit Your Review</h2>
                                <textarea name="review" id="review-text" rows="4" placeholder="Write your review here..."><?php echo htmlspecialchars($existingReview, ENT_QUOTES, 'UTF-8'); ?></textarea>
                                <button id="submit-review">Submit Rating</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .product-details {
        margin: 20px;
    }

    .user-info {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .user-profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-details {
        display: flex;
        align-items: center;
        margin-right: 15px;
        flex-direction: column;
        margin-top: 1rem;
    }

    .modal {
        display: none;
        position: fixed; 
        justify-content: center;
        align-items: center;
        z-index: 1000; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        display: flex;
        justify-content: center;
        padding: 20px;
        height: 50%;
        width: 30%;
    }

    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-button:hover,
    .close-button:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<script>
    document.querySelectorAll('.rating input').forEach((star) => {
        star.addEventListener('click', function () {
            const ratingValue = this.value;
            const reviewModal = document.getElementById('review-modal');
            reviewModal.style.display = 'flex';

            document.getElementById('submit-review').onclick = function () {
                const reviewText = document.getElementById('review-text').value;

                console.log(`Rating: ${ratingValue}, Review: ${reviewText}`);

                reviewModal.style.display = 'none';
            };
        });
    });

    document.querySelector('.close-button').onclick = function () {
        document.getElementById('review-modal').style.display = 'none';
    };

    window.onclick = function (event) {
        const reviewModal = document.getElementById('review-modal');
        if (event.target === reviewModal) {
            reviewModal.style.display = 'none';
        }
    };

    document.getElementById('submit-review').onclick = function () {
    const reviewText = document.getElementById('review-text').value;
    const reviewModal = document.getElementById('review-modal');
    reviewModal.style.display = 'flex';

    const reviewInput = document.createElement('input');
    reviewInput.type = 'hidden';
    reviewInput.name = 'reviewText';
    reviewInput.value = reviewText;

    const form = document.querySelector('form');
    form.appendChild(reviewInput);

    form.submit();
};

    $(document).ready(function() {
        let firstColorSpan = $(".product-colors span").first();
        firstColorSpan.addClass("active");

        let initialImage = firstColorSpan.attr("data-pic");
        $("#product-image").attr('src', initialImage);
        $(".body").css("background", firstColorSpan.attr("data-color-primary"));
        $(".active").css("border-color", firstColorSpan.attr("data-color-sec"));

        $(".product-colors span").click(function() {
            $(".product-colors span").removeClass("active");
            $(this).addClass("active");

            let selectedImage = $(this).attr("data-pic");

            $("#product-image").css("opacity", "0");
            setTimeout(function() {
                $("#product-image").attr('src', selectedImage);
                $("#product-image").css("opacity", "1");
            }, 300);

            $(".body").css("background", $(this).attr("data-color-primary"));
            $(".active").css("border-color", $(this).attr("data-color-sec"));
        });
    });
</script>

<?php include 'footer.php'; ?>