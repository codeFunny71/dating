<?php

/**
 * Marcus Absher
 * Date: 2-1-19
 * http://mabsher.greenriverdev.com/328/dating/
*/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload
require_once('vendor/autoload.php');
require_once 'model/database.php';
session_start();

$valid = false;
//create an instance of the Base class
$f3 = Base::instance();

//Turn on fat free error reporting
$f3->set('DEBUG', 3);

$f3->set('states', array('Washington','Oregon','California','Idaho','Montana','Nevada','Colorado'));

$f3->set('indoors', array('tv','movies','cooking','board games','puzzles','reading','playing cards','video games'));

$f3->set('outdoors', array('hiking','biking','swimming','collecting','walking','climbing'));

$data = new Database();
$dbh = $data->connect();

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

            $f3->set('errors', $errors);
            $f3->set('valid', $valid);
            if($f3->get('valid')){
                $f3->reroute('/profile');
            }

        }
        $template = new Template();

            echo $template->render('views/personalInfo.html');
    });

$f3->route('GET|POST /profile',
    function($f3) {
        $valid = true;
        $errors =[];
        //print_r($_SESSION);
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

            $newMem = $_SESSION['member'];
            $newMem->setEmail($email);
            $newMem->setState($state);
            $newMem->setSeeking($seek);
            $newMem->setBio($bio);

            $_SESSION['member'] = $newMem;

            if (strcmp(get_class($newMem), 'PremiumMember') == 0){
                $f3->reroute('/interests');
            } else {
                $f3->reroute('/summary');
            }
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

            $newMem = $_SESSION['member'];
            $newMem->setInDoorInterests($indoors);
            $newMem->setOutDoorInterests($outdoors);
            $_SESSION['member'] = $newMem;

//            $_SESSION['indoors'] = $indoors;
//            $_SESSION['outdoors'] = $outdoors;

          $f3->reroute('/summary');
        } else {

            echo $template->render('views/interests.html');
        }
    });

$f3->route('GET|POST /summary',
    function($f3) {
        global $data;
        $newMem = $_SESSION['member'];
        $f3->set('fname', $newMem->getFName());
        $f3->set('lname', $newMem->getLName());
        $f3->set('age', $newMem->getAge());
        $f3->set('gender', $newMem->getGender());
        $f3->set('phone', $newMem->getPhone());

        $f3->set('email', $newMem->getEmail());
        $f3->set('state', $newMem->getState());
        $f3->set('seek', $newMem->getSeeking());
        $f3->set('bio', $newMem->getBio());

        if (strcmp(get_class($newMem), 'PremiumMember') == 0) {
            $f3->set('indoors', $newMem->getInDoorInterests());
            $f3->set('outdoors', $newMem->getOutDoorInterests());
            $f3->set('premium', true);
        }

        Database::insertMember($newMem);

        $template = new Template();
//        print_r($_SESSION);
        echo $template->render('views/summary.html');

    });

    //Define route
    $f3->route('GET|POST /admin',
        function($f3) {
            $table = Database::getMembers();
            $f3->set('table', $table);
            $template = new Template();
            echo $template->render('views/admin.html');
        }
    );

//Run fat free
$f3->run();