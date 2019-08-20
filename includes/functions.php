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

function Login_Attempt($Username, $Password){
    global $connectingDB;
    $sql = "SELECT * FROM admins WHERE username = :userName AND password = :passWord LIMIT 1";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName', $Username );
    $stmt->bindValue(':passWord', $Password );
    $stmt->execute();
    $result = $stmt->rowCount();

    if($result == 1){
       return $Found_Account = $stmt->fetch();
    }else{
        return null;

    }
}
//for password protected pages
function confirm_Login(){
    if(isset($_SESSION['UserId'])){
        return true;
    }
    $_SESSION['ErrorMessage'] = 'Login required !';
    Redirect_to('Login.php');
}

function ApproveCommentsAcordingToPost($PostId){
    global $connectingDB;
    $sqlApproved = "SELECT COUNT(*) FROM comments WHERE post_id = '$PostId' AND status = 'ON'";
    $stmtApproved = $connectingDB->query($sqlApproved);
    $totalRowsApproved = $stmtApproved->fetchColumn();
    return $totalRowsApproved;
}

function DisApproveCommentsAcordingToPost($PostId){
    global $connectingDB;
    $sqlDisApproved = "SELECT COUNT(*) FROM comments WHERE post_id = '$PostId' AND status = 'OFF'";
    $stmtDisApproved = $connectingDB->query($sqlDisApproved );
    $totalRowsDisApproved = $stmtDisApproved ->fetchColumn();
    return $totalRowsDisApproved;
}