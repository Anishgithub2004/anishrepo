<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender']; // Add this line
    $address = $_POST['address'];
    $highest_qualification = $_POST['highest_qualification'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    try {
        // Prepare SQL statement for admin verification database
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, dob = :dob, gender = :gender, address = :address, highest_qualification = :highest_qualification, email = :email, phone = :phone, verified = 0";
        
        // Only update password if it is provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql .= ", password = :password";
        }
        
        $sql .= " WHERE id = :user_id";

        $stmt = $admin_conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':gender', $gender); // Add this line
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':highest_qualification', $highest_qualification);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        
        
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password);
        }
        
        $stmt->bindParam(':user_id', $user_id);
        
        // Execute statement
        $stmt->execute();
        
        echo "User details updated successfully. Awaiting admin verification.";
        // Redirect to the user dashboard or home page
        header("Location: ../public/home.php");
        exit();
    } catch(PDOException $e) {
        echo "Update failed: " . $e->getMessage();
    }
}
?>
