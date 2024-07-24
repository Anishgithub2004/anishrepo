<form action="../src/edit_course.php" method="post">
    <label for="course_id">Select Course:</label>
    <select id="course_id" name="course_id">
        <?php
        // Fetch courses managed by the mentor
        $mentor_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM courses WHERE mentor_id = :mentor_id";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':mentor_id', $mentor_id);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($courses as $course) {
            echo "<option value='" . htmlspecialchars($course['id']) . "'>" . htmlspecialchars($course['name']) . "</option>";
        }
        ?>
    </select>
    <br><br>

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

    <button type="submit">Edit Course</button>
</form>
