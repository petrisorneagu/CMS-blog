<?php
require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';

$SearchQueryParameter = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet/less" type="text/css" href="css/style.css" />
    <script src="https://kit.fontawesome.com/4966d9d9f9.js"></script>

    <title>Blog page</title>
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
                    <a href="Blog.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About us</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#$" class="nav-link">Contact us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Features</a>
                </li>

            </ul>


            <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block" action="Blog.php">
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search" value="">
                        <button class="btn btn-primary" name="SearchButton">Go</button>
                    </div>
                </form>
            </ul>
        </div>
    </div>
</div>
<div style="height:10px; background-color: rgba(62,81,180,0.7)"></div>

<div class="container">
    <div class="row mt-4">
        <div class="col-sm-8">
            <h1>Blog titles</h1>
            <h1 class="lead">Blog titles</h1>

            <?php

            //            sql query when search button active


            if(isset($_GET['SearchButton'])){
                $Search =  $_GET['Search'];

                $sql = "SELECT * FROM posts WHERE
                         datetime LIKE :search OR 
                         title LIKE :search OR
                         category LIKE :search OR
                         post LIKE :search";

                $stmt = $connectingDB->prepare($sql);
                $stmt->bindValue(':search' , '%'.$Search.'%');
                $stmt->execute();
//                debug($stmt);

            }else {
//                default query without search
                $PostIdFromUrl = $_GET['id'];
                if( !isset($PostIdFromUrl )){
                    $_SESSION['ErrorMessage'] = 'Bad request!';
                    Redirect_to('Blog.php');
                }
                $sql = "SELECT * FROM posts WHERE id = '$PostIdFromUrl'";
                $stmt = $connectingDB->query($sql);
            }
            while($dataRows = $stmt->fetch()){
                $PostId = $dataRows['id'];
                $DateTime = $dataRows['datetime'];
                $PostTitle = $dataRows['title'];
                $category = $dataRows['category'];
                $Admin = $dataRows['author'];
                $Image = $dataRows['image'];
                $PostDescription = $dataRows['post'];

                ?>

            <div class="card">
                <img src="upload/<?php echo htmlentities($Image);?>" style="max-height: 450px; " class="img-fluid card-img-top">

                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle);?></h4>

                        <small class="text-muted">Written by <?php echo htmlentities($Admin) ;?> on <?php echo htmlentities($DateTime) ;?></small>
                        <span style="float: right;" class="badge badge-dark text-light">Comments 20</span>
                        <hr>
                        <p class="card-text"> <?php echo htmlentities($PostDescription);  ?>
                        </p>
                </div>
            </div>

            <?php } ?>

            <div class="">
                <form action="FullPost.php?id=<?= $SearchQueryParameter;?>" method="post">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="FieldInfo">Share your thoughts about this post</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                    </div>
                                    <input class="form-control"  type="text" name="CommenterName" placeholder="name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                    </div>
                                    <input class="form-control"  type="email" name="CommenterEmail" placeholder="email">
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="CommenterThoughts" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" name="Submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-sm-4" style="background-color: yellow">

        </div>
    </div>
</div>
<br>

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