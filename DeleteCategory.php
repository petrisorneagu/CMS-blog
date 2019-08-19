<?php

require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';

if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    global $connectingDB;

    $sql = "DELETE FROM category WHERE id = '$SearchQueryParameter'";
    $execute = $connectingDB->query($sql);

    if($execute){
        $_SESSION['SuccessMessage'] = 'Category deleted successfully.';
        Redirect_to('Categories.php');
    }else{
        $_SESSION['ErrorMessage'] = 'Something went wrong. Try again.';
        Redirect_to('Categories.php');
    }


}

