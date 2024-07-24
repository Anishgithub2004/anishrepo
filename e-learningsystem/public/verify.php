<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Users</title>
    <link rel="stylesheet" href="../styles/verify.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <h2>Verify Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Action</th>
        </tr>
        <?php
        session_start();
        // Fetch unverified users from e_learning schema
        require '../config/config.php';
        $sql = "SELECT * FROM users WHERE verified = 0";
        $stmt = $admin_conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            echo "<tr>
                    <td>" . htmlspecialchars($user['username']) . "</td>
                    <td>
                        <form action='../src/verify_handler.php' method='post'>
                            <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                            <button type='submit'>Verify</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
