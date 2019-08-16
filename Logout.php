<?php
require_once 'includes/functions.php';
require_once 'includes/sessions.php';

//destroy session after logout
$_SESSION['UserId'] = null;
$_SESSION['UserName'] = null;
$_SESSION['AdminName'] = null;
session_destroy();
Redirect_to('Login.php');