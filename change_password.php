<?php
ob_start();
include 'header.php';

if (!isset($_SESSION['UserID'])) {
    echo "User not logged in.";
    exit;
}

$UserID = $_SESSION['UserID'];
$error = '';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    if (strlen($newPassword) < 8) {
        $error = "New password must be at least 8 characters long.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        $sql = "SELECT * FROM users WHERE UserID = :UserID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateSql = "UPDATE users SET password = :newPassword WHERE UserID = :UserID";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindValue(':newPassword', $newPasswordHash);
            $updateStmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                $successMessage = 'Password successfully updated!';
                header("Location: index.php?success=true&message=" . urlencode($successMessage));
                exit(); // Ensure no further code is executed
            } else {
                $error = "Failed to update the password. Please try again.";
            }
        } else {
            $error = "Current password is incorrect.";
        }
    }
}
?>

<style>
.page-container {
    margin-top: 6rem !important;
    margin-bottom: 4rem !important;
}

.form-container {
    width: 400px;
    margin: auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.form-group {
    position: relative;
    margin-bottom: 15px;
}

.btn-primary {
    background-color: #0ab3c3;
    border: none;
}

.btn-primary:hover {
    background-color: #089aa8;
}

.error-message {
    color: red;
    font-size: 0.9em;
}

.valid {
    color: green;
}

.invalid {
    color: red;
}

.disabled {
    background-color: grey;
    cursor: not-allowed;
}

.validation-icon {
    font-size: 18px;
    margin-left: 10px;
}

ul {
    padding-left: 0px;
    padding-top: 10px;
}
</style>

<div class="page-container">
    <div class="form-container">
        <h2 class="text-center">Change Password</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <form action="change_password.php" method="post" id="changePasswordForm">
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" class="form-control" id="current-password" name="current-password" required>
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" class="form-control" id="new-password" name="new-password" required>
                <ul class="password-requirements">
                    <li id="length" class="invalid">
                        <i class="validation-icon">&#10008;</i> At least 8 characters
                    </li>
                    <li id="number" class="invalid">
                        <i class="validation-icon">&#10008;</i> Contains a number
                    </li>
                    <li id="letter" class="invalid">
                        <i class="validation-icon">&#10008;</i> Contains a letter
                    </li>
                </ul>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                <p id="match" class="invalid">
                    <i class="validation-icon">&#10008;</i> Passwords match
                </p>
            </div>
            <button type="submit" id="submit-btn" class="btn btn-primary w-100 disabled" disabled>Update Password</button>
        </form>
    </div>
</div>

<script>
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const submitBtn = document.getElementById('submit-btn');

    const lengthCheck = document.getElementById('length');
    const numberCheck = document.getElementById('number');
    const letterCheck = document.getElementById('letter');
    const matchCheck = document.getElementById('match');

    function validatePassword() {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        let isValid = true;

        if (password.length >= 8) {
            lengthCheck.classList.remove('invalid');
            lengthCheck.classList.add('valid');
            lengthCheck.querySelector('.validation-icon').innerHTML = '&#10004;';
        } else {
            lengthCheck.classList.remove('valid');
            lengthCheck.classList.add('invalid');
            lengthCheck.querySelector('.validation-icon').innerHTML = '&#10008;'; 
            isValid = false;
        }

        if (/\d/.test(password)) {
            numberCheck.classList.remove('invalid');
            numberCheck.classList.add('valid');
            numberCheck.querySelector('.validation-icon').innerHTML = '&#10004;';
        } else {
            numberCheck.classList.remove('valid');
            numberCheck.classList.add('invalid');
            numberCheck.querySelector('.validation-icon').innerHTML = '&#10008;'; 
            isValid = false;
        }

        if (/[a-zA-Z]/.test(password)) {
            letterCheck.classList.remove('invalid');
            letterCheck.classList.add('valid');
            letterCheck.querySelector('.validation-icon').innerHTML = '&#10004;';
        } else {
            letterCheck.classList.remove('valid');
            letterCheck.classList.add('invalid');
            letterCheck.querySelector('.validation-icon').innerHTML = '&#10008;'; 
            isValid = false;
        }

        if (password === confirmPassword && confirmPassword.length > 0) {
            matchCheck.classList.remove('invalid');
            matchCheck.classList.add('valid');
            matchCheck.querySelector('.validation-icon').innerHTML = '&#10004;';
        } else {
            matchCheck.classList.remove('valid');
            matchCheck.classList.add('invalid');
            matchCheck.querySelector('.validation-icon').innerHTML = '&#10008;'; 
            isValid = false;
        }

        submitBtn.disabled = !isValid;
        if (isValid) {
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.classList.add('disabled');
        }
    }

    newPasswordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);
</script>
<?php
    ob_end_flush();
    include 'footer.php';
?>
