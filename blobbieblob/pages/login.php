<?php
session_start();
$_SESSION["logged_in"] = false;
// call database pull for email to check password and get userID
include ('../data-processing/user-pull.php');

if (isset($_GET['logged_out'])) {
    echo "<script>alert('You have been logged out.');</script>";
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION["permissions"] = $permissions[0]['role_name'];

    // Check if password matches the one in database for the email
    if ($password == $passwordDB) {
        if ($_SESSION["permissions"] == "Admin") {
            // Set the logged-in status in the session
            $_SESSION["logged_in"] = true;
            $_SESSION["userId"] = $userId;
            header("Location: admin-dashboard.html");
            exit();
        } else if ($_SESSION["permissions"] == "User"){
            // Set the logged-in status in the session
            $_SESSION["logged_in"] = true;
            $_SESSION["userId"] = $userId;
            header("Location: user-dashboard.html");
            exit();
        }
    } else {
        $error_message = "Invalid username or password";
    }
}

?>
<!-- Navbar -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Dashboard</title>
    <!-- Favicon for the tab -->
    <link rel="icon" type="image/x-icon" href="../images/GRC_logo.png">
    <!-- Bootstrap CDN -->
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <!-- Datatables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />
    <!-- Link to connect free icons -->
    <script src="https://kit.fontawesome.com/bf84dcb5c2.js" crossorigin="anonymous"></script>
    <!-- Our personal CSS styles -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Setting dark mode theme before page loads -->
    <script type="text/javascript" src="../scripts/set-theme.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark" role="navigation">
        <!-- Navbar Brand & Toggler -->
        <div class="navbar-header" id="navbar-header">
            <a class="navbar-brand navbar-left px-3" href="https://www.greenriver.edu/" target="_blank"><img
                        alt="Green River College's logo" src="../images/GRC_logo_navbar.png" width="70"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toggler"
                    aria-controls="navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span></button>
        </div>
        <!-- Navbar Items with Links -->
        <div class="collapse navbar-collapse" id="navbar-toggler">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/sign-up.html">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/contact.html">Contact</a>
                </li>
            </ul>
        </div>
        <!-- Dark Mode Toggler -->
        <div id="darkmode-container" class="nav-item text-center px-3" hidden="true">
            <input type="checkbox" id="darkmode-toggle"></input>
            <label id="darkmode-label" for="darkmode-toggle"></label>
        </div>
    </nav>
    <br />
    <br />
    <br />
    <br />

    <h2>Login</h2>

    <?php
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
    ?>

    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>


