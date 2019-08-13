<?php
require_once 'DB.php';


function Redirect_to($New_location){
    header('Location:' . $New_location);
    exit;
    }

function print_r_html($what) {
    echo "<pre style='font-size: 13px !important;'>";
    print_r($what);
    echo "</pre>";
}

function debug($input = null, $die = true)
{

    if (is_array($input) || is_object($input)) {
        print_r_html($input);
    } else {
        echo $input;
    }

    if ($die) {
        die();
    }
}

function checkUsernameExistsOrNot($Username){
    global $connectingDB;
    $sql = "SELECT username FROM admins WHERE username = :username";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':username', $Username);
    $stmt->execute();
    $result = $stmt->rowCount();

    if($result == 1){
        return true;
    }else {
        return false;
    }
}
