<?php
/**
 * Created by PhpStorm.
 * User: marcusabsher
 * Date: 2019-01-28
 * Time: 13:09
 */

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validName($name){

    // global $f3;

    if (empty($name)){
        echo "Enter an animal";
        return false;
    }
    $name = test_input($name);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        echo "Only letters and white space allowed";
        return false;
    }
    return true;

}

function validAge($age){
    if (is_numeric($age) && ($age > 18)){
        return true;
    }
    echo "Must be over 18.";
    return false;
}

function validPhone($phone){
    $phone = str_replace('-', '', $phone);
    $phone = str_replace('(', '', $phone);
    $phone = str_replace(')', '', $phone);
    $phone = trim($phone);

    if(count($phone) != 10 || !is_numeric($phone))
        return "Please enter a valid phone number";
    else
        return $phone;
}

function validOutdoor($outdoor){

}

function validIndoor($indoor){}