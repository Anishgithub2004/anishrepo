<?php
// config.php

$mysql_host = 'localhost';
$mysql_dbname_admin = 'e_learning'; // Admin verification schema
$mysql_dbname_main = 'main_e_learning'; // Main e-learning schema
$mysql_username = 'myadmin';
$mysql_password = 'Anish@444';

try {
    // Connection to admin_verification_schema
    $admin_conn = new PDO("mysql:host=$mysql_host;dbname=$mysql_dbname_admin", $mysql_username, $mysql_password);
    $admin_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connection to main_e_learning
    $main_conn = new PDO("mysql:host=$mysql_host;dbname=$mysql_dbname_main", $mysql_username, $mysql_password);
    $main_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
