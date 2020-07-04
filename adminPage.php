<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if ($_SESSION['username']!=="adminA") {
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link rel="stylesheet" href="style.scss">
</head>

<body>

    <div id="nav">
        <h2>Admin Page</h2>
        <div class="textIndex">
            <!-- logged in user information -->
            <?php if (isset($_SESSION['username'])) : ?>
                <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
                <div>
                    <p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="homecontent">
        <h1>Welcome to admin</h1>


    </div>

</body>

</html>