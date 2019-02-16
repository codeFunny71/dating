<?php

/*
 * Marcus Absher
 * Date: 2-1-19
 * http://mabsher.greenriverdev.com/328/dating/
*/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload
require_once('vendor/autoload.php');
session_start();

$valid = false;
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
        $valid = false;
        $errors =[];
        $f3->set('valid', false);
        if(isset($_POST['submit'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $premium = $_POST['premium'];

            include('model/validation-functions.php');
            validatePersonal();
            $valid = (count($errors) == 0);

            $f3->set('fname', $fname);
            $f3->set('lname', $lname);
            $f3->set('age', $age);
            $f3->set('gender', $gender);
            $f3->set('phone', $phone);

            //copy values to object and then to SESSION
            if (isset($_POST['premium'])){
                $newMem = new PremiumMember($fname, $lname, $age, $gender, $phone);
            }else{
                $newMem = new Member($fname, $lname, $age, $gender, $phone);
            }
            $_SESSION['member'] = $newMem;

//            $_SESSION['fname'] = $fname;
//            $_SESSION['lname'] = $lname;
//            $_SESSION['age'] = $age;
//            $_SESSION['gender'] = $gender;
//            $_SESSION['phone'] = $phone;

            $f3->set('errors', $errors);
            $f3->set('valid', $valid);
            if($f3->get('valid')){
                $f3->reroute('/profile');
                //print_r($_SESSION);
            }

        }
        $template = new Template();
//        if(!$f3-get('valid')){
            echo $template->render('views/personalInfo.html');
//        } else {
//            $_SESSION['fname'] = $fname;
//            $_SESSION['lname'] = $lname;
//            $_SESSION['age'] = $age;
//            $_SESSION['gender'] = $gender;
//            $_SESSION['phone'] = $phone;
//
//            $f3->reroute('/profile');
//        }

    });

$f3->route('GET|POST /profile',
    function($f3) {
        $valid = true;
        $errors =[];
        print_r($_SESSION);
        $f3->set('valid', false);
        if(isset($_POST['submit'])) {
            $email = $_POST['email'];
            $state = $_POST['state'];
            $seek = $_POST['seek'];
            $bio = $_POST['bio'];

//            include('model/validation-functions.php');
//            validateProfile();
//            $valid = (count($errors) == 0);
//
            $f3->set('email', $email);
            $f3->set('state', $state);
            $f3->set('seek', $seek);
            $f3->set('bio', $bio);

            $f3->set('errors', $errors);
            $f3->set('valid', true);

            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;
            $_SESSION['seek'] = $seek;
            $_SESSION['bio'] = $bio;

            $f3->reroute('/interests');
        }
        $template = new Template();
//        print_r($f3->get('states'));
//        if($f3->get('valid')){
//            $_SESSION['email'] = $email;
//            $_SESSION['state'] = $state;
//            $_SESSION['seek'] = $seek;
//            $_SESSION['bio'] = $bio;
//
//            $f3->reroute('/interests');
//        } else {

            echo $template->render('views/profile.html');
//        }
    });

$f3->route('GET|POST /interests',
    function($f3) {
        $valid = false;
        $errors =[];
        $f3->set('valid', false);
        if(isset($_POST['submit'])) {
            $indoors = $_POST['indoors'];
            $outdoors = $_POST['outdoors'];

            include('model/validation-functions.php');
            validateInterests();
            $valid = (count($errors) == 0);

            $f3->set('indoors', $indoors);
            $f3->set('outdoors', $outdoors);

            $f3->set('errors', $errors);
            $f3->set('valid', $valid);
        }
        $template = new Template();
//        print_r($errors);
        if($f3->get('valid')){
            $_SESSION['indoors'] = $indoors;
            $_SESSION['outdoors'] = $outdoors;

          $f3->reroute('/summary');
        } else {

            echo $template->render('views/interests.html');
        }
    });

$f3->route('GET|POST /summary',
    function($f3) {

        $f3->set('fname', $_SESSION['fname']);
        $f3->set('lname', $_SESSION['lname']);
        $f3->set('age', $_SESSION['age']);
        $f3->set('gender', $_SESSION['gender']);
        $f3->set('phone', $_SESSION['phone']);

        $f3->set('email', $_SESSION['email']);
        $f3->set('state', $_SESSION['state']);
        $f3->set('seek', $_SESSION['seek']);
        $f3->set('bio', $_SESSION['bio']);

        $f3->set('indoors', $_SESSION['indoors']);
        $f3->set('outdoors', $_SESSION['outdoors']);


        $template = new Template();
//        print_r($_SESSION);
        echo $template->render('views/summary.html');

    });

//Run fat free
$f3->run();