<?php
require_once '../vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

class AuthModel
{
    public static function register(string $first_name, string $last_name, string $login, string $email, string $password)
    {
        $conn = DatabaseConnection::getInstance();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($conn) {
            $stmt = $conn->prepare("CALL Register(?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $first_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $last_name, PDO::PARAM_STR);
            $stmt->bindParam(3, $login, PDO::PARAM_STR);
            $stmt->bindParam(4, $email, PDO::PARAM_STR);
            $stmt->bindParam(5, $hashed_password, PDO::PARAM_STR);
            $stmt->execute();

            // Check if a message was returned from the database
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($row['message'])) {
                return ['error' => $row['message']];
            } elseif ($stmt->rowCount() > 0) {
                return ['success' => true, 'first_name'=>$first_name, 'last_name'=>$last_name, 'login'=>$login, 'email'=>$email];
            } else {
                return ['error' => 'An unknown error occurred during registration.'];
            }
        } else {
            return ['error' => 'Database connection failed.'];
        }
    }



    public static function login(string $login, string $password)
    {
        // Get the database connection
        $conn = DatabaseConnection::getInstance();

        if ($conn) {
            $stmt = $conn->prepare("SELECT u_password FROM users WHERE email = ? OR login = ?");
            $stmt->bindParam(1, $login, PDO::PARAM_STR);
            $stmt->bindParam(2, $login, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify the hashed password with the entered password
                if (password_verify($password, $user['u_password'])) {
                    // Password is correct, log in the user
                    $stmt = $conn->prepare("SELECT first_name, last_name, login, email FROM users WHERE email = ? OR login = ?");
                    $stmt->bindParam(1, $login, PDO::PARAM_STR);
                    $stmt->bindParam(2, $login, PDO::PARAM_STR);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    return ['success' => true, 'first_name'=>$user['first_name'], 'last_name'=>$user['last_name'], 'login'=>$user['login'], 'email'=>$user['email']];
                } else {
                    // Password is incorrect
                    return ['error' => 'An unknown error occurred during registration.'];
                }
            } else {
                // User not found
                return ['error' => 'Invalid email or passsword.'];
            }
        } else {
            // Connection failed, handle accordingly
            // For example, redirect to an error page
            return ['error' => 'Database connection failed.'];
        }
    }

    public function createUserSession()
    {
    }

    public function destroyUserSession()
    {
    }

    public function isAuthenticated()
    {
    }
}
