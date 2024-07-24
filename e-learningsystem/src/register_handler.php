<?php
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender']; // Add this line
    $address = $_POST['address'];
    $highest_qualification = $_POST['highest_qualification'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    
     $phone = substr($phone, 0, 15);
    try {
        // Insert new user into admin verification database
        $sql = "INSERT INTO users (username, password, first_name, last_name, dob, gender, address, highest_qualification, email, phone, role, verified) VALUES (:username, :password, :first_name, :last_name, :dob, :gender, :address, :highest_qualification, :email, :phone, :role, 0)";
        $stmt = $admin_conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':gender', $gender); // Add this line
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':highest_qualification', $highest_qualification);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        echo "Registration successful. Please wait for admin verification.";
    } catch(PDOException $e) {
        echo "Registration failed: " . $e->getMessage();
    }
}
?>
