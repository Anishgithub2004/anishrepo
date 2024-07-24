<?php
require '../config/config.php';

// Function to delete a user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_id = $_POST['delete_user'];
    try {
        // Delete user from main_e_learning schema
        $delete_sql = "DELETE FROM users WHERE id = :id";
        $delete_stmt = $main_conn->prepare($delete_sql);
        $delete_stmt->bindParam(':id', $user_id);
        $delete_stmt->execute();

        echo "User deleted successfully.";
    } catch(PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    }
}

// Fetch unverified users for verification
$sql_verify = "SELECT * FROM e_learning.users WHERE verified = 0";
$stmt_verify = $admin_conn->prepare($sql_verify);
$stmt_verify->execute();
$users_verify = $stmt_verify->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users for listing and deleting
$sql_list = "SELECT * FROM main_e_learning.users";
$stmt_list = $main_conn->prepare($sql_list);
$stmt_list->execute();
$users_list = $stmt_list->fetchAll(PDO::FETCH_ASSOC);

// Fetch all colleges for listing and deleting
$sql_colleges = "SELECT * FROM colleges";
$stmt_colleges = $main_conn->prepare($sql_colleges);
$stmt_colleges->execute();
$colleges = $stmt_colleges->fetchAll(PDO::FETCH_ASSOC);

include '../templates/admin.html';
?>
