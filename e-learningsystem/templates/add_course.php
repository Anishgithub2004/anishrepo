<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="../styles/add_edit_course.css"> <!-- Corrected CSS file path -->
</head>
<body>
    <div class="container">
        <h2>Add Course</h2>
        <form action="../src/add_course.php" method="post">
            <label for="name">Course Name:</label>
            <input type="text" id="name" name="name" required>
            <br><br>

            <label for="duration">Duration:</label>
            <input type="text" id="duration" name="duration" required>
            <br><br>

            <label for="degree">Degree:</label>
            <select id="degree" name="degree">
                <option value="UG">UG</option>
                <option value="PG">PG</option>
            </select>
            <br><br>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>
            <br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <br><br>

            <button type="submit">Add Course</button>
        </form>
    </div>
    <footer>
        <?php include '../templates/footer.php'; ?>
    </footer>
</body>
</html>
