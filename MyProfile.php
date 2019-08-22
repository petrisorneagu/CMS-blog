<?php

require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];


confirm_Login();
global $connectingDB;
$AdminId = $_SESSION['UserId'];

//fetch admin name
$sql = "SELECT * FROM admins WHERE id = '$AdminId'";
$stmt = $connectingDB->query($sql);

while($dataRows = $stmt->fetch()){
    $adminName = $dataRows['aname'];
}






$currentTime = time();
$dateTime = strftime('%B-%d-%Y %H:%M:%S' , $currentTime);

if(isset($_POST['Submit'])){
    $postTitle = $_POST['postTitle'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $postText = $_POST['PostDescription'];

    $Admin = $_SESSION['AdminName'];
//    upload image dir
    $target = 'upload/' . basename($_FILES['image']['name']);

    if(empty($postTitle)){
        $_SESSION['ErrorMessage'] = 'Fill in post title';

        Redirect_to('addNewPosts.php');
    } elseif(strlen($postTitle) < 5 ) {
        $_SESSION['ErrorMessage'] = 'Post title must be greater than 5 characters';
        Redirect_to('addNewPosts.php');
    }
    elseif(strlen($postTitle) > 999 ) {
        $_SESSION['ErrorMessage'] = 'Post title should not exceed more than 1000 characters';
        Redirect_to('addNewPosts.php');
    }else{
//        insert data into database
        $sql = "INSERT INTO posts (datetime, title, category, author, image, post)";
        $sql .= "VALUES (:datetime, :postTitle, :category, :admin, :image, :PostDescription)"; //dummy values
        $stmt = $connectingDB->prepare($sql);

        $stmt->bindValue(':datetime', $dateTime);
        $stmt->bindValue(':postTitle', $postTitle);
        $stmt->bindValue(':category', $category);
        $stmt->bindValue(':admin', $Admin);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':PostDescription', $postText);

        $execute=$stmt->execute();
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        if($execute){
            $_SESSION['SuccessMessage'] = 'Post with id: '.$connectingDB->lastInsertId().' was added successfully';
            Redirect_to('addNewPosts.php');
        }else{
            $_SESSION['ErrorMessage'] = 'Something went wrong';
            Redirect_to('addNewPosts.php');
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

    <title>My Profile</title>
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
                <h1> <i class="fas fa-user mr-2" style="color: rgba(62,81,180,0.7)"> </i>My Profile</h1>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">

<!--        Left area-->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3><?=$adminName;?></h3>
                </div>
                <div class="card-body">
                    <img src="images/user.png" class="block img-fluid mb-3" alt="">
                    <div>
                        Between my strong passion and ridiculous commitment to trying new strategies and ideas, my site took off. Eventually I launched a graphic design studio through my blog, and three months later, I was doing it full time.
                    </div>
                </div>
            </div>


        </div>

<!--        Right area-->
        <div class="col-md-9" style="min-height: 700px;">

            <?php
            echo  ErrorMessage();
            echo  SuccessMessage();
            ?>

            <form action="MyProfile.php.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit profile</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="title" placeholder="Your name" value="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Headline" id="title" placeholder="Headline">
                            <small class="text-muted">Add a professional headline </small>
                            <span class="text-danger">Not more than 12 characters</span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="PostDescription" id="bio" cols="30" rows="10" placeholder="Bio"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select image</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <a href="Dashboard.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-arrow-left"></i> Back to dashboard</a>
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