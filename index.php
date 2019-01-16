<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload
require_once('vendor/autoload.php');

//create an instance of the Base class
$f3 = Base::instance();

//Turn on fat free error reporting
$f3->set('DEBUG', 3);

//Define route
$f3->route('GET /',
    function() {
        echo '<h1>Pet Home</h1>';
        //$view  new View;
        //echo $view->render('views/home.html');
    }
);

//Run fat free
$f3->run();