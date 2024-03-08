<?php
session_start();
require_once 'db_connection.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Controleer of de gebruiker "bart" is
$username = $_SESSION['username'];
if ($username !== 'bart') {
    echo "Je hebt geen toestemming om het wachtwoord te wijzigen.";
    exit;
}

// Haal de lijst met bestaande gebruikersnamen op
$stmt = $pdo->prepare("SELECT username FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Als het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $selected_user = $_POST['selected_user'];
    $new_password = $_POST['new_password'];

    // Update het wachtwoord in de database
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->execute([$hashed_password, $selected_user]);

    echo "Wachtwoord gewijzigd voor gebruiker: $selected_user";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form action="change_password.php" method="post">
        <label for="selected_user">Select User:</label>
        <select name="selected_user" id="selected_user" required>
            <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br>
        <button type="submit" name="change_password">Change Password</button>
    </form>
    <br>
    <a href="welcome.php">Back to Welcome</a>
</body>
</html>
