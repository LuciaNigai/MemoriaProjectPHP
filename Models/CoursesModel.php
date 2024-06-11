<?php
require_once '../vendor/autoload.php';

class CoursesModel{

    public static function getAllCourses(){
        $conn = DatabaseConnection::getInstance();
        if($conn){
            $stmt = $conn->prepare("SELECT course_name FROM course WHERE user_id = (SELECT user_id FROM users WHERE email=? or login=?)");
            $stmt->bindParam(1, $_SESSION['login'],PDO::PARAM_STR);
            $stmt->bindParam(2, $_SESSION['login'],PDO::PARAM_STR);
            $stmt->execute();
            $courses = $stmt->fetch(pdo::FETCH_ASSOC);
            if($courses){
                return ['success'=>true, 'courses'=>$courses];
            }
            else{
                return ['error'=>'No courses found for this user.'];
            }
        }
        else{
            return ['error'=>'Database connection failed.'];
        }
    }
}