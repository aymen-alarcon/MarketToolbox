<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['value-radio']) && in_array($_POST['value-radio'], ['profile', 'background', 'both'])) {
        $selectedValue = $_POST['value-radio'];
        $UserID = $_SESSION['UserID'];

        try {
            $pdo->beginTransaction();

            if ($selectedValue === 'profile' || $selectedValue === 'both') {
                $sql = "UPDATE profile_pictures SET is_deleted = 1 WHERE UserID = :UserID AND image_type = 1";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
                $stmt->execute();
            }

            if ($selectedValue === 'background' || $selectedValue === 'both') {
                $sql = "UPDATE profile_pictures SET is_deleted = 1 WHERE UserID = :UserID AND image_type = 2";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':UserID', $UserID, PDO::PARAM_INT);
                $stmt->execute();
            }

            $pdo->commit();
            header("Location: profile_user.php?UserID=" . urlencode($UserID));
            exit;
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid selection.";
    }
} else {
    echo "Invalid request method.";
}
?>
