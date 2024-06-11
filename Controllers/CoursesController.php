<?php
require_once '../Models/CoursesModel.php';

class CoursesController {
    public static function addCourse(){


    }

    public static function changeCourseName(){

    }

    public static function deleteCourse(){

    }

    public static function getAllCourses(){
         $result=CoursesModel::getAllCourses();
         if(isset($result['success'])){
            $_SESSION['success'] = 'Courses retrieved successfully.';
            return $result['courses'];
         }
         elseif($result['error']=='No courses found for this user.'){
            header('Location ../index.php');
         }
         elseif(isset($result['error'])){
            $_SESSION['error']=$result['error'];
            header('Location ../index.php');
         }
    }
}