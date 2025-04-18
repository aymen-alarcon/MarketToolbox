<?php
    $servername = "localhost";
    $usernamedb = "root";
    $password ="";
    $dbname = "markettoolbox";

    try {
        $pdo = new PDO("mysql:host-$servername; dbname-$dbname", $usernamedb, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo "Connection failed: $e->getMessage()";
    }
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $usernamedb, $password, $options);
    } catch (\PDOException $e) {
        exit;
    }
?>