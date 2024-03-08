<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    
    <h2>welkom <?php echo $username; ?>.</h2>
   <br>
    <?php if ($username === 'bart') : ?>
        <a href="change_password.php">Change Password</a>
    <?php endif; ?> <br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
