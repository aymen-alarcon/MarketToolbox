<?php
    session_start();
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['UserID'] = $user['UserID'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php?UserID=' . $user['UserID']);
                exit;
            } else {
                $message = urlencode('Invalid email or password.');
                $redirectUrl = 'login.php?error=true&message=' . $message;
                header('Location: ' . $redirectUrl);
                exit;
            }
        } else {
            $message = urlencode('Please enter both email and password.');
            $redirectUrl = 'login.php?error=true&message=' . $message;
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    header('Location: login.php');
    exit;
?>