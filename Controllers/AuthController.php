<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../Models/AuthModel.php';
require 'CoursesController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'register':
            if (
                isset($_POST['first_name'], $_POST['last_name'], $_POST['login'], $_POST['email'], $_POST['password']) &&
                $_POST['first_name'] !== '' &&
                $_POST['last_name'] !== '' &&
                $_POST['login'] !== '' &&
                $_POST['email'] !== '' &&
                $_POST['password'] !== ''
            ) {
                AuthController::register($_POST['first_name'], $_POST['last_name'], $_POST['login'], $_POST['email'], $_POST['password']);
            } else {
                $_SESSION['error'] = "All fields are required";
                $_SESSION['form_data'] = $_POST;
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
        break;
        case 'login':
            if ((isset($_POST['login'])) && isset($_POST['password'])) {
                AuthController::login($_POST['login'], $_POST['password']);
            } else {
                $_SESSION['error'] = "All fields are required";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
        break;
        case 'logout':
            AuthController::logout();
        break;
        default:
            $_SESSION['error'] = 'No action specified';
            header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
}

class AuthController
{
    public static function register(string $first_name, string $last_name, string $login, string $email, string $password)
    {
        // Perform server-side validation
        if (!preg_match('/^[a-zA-Z]+$/', $first_name)) {
            $_SESSION['error'] = "The first name should contain only letters A-Za-z";
            header("Location: ../Views/register_view.php");
        } elseif (!preg_match('/^[a-zA-Z]+$/', $last_name)) {
            $_SESSION['error'] = "The last name should contain only letters A-Za-z";
            header("Location: ../Views/register_view.php");
        } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/', $password)) {
            $_SESSION['error'] = "The password should contain letters, numbers, and at least one special character.";
            header("Location: ../Views/register_view.php");
        } else {
            $result = AuthModel::register($first_name, $last_name, $login, $email, $password);
            if (isset($result['success'])) {
                $_SESSION['success'] = 'Registration successful!';
                $_SESSION['first_name'] = $result['first_name'];
                $_SESSION['last_name'] = $result['last_name'];
                $_SESSION['login'] = $result['login'];
                $_SESSION['email'] = $result['email'];
                header("Location: ../index.php");
                exit;
            } elseif (isset($result['error'])) {
                $_SESSION['error'] = $result['error'];
                header("Location: ../Views/register_view.php");
                exit;
            }
        }
    }
    

    public static function login(string $login, string $password)
    {
        if (isset($_SESSION['email'])) {
            $_SESSION['error'] = 'You are already logged in. If wou wanna use another account, first logout.';
            header("Location: ../index.php");
        }
        $result = AuthModel::login($login, $password);
        if (isset($result['success'])) {
            $_SESSION['success'] = 'Login successful!';
            $_SESSION['first_name'] = $result['first_name'];
            $_SESSION['last_name'] = $result['last_name'];
            $_SESSION['login'] = $result['login'];
            $_SESSION['email'] = $result['email'];
            header("Location: ../index.php");
            exit;
        } elseif (isset($result['error'])) {
            $_SESSION['error'] = $result['error'];
            header("Location: ../Views/login_view.php");
            exit;
        }
    }

    public static function logout()
    {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page or any other page you want after logout
        header("Location: ../index.php");
        exit;
    }
}
