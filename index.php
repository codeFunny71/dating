<?php

/*
 * Marcus Absher
 * Date: 1-18-19
 * http://mabsher.greenriverdev.com/328/dating/
*/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload
require_once('vendor/autoload.php');
session_start();
require ('model/validation-functions.php');


//create an instance of the Base class
$f3 = Base::instance();

//Turn on fat free error reporting
$f3->set('DEBUG', 3);

$f3->set('states', array('Washington','Oregon','California','Idaho','Montana','Nevada','Colorado'));

$f3->set('indoors', array('tv','movies','cooking','board games','puzzles','reading','playing cards','video games'));

$f3->set('outdoors', array('hiking','biking','swimming','collecting','walking','climbing'));


//Define route
$f3->route('GET /',
    function() {
        //echo '<h1>My Dating Website</h1>';
        $view = new View;
        echo $view->render('views/home.html');
    }
);

$f3->route('GET|POST /personalInfo',
    function($f3) {
        $f3->set('valid', false);
        if(isset($_POST['submit'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];

            include('model/validation-functions.php');

            $f3->set('fname', $fname);
            $f3->set('lname', $lname);
            $f3->set('age', $age);
            $f3->set('gender', $gender);
            $f3->set('phone', $phone);

            $f3->set('errors', $errors);
            $f3->set('valid', $valid);

        }
        $template = new Template();
        if(!$f3-get('valid')){
            echo $template->render('views/personalInfo.html');
        } else {
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['phone'] = $phone;

            $f3->reroute('/profile');
        }

    });

$f3->route('GET|POST /profile',
    function($f3) {
        //include ('includes/states.php');
        $f3->get('states');
        if(!empty($_POST)){
            $f3->reroute('/interests');
        }


        $template = new Template();
//        echo '<pre>';
//        print_r($_SESSION);
//        print_r($_POST);
//        echo '</pre>';
        echo $template->render('views/profile.html');
    });

$f3->route('GET|POST /interests',
    function($f3) {
//        if(!empty($_POST)){
//            $f3->reroute('/personalInfo');
//        }

        $template = new Template();
//        echo '<pre>';
//        print_r($_SESSION);
//        print_r($_POST);
//        echo '</pre>';
        echo $template->render('views/interests.html');
    });

//Run fat free
$f3->run();