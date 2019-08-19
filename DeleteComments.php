<?php

require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';

if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    global $connectingDB;

    $sql = "DELETE FROM comments WHERE id = '$SearchQueryParameter'";
    $execute = $connectingDB->query($sql);

    if($execute){
        $_SESSION['SuccessMessage'] = 'Comment deleted successfully.';
        Redirect_to('Comments.php');
    }else{
        $_SESSION['ErrorMessage'] = 'Something went wrong. Try again.';
        Redirect_to('Comments.php');
    }


}

