<?php include 'header.php'; ?>

<?php
$errorMessage = isset($_GET['message']) ? urldecode($_GET['message']) : '';
$errorEmail = isset($_GET['email']) ? $_GET['email'] : '';
$errorPhoneNumber = isset($_GET['phonenumber']) ? $_GET['phonenumber'] : '';
?>

<div class="container-sign-up">
    <div class="title" style='font-size: larger; font-weight: bold;'>Registration</div>
    <div class="login-form">
        <?php if ($errorMessage): ?>
            <div class="error-message" style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        <form id="sign-up-form" action="register-form.php" method="POST">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input name="fullName" type="text" placeholder="Enter your name" required>
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input name="username" type="text" placeholder="Enter your username" required>
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input name="email" type="text" placeholder="Enter your email" required
                           style="<?php echo $errorEmail ? 'border-color: red;' : ''; ?>">
                </div>
                <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input name="phoneNumber" type="text" placeholder="Enter your number" required
                           style="<?php echo $errorPhoneNumber ? 'border-color: red;' : ''; ?>">
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input name="password" type="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input type="password" id="confirm-password" placeholder="Confirm your password" required>
                    <div id="error-message" style="display:none; color: red; margin-top: 5px;">Passwords do not match!</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 gender-details">
                    <span class="profile-title">Gender</span>
                    <div class="radio-group mt-2">
                        <input class="radio-input" name="gender" id="dot-1" type="radio" value="1">
                        <label class="radio-label m-2" for="dot-1">
                            <span class="radio-inner-circle"></span>
                            Male
                        </label>
                        <input class="radio-input" name="gender" id="dot-2" type="radio" value="2">
                        <label class="radio-label m-2" for="dot-2">
                            <span class="radio-inner-circle"></span>
                            Female
                        </label>
                        <input class="radio-input" name="gender" id="dot-3" type="radio" value="3">
                        <label class="radio-label m-2" for="dot-3">
                            <span class="radio-inner-circle"></span>
                            Prefer not to say
                        </label>
                    </div>
                </div>
                <div class="col-md-6 type ">
                    <span class="profile-title">Profile Type</span>
                    <div class="radio-group mt-2">
                        <input class="radio-input" name="type" id="radio1" type="radio" value="1">
                        <label class="radio-label m-2" for="radio1">
                            <span class="radio-inner-circle"></span>
                            Costumer
                        </label>
                        <input class="radio-input" name="type" id="radio2" type="radio" value="2">
                        <label class="radio-label m-2" for="radio2">
                            <span class="radio-inner-circle"></span>
                            Provider
                        </label>
                        <input class="radio-input" name="type" id="radio3" type="radio" value="3">
                        <label class="radio-label m-2" for="radio3">
                            <span class="radio-inner-circle"></span>
                            Admin
                        </label>
                    </div>
                </div>
            </div>
            <div class="btn mt-2">
                <input type="submit" value="Register" style="background-color: transparent;">
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>