<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Courses and Colleges</title>
    <link rel="stylesheet" href="../styles/search_courses.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <form action="../src/search_courses_handler.php" method="get" class="search-form">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>
