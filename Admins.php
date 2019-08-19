<?php

require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];


confirm_Login();

$currentTime = time();
$dateTime = strftime('%B-%d-%Y %H:%M:%S' , $currentTime);

if(isset($_POST['Submit'])){
    $Username = $_POST['Username'];
    $Name = $_POST['Name'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $Admin = $_SESSION['AdminName'];

    if(empty($Username) || empty($Password) || empty($ConfirmPassword)){
        $_SESSION['ErrorMessage'] = 'You must fill all fields';

        Redirect_to('Admins.php');
    } elseif(strlen($Password) < 4 ) {
        $_SESSION['ErrorMessage'] = 'The password must be at least 4 characters';
        Redirect_to('Admins.php');
    }
    elseif($Password !== $ConfirmPassword) {
        $_SESSION['ErrorMessage'] = 'The password and confirmed password should match.';
        Redirect_to('Admins.php');
        }
    elseif(checkUsernameExistsOrNot($Username)) {
        $_SESSION['ErrorMessage'] = 'The username already exists. Try another one.';
        Redirect_to('Admins.php');
    }else{
//        insert new admin into database
//        TODO - secure login & pass hash
        global $connectingDB;   
        $sql = "INSERT INTO admins (datetime, username, password, aname, addedby)";
        $sql .= "VALUES (:datetime, :username, :password, :aname, :adminName)";
        $stmt = $connectingDB->prepare($sql);

        $stmt->bindValue(':datetime', $dateTime);
        $stmt->bindValue(':username', $Username);
        $stmt->bindValue(':password', $Password);
        $stmt->bindValue(':aname', $Name);
        $stmt->bindValue(':adminName', $Admin);

        $execute=$stmt->execute();
//        var_dump($execute);

        if($execute){
            $_SESSION['SuccessMessage'] = "Admin {$Username} was added successfully";
            Redirect_to('Admins.php');
        }else{
            $_SESSION['ErrorMessage'] = 'Something went wrong';
            Redirect_to('Admins.php');
        }

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

    <title>Admin page</title>
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

        <div class="collapse navbar-collapse" id="navbarcollapseCMS">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="Admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                </li>
            </ul>


            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div style="height:10px; background-color: rgba(62,81,180,0.7)"></div>

<!--header-->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1> <i class="fas fa-user" style="color: rgba(62,81,180,0.7)"> </i>Manage Admins</h1>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height: 700px;">

            <?php
            echo  ErrorMessage();
            echo  SuccessMessage();
            ?>

            <form action="Admins.php" method="post">
                <div class="card">
                    <div class="card-header bg-secondary text-light mb-3">
                        <h1>Add new admin</h1>
                    </div>

                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username: </span></label>
                            <input type="text" class="form-control" name="Username" id="username" value="">
                        </div>
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Name: </span></label>
                            <input type="text" class="form-control" name="Name" id="name" value="">
                            <small class="text-mutted">*Optional:</small>
                        </div>
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Password: </span></label>
                            <input type="password" class="form-control" name="Password" id="password" value="">
                        </div>
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Confirm password: </span></label>
                            <input type="password" class="form-control" name="ConfirmPassword" id="ConfirmPassword" value="">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="dashboard.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-arrow-left"></i> Back to dashboard</a>
                            </div>
                            <div class="col-lg-6">
                                <button  type="submit" name="Submit" class="btn btn-success btn-block mb-2`">
                                    <i class="fas fa-check">Publish</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <h2>Existing admins</h2>
            <?php
            echo  ErrorMessage();
            echo  SuccessMessage();
            ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Date&Time of addition</th>
                    <th>Username</th>
                    <th>Admin name</th>
                    <th>Added by</th>
                    <th>Action</th>
                </tr>
                </thead>

                <?php
                global $connectingDB;
                $sql = "SELECT * FROM admins  ORDER BY id DESC";
                $execute = $connectingDB->query($sql);
                $SrNo = 0;

                while($dataRows = $execute->fetch()){
                    $AdminId = $dataRows['id'];
                    $DateTime = $dataRows['datetime'];
                    $AdminUsername = $dataRows['username'];
                    $AdminName = $dataRows['aname'];
                    $AddedBy = $dataRows['addedby'];
                    $SrNo++;

                    ?>

                    <tbody>
                    <tr>
                        <td><?= htmlentities($SrNo);?></td>
                        <td><?= htmlentities($DateTime); ?></td>
                        <td><?= htmlentities($AdminUsername); ?></td>
                        <td><?= htmlentities($AdminName); ?></td>
                        <td><?= htmlentities($AddedBy); ?></td>
                        <td><a href="DeleteAdmin.php?id=<?= $AdminId;?>" class="btn btn-danger">Delete</a></td>

                    </tr>

                    </tbody>
                <?php }  ?>
            </table>


        </div>
    </div>

</section>



<!--footer-->


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