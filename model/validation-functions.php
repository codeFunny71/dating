<?php
/**
 * Created by PhpStorm.
 * User: marcusabsher
 * Date: 2019-01-28
 * Time: 13:09
 */


$valid = false;

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validName($nameData){

    // global $f3;

    if (empty($nameData)){
        return false;
    }
    $nameData = test_input($nameData);
    if (!preg_match("/^[a-zA-Z ]*$/",$nameData)) {
        //echo "Only letters and white space allowed";
        return false;
    }
    return true;

}

function validAge($ageData){
    return (is_numeric($ageData) && ($ageData > 18)) ? true : false ;
}

function validPhone($phoneData){
    $phoneData = str_replace('-', '', $phoneData);
    $phoneData = str_replace('(', '', $phoneData);
    $phoneData = str_replace(')', '', $phoneData);
    $phoneData = trim($phoneData);

    if(strlen($phoneData) != 10 || !is_numeric($phoneData))
        return false;
    else
        return true;
}

function validEmail($emailData){
    if(empty($emailData)) return false;
    return true;
}

function validState($stateData){
    global $f3;
    return in_array($stateData, $f3->get('states'));
}

function validBio($bioData){
    if(!empty($bioData)){
        //$bioData = test_input($bioData);
        return true;
    }
    return false;
}

function validIndoor($indoors ){
    global $f3;
    if(empty($indoors))return true;
    $arrayCheck = true;
    foreach ($indoors as $interest){
        if(!in_array($interest, $f3->get('indoors'))){
            $arrayCheck = false;
            return false;
        }
    }
    return $arrayCheck;
}

function validOutdoor($outdoors){
    global $f3;
    if(empty($outdoors))return true;
    $arrayCheck = true;
    foreach ($outdoors as $interest){
        if(!in_array($interest, $f3->get('outdoors'))){
            $arrayCheck = false;
        }
    }
    return $arrayCheck;
}

$errors = [];
$valid = true;

function validatePersonal(){
    if(!validName($fname)){
        $errors['fname'] = "Please enter a valid first name.";
    }

    if(!validName($lname)){
        $errors['lname'] = "Please enter a valid last name.";
    }

    if(!validAge($age)){
        $errors['age'] = "Please enter a valid age";
    }

//if(!validGender($gender)){
//    $errors['gender'] = "Please enter a gender.";
//}

    if(!validPhone($phone)){
        $errors['phone'] = "Please enter a valid phone.";
    }
}

function validateProfile()
{
//    if (!validEmail($email)) {
//        $errors['email'] = "Please enter a valid email.";
//    }
//
//    if (!validState($state)) {
//        $errors['state'] = "Please enter a valid state.";
//    }
//
////if(!validGender($seek)){
////    $errors['seek'] = "Please enter the gender you are seeking.";
////}
//
//    if (!validBio($bio)) {
//        $errors['bio'] = "Please enter valid bio information.";
//    }
}
function validateInterests()
{
    if (!validIndoor($indoors)) {
        $errors['indoors'] = "Please enter at least one interest from the list below.";
        echo ("indoor issues");
    }

    if (!validOutdoor($outdoors)) {
        $errors['outdoors'] = "Please enter at least one interest from the list below.";
    }
}



