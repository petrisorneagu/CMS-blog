<?php

require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';

confirm_Login();

$currentTime = time();
$dateTime = strftime('%B-%d-%Y %H:%M:%S' , $currentTime);
$SearchQueryParameter = $_GET['id'];

global $connectingDB;
$sql = "SELECT * FROM posts WHERE id = '$SearchQueryParameter'";
$stmt = $connectingDB->query($sql);

while ($dataRows = $stmt->fetch()){
    $TitleToBeDeleted = $dataRows['title'];
    $CategoryToBeDeleted = $dataRows['category'];
    $ImageToBeDeleted = $dataRows['image'];
    $PostToBeDeleted = $dataRows['post'];
}

if(isset($_POST['Submit'])){
//        delete query
    global $connectingDB;

    $sql = "DELETE FROM posts WHERE id = '$SearchQueryParameter'";

    $execute = $connectingDB->query($sql);

    if($execute){
        $target_path_to_delete_image = 'upload/'.$ImageToBeDeleted ;
        unlink($target_path_to_delete_image);

        $_SESSION['SuccessMessage'] = 'Post deleted successfully';
        Redirect_to('Posts.php');
    }else{
        $_SESSION['ErrorMessage'] = 'Something went wrong';
        Redirect_to('Posts.php');
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

    <title>Delete post</title>
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
                <h1> <i class="fas fa-edit" style="color: rgba(62,81,180,0.7)"> </i>Delete post</h1>
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

            <form action="DeletePost.php?id=<?= $SearchQueryParameter;?>" method="post" enctype="multipart/form-data">
                <div class="card">

                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Post title: </span></label>
                            <input disabled type="text" class="form-control" name="postTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeDeleted;?>">
                        </div>
                        <div class="form-group">
                            <span class="FieldInfo">Existing category: </span>
                            <?php echo $CategoryToBeDeleted;?>
                            <br>
                        </div>

                        <div class="form-group">
                            <span class="FieldInfo">Existing image:</span>
                            <img class="mb-1" src="upload/<?php echo $ImageToBeDeleted;?>" width="170px" height="70px">
                        </div>

                        <div class="form-group">
                            <label for="Post"><span class="FieldInfo">Post: </span></label>
                            <textarea disabled class="form-control" name="PostDescription" id="Post" cols="30" rows="10" ><?= $PostToBeDeleted;?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <a href="dashboard.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-arrow-left"></i> Back to dashboard</a>
                            </div>
                            <div class="col-lg-6">
                                <button  type="submit" name="Submit" class="btn btn-danger btn-block mb-2`">
                                    <i class="fas fa-trash">Delete</i>
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