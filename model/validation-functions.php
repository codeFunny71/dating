<?php
/**
 * Created by PhpStorm.
 * User: marcusabsher
 * Date: 2019-01-28
 * Time: 13:09
 */

$error = [];

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
    return (is_numeric($age) && ($age > 18)) ? true : false ;
}

function validPhone($phone){
    $phone = str_replace('-', '', $phone);
    $phone = str_replace('(', '', $phone);
    $phone = str_replace(')', '', $phone);
    $phone = trim($phone);

    if(count($phone) != 10 || !is_numeric($phone))
        return false;
    else
        return true;
}

function validOutdoor($needle, $haystack ){
    return in_array($needle, $haystack) ? true : false;

}

function validIndoor($needle, $haystack){
    return in_array($needle, $haystack) ? true : false;

}
