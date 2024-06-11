<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables for form data
$first_name = '';
$last_name = '';
$login = '';
$email = '';

// Check if there's any previously submitted form data in session variables
if (isset($_SESSION['form_data'])) {
    // Retrieve previously submitted form data
    $formData = $_SESSION['form_data'];
    $first_name = $formData['first_name'] ?? '';
    $last_name = $formData['last_name'] ?? '';
    $login = $formData['login'] ?? '';
    $email = $formData['email'] ?? '';
    // Remove the form data from session
    unset($_SESSION['form_data']);
}

// Check if there's an error message in the session
if (isset($_SESSION['error'])) {
    // Display error message
    $error_first_name = null;
    $error_last_name = null;
    if ($_SESSION['error'] == "The first name should contain only letters A-Za-z") {
        $error_first_name = $_SESSION['error'];
    }
    if ($_SESSION['error'] == "The last name should contain only letters A-Za-z") {
        $error_last_name = $_SESSION['error'];
    }
    if ($_SESSION['error'] == "The login should contain only letters A-Za-z and numbers 0-9 optionally") {
        $error_login = $_SESSION['error'];
    }
    if ($_SESSION['error'] == "The password should contain letters , numbers and at least one special character") {
        $error_password = $_SESSION['error'];
    }
    else {
        $error_register = $_SESSION['error'];
    }
    // Remove the error message from the session
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Register Form</title>
</head>

<body>
    <h2>Login Form</h2>
    <form action="../Controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="register">
        <?php if (isset($error_register)) : echo "<div class=\"error-message\">" . $error_register . "</div>";
        endif; ?><br>
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
        <?php if (isset($error_first_name)) : echo "<div class=\"error-message\">" . $error_first_name . "</div>";
        endif; ?><br>


        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
        <?php if (isset($error_last_name)) : echo "<div class=\"error-message\">" . $error_last_name . "</div>";
        endif; ?><br>

        <label for="login">Login:</label><br>
        <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($login); ?>" required>
        <?php if (isset($error_login)) : echo "<div class=\"error-message\">" . $error_login . "</div>";
        endif; ?><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required>
        <?php if (isset($error_password)) : echo "<div class=\"error-message\">" . $error_password . "</div>";
        endif; ?><br><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>