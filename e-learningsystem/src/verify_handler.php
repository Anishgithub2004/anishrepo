<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    try {
        // Fetch user details from the e_learning (admin verification) database
        $sql = "SELECT * FROM users WHERE id = :user_id AND verified = 0";
        $stmt = $admin_conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if the user already exists in the main database
            $check_sql = "SELECT * FROM users WHERE id = :user_id";
            $check_stmt = $main_conn->prepare($check_sql);
            $check_stmt->bindParam(':user_id', $user_id);
            $check_stmt->execute();
            $main_user = $check_stmt->fetch(PDO::FETCH_ASSOC);

            if ($main_user) {
                // User exists, update their details
                $update_sql = "UPDATE users SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, dob = :dob, address = :address, highest_qualification = :highest_qualification, email = :email, phone = :phone, role = :role, verified = 1 WHERE id = :user_id";
                $update_stmt = $main_conn->prepare($update_sql);
                $update_stmt->bindParam(':username', $user['username']);
                $update_stmt->bindParam(':password', $user['password']);
                $update_stmt->bindParam(':first_name', $user['first_name']);
                $update_stmt->bindParam(':last_name', $user['last_name']);
                $update_stmt->bindParam(':dob', $user['dob']);
                $update_stmt->bindParam(':address', $user['address']);
                $update_stmt->bindParam(':highest_qualification', $user['highest_qualification']);
                $update_stmt->bindParam(':email', $user['email']);
                $update_stmt->bindParam(':phone', $user['phone']);
                $update_stmt->bindParam(':role', $user['role']);
                $update_stmt->bindParam(':user_id', $user_id);
                $update_stmt->execute();
            } else {
                // User does not exist, insert their details
                $insert_sql = "INSERT INTO users (id, username, password, first_name, last_name, dob, address, highest_qualification, email, phone, role, verified) 
                               VALUES (:id, :username, :password, :first_name, :last_name, :dob, :address, :highest_qualification, :email, :phone, :role, 1)";
                $insert_stmt = $main_conn->prepare($insert_sql);
                $insert_stmt->bindParam(':id', $user['id']);
                $insert_stmt->bindParam(':username', $user['username']);
                $insert_stmt->bindParam(':password', $user['password']);
                $insert_stmt->bindParam(':first_name', $user['first_name']);
                $insert_stmt->bindParam(':last_name', $user['last_name']);
                $insert_stmt->bindParam(':dob', $user['dob']);
                $insert_stmt->bindParam(':address', $user['address']);
                $insert_stmt->bindParam(':highest_qualification', $user['highest_qualification']);
                $insert_stmt->bindParam(':email', $user['email']);
                $insert_stmt->bindParam(':phone', $user['phone']);
                $insert_stmt->bindParam(':role', $user['role']);
                $insert_stmt->execute();
            }

            // Mark user as verified in the e_learning (admin verification) database
            $verify_sql = "UPDATE users SET verified = 1 WHERE id = :user_id";
            $verify_stmt = $admin_conn->prepare($verify_sql);
            $verify_stmt->bindParam(':user_id', $user_id);
            $verify_stmt->execute();

            echo "User details verified and updated/inserted into main database successfully.";
        } else {
            echo "User not found or already verified.";
        }

        // Redirect to the verification page
        header("Location: ../public/verify.php");
        exit();
    } catch(PDOException $e) {
        echo "Verification failed: " . $e->getMessage();
    }
}
?>
