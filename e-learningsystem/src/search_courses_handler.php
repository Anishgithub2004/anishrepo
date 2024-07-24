<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../config/config.php';

if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';

    // Query for matching courses and fetching mentor details
    $course_sql = "SELECT courses.id, courses.name, courses.duration, courses.degree, courses.category, courses.description, 
                          users.first_name AS mentor_first_name, users.last_name AS mentor_last_name 
                   FROM courses 
                   LEFT JOIN users ON courses.mentor_id = users.id
                   WHERE courses.name LIKE :search OR courses.description LIKE :search";
    $course_stmt = $main_conn->prepare($course_sql);
    $course_stmt->bindParam(':search', $search);
    $course_stmt->execute();
    $courses = $course_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query for matching colleges with all specified attributes
    $college_sql = "SELECT id, `name`, `location`, `category`, `rank`, `rating`, `total_seats`, `established_year`, `type`, `contact_no`, `description`
                    FROM colleges 
                    WHERE `name` LIKE :search OR `location` LIKE :search";
    $college_stmt = $main_conn->prepare($college_sql);
    $college_stmt->bindParam(':search', $search);
    $college_stmt->execute();
    $colleges = $college_stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    echo "No search term provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../styles/search_results.css"> <!-- Add your CSS file -->
</head>
<body>
    <?php include '../templates/header.php'; // Include header ?>
    <div class="container">
        <h2>Search Results</h2>
        <?php if (!empty($courses) || !empty($colleges)): ?>
            <?php if (!empty($courses)): ?>
                <h3>Courses</h3>
                <div class="results">
                    <?php foreach ($courses as $course): ?>
                        <div class="result-item">
                            <h4><?php echo htmlspecialchars($course['name']); ?></h4>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($course['description']); ?></p>
                            <p><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration']); ?></p>
                            <p><strong>Degree:</strong> <?php echo htmlspecialchars($course['degree']); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($course['category']); ?></p>
                            <?php if (!empty($course['mentor_first_name']) && !empty($course['mentor_last_name'])): ?>
                                <p><strong>Mentor:</strong> <?php echo htmlspecialchars($course['mentor_first_name'] . ' ' . $course['mentor_last_name']); ?></p>
                            <?php else: ?>
                                <p><strong>Mentor:</strong> Not specified</p>
                            <?php endif; ?>
                            <form action="../src/register_course.php" method="post">
                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                <button type="submit">Register</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($colleges)): ?>
                <h3>Colleges</h3>
                <div class="results">
                    <?php foreach ($colleges as $college): ?>
                        <div class="result-item">
                            <h4><?php echo htmlspecialchars($college['name']); ?></h4>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($college['location']); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($college['category']); ?></p>
                            <p><strong>Rank:</strong> <?php echo htmlspecialchars($college['rank']); ?></p>
                            <p><strong>Rating:</strong> <?php echo htmlspecialchars($college['rating']); ?></p>
                            <p><strong>Total Seats:</strong> <?php echo htmlspecialchars($college['total_seats']); ?></p>
                            <p><strong>Established Year:</strong> <?php echo htmlspecialchars($college['established_year']); ?></p>
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($college['type']); ?></p>
                            <p><strong>Contact No:</strong> <?php echo htmlspecialchars($college['contact_no']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($college['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>No results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</p>
        <?php endif; ?>
    </div>
    <?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
