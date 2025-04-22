<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $type = $_POST['type'];

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE username = :username OR email = :email OR phonenumber = :phonenumber");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phonenumber', $phoneNumber);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            $errorMessage = urlencode('Email or phone number already exists.');
            header("Location: sign-up.php?error=true&message=$errorMessage&email=$email&phonenumber=$phoneNumber");
            exit();
        }

        $insertStmt = $pdo->prepare("INSERT INTO users (fullname, username, email, phonenumber, password, gender, type) 
                                    VALUES (:fullname, :username, :email, :phonenumber, :password, :gender, :type)");

        $insertStmt->bindParam(':fullname', $fullName);
        $insertStmt->bindParam(':username', $username);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':phonenumber', $phoneNumber);
        $insertStmt->bindParam(':password', $hashedPassword);
        $insertStmt->bindParam(':gender', $gender);
        $insertStmt->bindParam(':type', $type);

        $insertStmt->execute();

        $userId = $pdo->lastInsertId();

        $_SESSION['UserID'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['type'] = $type;

        $successMessage = urlencode('Registration successful!');
        header("Location: index.php?success=true&message=$successMessage");
        exit();        
    } catch (PDOException $e) {
        $errorMessage = urlencode('Failed to register user. Please try again later.');
        header("Location: sign-up.php?error=true&message=$errorMessage");
        exit();
    }
} else {
    header("Location: sign-up.php");
    exit();
}
?>
