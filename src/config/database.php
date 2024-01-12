<?php
    $dsn = 'mysql:host=' .$settings['database']['host']. ';dbname=' .$settings['database']['name']. ';charset=utf8';
    $username = $settings['database']['username'];
    $password = $settings['database']['password'];
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    

?>