<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UG Course Mining System</title>
    <style>
        /* Example style for navigation */
        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>UG Course Mining System</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <?php
                // Determine the user role to display appropriate links
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo '<li><a href="admin.php">Admin Dashboard</a></li>';
                } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
                    echo '<li><a href="home.php">User Dashboard</a></li>';
                }
                ?>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
