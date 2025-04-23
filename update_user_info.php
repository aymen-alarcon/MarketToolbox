<?php
    session_start();
    include 'db.php';

    if (isset($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];
        
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phonenumber'];
        $adresse = $_POST['adresse'];

        $sql = "UPDATE users SET fullname = :fullname, username = :username, email = :email, phonenumber = :phonenumber, adresse = :adresse WHERE UserID = :UserID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':phonenumber', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_INT);
        $stmt->bindValue(':adresse', $adresse, PDO::PARAM_INT);
        $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "User information updated successfully.";
            header("Location: settings.php");
            exit();
        }
    } else {
        echo "Invalid request.";
    }
?>