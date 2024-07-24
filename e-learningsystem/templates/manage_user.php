<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../config/config.php';

// Fetch users and their registered courses for the mentor
$mentor_id = $_SESSION['user_id'];
$sql = "SELECT users.id AS user_id, users.username, courses.id AS course_id, courses.name AS course_name, courses.description AS course_description 
        FROM users 
        INNER JOIN user_courses ON users.id = user_courses.user_id 
        INNER JOIN courses ON user_courses.course_id = courses.id 
        WHERE courses.mentor_id = :mentor_id";
$stmt = $main_conn->prepare($sql);
$stmt->bindParam(':mentor_id', $mentor_id);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle delete user functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Perform deletion operation
    $delete_sql = "DELETE FROM users WHERE id = :user_id";
    $delete_stmt = $main_conn->prepare($delete_sql);
    $delete_stmt->bindParam(':user_id', $user_id);
    
    try {
        $delete_stmt->execute();
        // Optionally, you can also delete user_courses entries for the deleted user
        // $delete_user_courses_sql = "DELETE FROM user_courses WHERE user_id = :user_id";
        // $delete_user_courses_stmt = $main_conn->prepare($delete_user_courses_sql);
        // $delete_user_courses_stmt->bindParam(':user_id', $user_id);
        // $delete_user_courses_stmt->execute();

        // Redirect or refresh the page after deletion
        header('Location: manage_users.php'); // Replace with your actual manage users page URL
        exit();
    } catch (PDOException $e) {
        echo "Error deleting user: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User and Display Registered Courses</title>
    <style>
        /* Inline CSS styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .registered-courses {
            margin-top: 20px;
        }

        .user-course {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .user-course h3 {
            margin-bottom: 10px;
            color: #007bff;
        }

        .courses-list {
            margin-left: 20px;
        }

        .courses-list ul {
            list-style-type: none;
            padding-left: 0;
        }

        .courses-list ul li {
            margin-bottom: 10px;
        }

        .courses-list ul li strong {
            font-weight: bold;
            margin-right: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            select {
                padding: 8px;
            }

            button {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
<form action="" method="post">
    <label for="user_id">Select User:</label>
    <select id="user_id" name="user_id">
        <?php foreach ($users as $user): ?>
            <option value="<?php echo htmlspecialchars($user['user_id']); ?>"><?php echo htmlspecialchars($user['username']); ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Display user's registered courses -->
    <div class="registered-courses">
        <?php foreach ($users as $user): ?>
            <div class="user-course">
                <h3>User: <?php echo htmlspecialchars($user['username']); ?></h3>
                <div class="courses-list">
                    <p><strong>Registered Courses:</strong></p>
                    <ul>
                        <li>
                            <strong>Course Name:</strong> <?php echo htmlspecialchars($user['course_name']); ?><br>
                            <strong>Description:</strong> <?php echo htmlspecialchars($user['course_description']); ?>
                        </li>
                    </ul>
                </div>
                <!-- Delete button for each user -->
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <button type="submit" name="delete_user">Delete User</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</form>

<?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
