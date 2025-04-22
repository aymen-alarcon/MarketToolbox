<?php
    include 'header.php';
    session_start();

    if (isset($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];

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

        $defaultProfileImage = 'https://via.placeholder.com/150?text=Add+Profile+Image';
        $profileImageUrl = $defaultProfileImage;
        $backgroundImageUrl = '';

        foreach ($images as $image) {
            if ($image['image_type'] == 1 && $image['is_deleted'] == 0) {
                $profileImageUrl = $image['image_url'];
            }
            if ($image['image_type'] == 2 && $image['is_deleted'] == 0) {
                $backgroundImageUrl = $image['image_url'];
            }
        }
    } else {
        echo "User not logged in.";
        exit;
    }
?>
<style>
    .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8;
    }

    .btn.btn-warning {
        width: 15rem;
    }

    .my-4.mx-2 {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .background-image {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        margin-top: 1rem;
    }
</style>
<div class="contain rounded bg-white my-5 mx-5" style="box-shadow:0px 0px 15px rgba(0, 0, 0, 0.1);">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center p-3">
                <div class="row">
                    <div class="col-md-6">
                        <img class="rounded-circle mt-5" width="150px" style="height:10rem;" src="<?php echo htmlspecialchars($profileImageUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Image">                        
                        <form action="upload_image.php" method="post" class="m-5" enctype="multipart/form-data">
                            <div class="my-3">
                                <label for="profile-image" class="form-label w-15">Select a new profile image:</label>
                                <input type="file" name="profile-image" id="profile-image" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Profile Picture</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <img class="mt-5" width="150px" style="height:10rem;" src="<?php echo htmlspecialchars($backgroundImageUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Image">                       
                        <form action="upload_image.php" method="post" class="m-5" enctype="multipart/form-data" class="mt-3">
                            <div class="my-3">
                                <label for="background-image" class="form-label w-15">Select a new background image:</label>
                                <input type="file" name="background-image" id="background-image" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Background Image</button>
                        </form>
                    </div>
                </div>
                <hr>
                <form action="picture_delete.php" method="post" class="mt-3 futuristic-form">
                    <p>Select the image you want to delete:</p>
                    <center>
                        <div class="radio-group">
                            <input id="radio-1" type="radio" name="value-radio" value="profile">
                            <label for="radio-1">Profile Picture</label>
                            
                            <input id="radio-2" type="radio" name="value-radio" value="background" checked>
                            <label for="radio-2">Background Picture</label>
                            
                            <input id="radio-3" type="radio" name="value-radio" value="both">
                            <label for="radio-3">Both</label>
                        </div>
                        
                        <button type="submit" class="submit-button">Delete Image(s)</button>
                    </center>
                </form>
                <hr>
            </div>
        </div>
        <div class="col-md-12">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form action="update_user_info.php" method="post">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Name</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Full name" value="<?php echo htmlspecialchars($user['fullname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Username</label>
                            <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Mobile Number</label>
                            <input type="text" class="form-control" placeholder="enter phone number" name="phonenumber" value="<?php echo htmlspecialchars($user['phonenumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Email</label>
                            <input type="email" class="form-control" placeholder="enter email id" name="email" value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Adresse</label>
                            <input type="text" class="form-control" placeholder="Enter Adresse" name="adresse" value="<?php echo htmlspecialchars($user['adresse'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div><br>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                    </div>
                </form>
            </div>
        </div><hr>
        <div class="my-4 mx-2">
            <h3>Change Password</h3>
            <p>If you want to change your password, click the link below:</p>
            <a href="change_password.php" class="btn btn-warning">Change Password</a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>