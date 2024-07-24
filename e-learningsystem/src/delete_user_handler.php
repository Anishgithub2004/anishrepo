<form action="../src/delete_user_handler.php" method="post">
    <label for="user_id">Select User:</label>
    <select id="user_id" name="user_id">
        <?php
        // Fetch users registered in courses managed by the mentor
        $mentor_id = $_SESSION['user_id'];
        $sql = "SELECT users.id, users.username FROM users 
                INNER JOIN user_courses ON users.id = user_courses.user_id 
                INNER JOIN courses ON user_courses.course_id = courses.id 
                WHERE courses.mentor_id = :mentor_id";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':mentor_id', $mentor_id);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            echo "<option value='" . htmlspecialchars($user['id']) . "'>" . htmlspecialchars($user['username']) . "</option>";
        }
        ?>
    </select>
    <br><br>

    <button type="submit">Delete User</button>
</form>
