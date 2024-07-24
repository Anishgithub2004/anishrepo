<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Fetch user data from main database
        $sql = "SELECT * FROM users WHERE username = :username AND verified = 1";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header("Location: ../public/admin.php");
            } elseif ($user['role'] == 'mentor') {
                header("Location: ../public/mentor.php");
            } else {
                header("Location: ../public/home.php");
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } catch(PDOException $e) {
        echo "Login failed: " . $e->getMessage();
    }
}
?>
