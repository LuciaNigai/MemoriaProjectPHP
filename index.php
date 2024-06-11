<?php
session_start();
//require 'Controllers/CoursesController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['login'], $_SESSION['email'])) :
        echo '<p>Hello ' . $_SESSION['first_name'] . ', ' . $_SESSION['last_name'] . ', ' . $_SESSION['login'] . ', ' . $_SESSION['email'] . '</p>';
    endif;
    ?>


    <form action="Views/register_view.php" method="GET">
        <input type="submit" value="Register">
    </form>
    <br>
    <form action="Views/login_view.php" method="GET">
        <input type="submit" value="Login">
    </form>
    <br>
    <form action="Controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>

    <?php
    if (isset($_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['login'], $_SESSION['email'])) :
    ?>

        <?php

        ?>

        <!-- Button to open the modal -->
        <button id="openModalBtn" type="submit">Open Form</button>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="addCourseForm" action="Controllers/CoursesController.php" method="POST">
                    <input type="hidden" name="action" value="addCourse">
                    <label for="coursename">Course name:</label>
                    <input type="text" id="coursename" name="coursename" required><br>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>

    <?php endif; ?>


</body>

</html>