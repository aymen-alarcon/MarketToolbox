<?php
    ob_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'header.php';

    if (isset($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileImagePath = null;
            $backgroundImagePath = null;

            if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] === UPLOAD_ERR_OK) {
                $profileImage = $_FILES['profile-image'];
                $profileTmpName = $profileImage['tmp_name'];
                $profileName = basename($profileImage['name']);
                $profileTargetDir = 'users/';
                $profileTargetFile = $profileTargetDir . 'profile_' . $profileName;

                if (move_uploaded_file($profileTmpName, $profileTargetFile)) {
                    $profileImagePath = $profileTargetFile;
                } else {
                    echo "Failed to move profile image.";
                }
            }

            if (isset($_FILES['background-image']) && $_FILES['background-image']['error'] === UPLOAD_ERR_OK) {
                $backgroundImage = $_FILES['background-image'];
                $backgroundTmpName = $backgroundImage['tmp_name'];
                $backgroundName = basename($backgroundImage['name']);
                $backgroundTargetDir = 'users/';
                $backgroundTargetFile = $backgroundTargetDir . 'background_' . $backgroundName;

                if (move_uploaded_file($backgroundTmpName, $backgroundTargetFile)) {
                    $backgroundImagePath = $backgroundTargetFile;
                } else {
                    echo "Failed to move background image.";
                }
            }

            try {
                if ($profileImagePath) {
                    $sql = "INSERT INTO profile_pictures (UserID, image_url, image_type, uploaded_at) 
                            VALUES (:UserID, :image_url, 1, NOW()) 
                            ON DUPLICATE KEY UPDATE 
                            image_url = VALUES(image_url), uploaded_at = NOW()";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
                    $stmt->bindValue(':image_url', $profileImagePath, PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        echo "Error executing profile image query: " . implode(", ", $stmt->errorInfo());
                    }
                }

                if ($backgroundImagePath) {
                    $sql = "INSERT INTO profile_pictures (UserID, image_url, image_type, uploaded_at) 
                            VALUES (:UserID, :image_url, 2, NOW()) 
                            ON DUPLICATE KEY UPDATE 
                            image_url = VALUES(image_url), uploaded_at = NOW()";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
                    $stmt->bindValue(':image_url', $backgroundImagePath, PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        echo "Error executing background image query: " . implode(", ", $stmt->errorInfo());
                    }
                }

                header("Location: profile_user.php?UserID=" . urlencode($UserID));
                exit;

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method or missing files.";
        }
    } else {
        echo "User not logged in.";
    }
    ob_end_flush(); 
?>