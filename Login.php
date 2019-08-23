<?php
require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';

if(isset($_SESSION['UserId'])){
    Redirect_to('Dashboard.php');
}

if(isset($_POST['Submit'])){
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    if(empty($Username) || empty($Password)){
        $_SESSION['ErrorMessage'] = 'You must fill all fields';
        Redirect_to('Login.php');
    } else {
       $loggedIn =  Login_Attempt($Username, $Password);
       if($loggedIn){
//           save credentials for the user session
           $_SESSION['UserId'] = $loggedIn['id'];
           $_SESSION['UserName'] = $loggedIn['username'];
           $_SESSION['AdminName'] = $loggedIn['aname'];
           $_SESSION['SuccessMessage'] = 'Welcome '.$_SESSION['AdminName'];

           if(isset($_SESSION['TrackingURL'])){
               Redirect_to($_SESSION['TrackingURL']);
           }else{
               Redirect_to('Dashboard.php');
           }

           Redirect_to('Dashboard.php');
       }
        $_SESSION['ErrorMessage'] = 'Incorrect username/password';
        Redirect_to('Login.php');
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet/less" type="text/css" href="css/style.css" />
    <script src="https://kit.fontawesome.com/4966d9d9f9.js"></script>

    <title>Login</title>
</head>
<body>
<!--navbar-->
<div style="height:10px; background-color: rgba(62,81,180,0.7)"></div>
<div class="navbar navbar-expand-lg navbar-dark bg-dark ">

    <div class="container" >
        <a href="#" class="navbar-brand">SARA.COM</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
            <span class="navbar-toggler-icon"></span>
        </button>


    </div>
</div>
<div style="height:10px; background-color: rgba(62,81,180,0.7)"></div>

<!--header-->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
</header>
<br>

<!--main-->

<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-sm-6 offset-sm-3" style="min-height: 720px">
            <br><br>
            <?php
            echo  ErrorMessage();
            echo  SuccessMessage();
            ?>
            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h4>Welcome back !</h4>
                </div>

                <div class="card-body bg-dark">
                    <form action="Login.php" method="post" >
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info">
                                    <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="Username" id="username">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password"><span class="FieldInfo">Password:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info">
                                    <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" name="Password" id="password">
                            </div>
                        </div>
                        <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!--footer-->
<div style="height:10px; background-color: rgba(62,81,180,0.7)"></div>

<footer class="bg-dark text-white">

    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center"> Theme by | Annonimous | <span id="year"></span> &copy; ---- All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<div style="height:10px; background-color: rgba(62,81,180,0.7)"></div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script>
    $('#year').text(new Date().getFullYear());

</script>
</body>
</html>