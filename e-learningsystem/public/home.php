<?php
session_start();
require '../config/config.php';

// Fetch user details (assuming user is logged in and details are fetched from session)
$user_id = $_SESSION['user_id']; // Retrieve actual user ID from session

// Fetch user details from main database
$sql = "SELECT * FROM users WHERE id = :user_id AND verified = 1";
$stmt = $main_conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

include '../templates/header.php'; // Include header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../styles/home.css">
    <style>
        /* Additional styles for tabs */
        .tabcontent {
            display: none;
            padding: 20px;
            border-top: none;
        }

        .active {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>User Dashboard</h2>
    <div class="tabs">
        <button class="tablink" onclick="openTab(event, 'MyDetails')">My Details</button>
        <button class="tablink" onclick="openTab(event, 'SearchCourses')">Search Courses/Colleges</button>
        <button class="tablink" onclick="openTab(event, 'ViewCourses')">View Courses</button>
        <button class="tablink" onclick="openTab(event, 'MyCourses')">My Courses</button>
    </div>

    <div id="MyDetails" class="tabcontent">
        <h3>My Details</h3>
        <form action="../src/update_user.php" method="post" class="user-form">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?php echo $user['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo $user['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="highest_qualification">Highest Qualification:</label>
                <input type="text" id="highest_qualification" name="highest_qualification" value="<?php echo htmlspecialchars($user['highest_qualification']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Leave blank if not changing">
            </div>

            <button type="submit" class="update-button">Update Details</button>
        </form>
    </div>

    <div id="SearchCourses" class="tabcontent">
        <?php include '../templates/search_courses.php'; ?>
    </div>

    <div id="ViewCourses" class="tabcontent">
        <?php include '../public/view_courses.php'; ?>
    </div>

    <div id="MyCourses" class="tabcontent">
        <?php include '../public/my_courses.php'; ?>
    </div>
</div>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Open the first tab by default
    document.getElementsByClassName("tablink")[0].click();
</script>

<?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
