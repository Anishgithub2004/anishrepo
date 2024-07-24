<!-- templates/view_courses.php -->
<div class="container">
    <h2>Available Courses</h2>
    <div class="courses">
        <?php foreach ($courses as $course): ?>
            <div class="course">
                <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                <p><?php echo htmlspecialchars($course['description']); ?></p>
                <form action="../src/register_course.php" method="post">
                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                    <button type="submit">Register</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
