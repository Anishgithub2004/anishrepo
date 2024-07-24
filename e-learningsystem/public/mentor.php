<?php
session_start();
require '../config/config.php';

// Check if the logged-in user is a mentor
if ($_SESSION['role'] != 'mentor') {
    echo "You do not have permission to access this page.";
    exit();
}

// Fetch mentor's name from the database
$mentor_id = $_SESSION['user_id']; // Assuming 'user_id' is the session variable for the logged-in user's ID

// Prepare and execute SQL query to get mentor's name
$sql = "SELECT username FROM users WHERE id = :mentor_id AND role = 'mentor'";
$stmt = $main_conn->prepare($sql);
$stmt->bindParam(':mentor_id', $mentor_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "Mentor not found."; // Handle case where mentor is not found (though it should exist if role check passed)
    exit();
}

$mentor_name = htmlspecialchars($result['username']); // Mentor's name fetched from database

include '../templates/header.php'; // Include header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <link rel="stylesheet" href="../styles/mentor.css"> <!-- Add your CSS file -->
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

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementsByClassName("tablink")[0].click();
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Mentor Dashboard - <?php echo $mentor_name; ?></h2>
        <div class="tabs">
            <button class="tablink" onclick="openTab(event, 'AddCourse')">Add New Course</button>
            <button class="tablink" onclick="openTab(event, 'EditCourse')">Edit Existing Courses</button>
            <button class="tablink" onclick="openTab(event, 'DeleteUser')">Manage Users</button>
            <button class="tablink" onclick="openTab(event, 'ManageMockTests')">Manage Mock Tests</button>
        </div>

        <div id="AddCourse" class="tabcontent">
            <?php include '../templates/add_course.php'; ?>
        </div>

        <div id="EditCourse" class="tabcontent">
            <?php include '../templates/edit_course.php'; ?>
        </div>

        <div id="DeleteUser" class="tabcontent">
            <?php include '../templates/manage_user.php'; ?>
        </div>

        <div id="ManageMockTests" class="tabcontent">
            <h3>Manage Mock Tests</h3>

            <!-- Add New Mock Test Form -->
            <div class="add-mock-test">
                <h4>Add New Mock Test</h4>
                <form action="../src/add_mock_test.php" method="post">
                    <div class="form-group">
                        <label for="course_id">Course:</label>
                        <select id="course_id" name="course_id" required>
                            <!-- Populate this select with courses assigned to the mentor -->
                            <?php
                            // Fetch courses from database and populate options
                            $sql = "SELECT id, `name` FROM courses WHERE mentor_id = :mentor_id";
                            $stmt = $main_conn->prepare($sql);
                            $stmt->bindParam(':mentor_id', $mentor_id);
                            $stmt->execute();
                            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($courses as $course) {
                                echo "<option value=\"" . htmlspecialchars($course['id']) . "\">" . htmlspecialchars($course['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="datetime-local" id="date" name="date" required>
                    </div>
                    <button type="submit" class="action-button">Add Mock Test</button>
                </form>
            </div>

            <!-- Add Questions to Mock Test -->
            <div class="add-questions">
                <h4>Add Questions</h4>
                <form action="../src/add_question.php" method="post">
                    <div class="form-group">
                        <label for="test_id">Mock Test:</label>
                        <select id="test_id" name="test_id" required>
                            <!-- Populate this select with mock tests -->
                            <?php
                            // Fetch mock tests from database and populate options
                            $sql = "SELECT id FROM mock_tests WHERE mentor_id = :mentor_id";
                            $stmt = $main_conn->prepare($sql);
                            $stmt->bindParam(':mentor_id', $mentor_id);
                            $stmt->execute();
                            $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($tests as $test) {
                                echo "<option value=\"" . htmlspecialchars($test['id']) . "\">Test ID: " . htmlspecialchars($test['id']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="question">Question:</label>
                        <textarea id="question" name="question" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="option_a">Option A:</label>
                        <input type="text" id="option_a" name="option_a" required>
                    </div>
                    <div class="form-group">
                        <label for="option_b">Option B:</label>
                        <input type="text" id="option_b" name="option_b" required>
                    </div>
                    <div class="form-group">
                        <label for="option_c">Option C:</label>
                        <input type="text" id="option_c" name="option_c" required>
                    </div>
                    <div class="form-group">
                        <label for="option_d">Option D:</label>
                        <input type="text" id="option_d" name="option_d" required>
                    </div>
                    <div class="form-group">
                        <label for="correct_option">Correct Option:</label>
                        <select id="correct_option" name="correct_option" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <button type="submit" class="action-button">Add Question</button>
                </form>
            </div>

            <!-- View Test Results -->
            <div class="view-results">
                <h4>View Test Results</h4>
                <form action="../src/view_test_results.php" method="get">
                    <div class="form-group">
                        <label for="test_id">Mock Test:</label>
                        <select id="test_id" name="test_id" required>
                            <!-- Populate this select with mock tests -->
                            <?php
                            // Fetch mock tests from database and populate options
                            $sql = "SELECT id FROM mock_tests WHERE mentor_id = :mentor_id";
                            $stmt = $main_conn->prepare($sql);
                            $stmt->bindParam(':mentor_id', $mentor_id);
                            $stmt->execute();
                            $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($tests as $test) {
                                echo "<option value=\"" . htmlspecialchars($test['id']) . "\">Test ID: " . htmlspecialchars($test['id']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="action-button">View Results</button>
                </form>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
