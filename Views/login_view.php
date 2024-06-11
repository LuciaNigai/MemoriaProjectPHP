<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Login Form</title>
</head>

<body>
    <h2>Login Form</h2>
    <form action="../Controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="login">
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error-message"><?php echo $_SESSION['error']; ?></div>
        <?php endif; ?>
        <br>

        <label for="login/email">Login:</label><br>
        <input type="text" id="login" name="login" value="<?php echo isset($_SESSION['form_data']['login']) ? htmlspecialchars($_SESSION['form_data']['login']) : ''; ?>" required>
        <?php if (isset($_SESSION['error_login'])) : ?>
            <div class="error-message"><?php echo $_SESSION['error_login']; ?></div>
        <?php endif; ?>
        <br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required>
        <?php if (isset($_SESSION['error_password'])) : ?>
            <div class="error-message"><?php echo $_SESSION['error_password']; ?></div>
        <?php endif; ?>
        <br><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>
