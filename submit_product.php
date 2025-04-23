<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $height = $_POST['height'];
    $width = $_POST['width'];
    $material = $_POST['material'];
    $room = $_POST['room'];
    $UserID = $_POST['UserID'];
    $color_values = $_POST['color_values'];
    $color_images = $_FILES['color_images'];

    $colors_data = [];

    foreach ($color_values as $index => $color) {
        $uploaded_image = '';
        if (isset($color_images['tmp_name'][$index]) && $color_images['tmp_name'][$index] != '') {
            $file_name = basename($color_images['name'][$index]);
            $upload_dir = 'uploads/';
            $file_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($color_images['tmp_name'][$index], $file_path)) {
                $uploaded_image = $file_path;
            }
        }
        $colors_data[] = ['color' => $color, 'image' => $uploaded_image];
    }

    $colors_json = json_encode($colors_data);
    
    $sql = "INSERT INTO products (name, price, height, width, material, room, colors_images, UserID) 
            VALUES (:name, :price, :height, :width, :material, :room, :colors_images, :UserID)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':height', $height);
    $stmt->bindParam(':width', $width);
    $stmt->bindParam(':material', $material);
    $stmt->bindParam(':room', $room);
    $stmt->bindParam(':colors_images', $colors_json);
    $stmt->bindParam(':UserID', $UserID);
    
    if ($stmt->execute()) {
        $successMessage = urlencode('Product posted successfully.');
        header("Location: index.php?success=true&message={$successMessage}");
        exit();
    } else {
        header("Location: index.php?success=0");
        exit();
    }
}
?>