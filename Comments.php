<?php

require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];


confirm_Login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet/less" type="text/css" href="css/style.css" />
    <script src="https://kit.fontawesome.com/4966d9d9f9.js"></script>

    <title>Comments</title>
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
                <h1> <i class="fas fa-comments" style="color: rgba(62,81,180,0.7)"> </i>Manage comments</h1>
            </div>
        </div>
    </div>
</header>


<section class="container py-2 mb-4">
    <div class="row" style="min-height: 30px">
        <div class="col-lg-12" style="min-height: 400px">

            <h2>Un-Approved comments</h2>
            <?php
            echo  ErrorMessage();
            echo  SuccessMessage();
            ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Date&Time</th>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Approve</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
                </thead>

                <?php
                global $connectingDB;
                $sql = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY id DESC";
                $execute = $connectingDB->query($sql);
                $SrNo = 0;

                while($dataRows = $execute->fetch()){
                    $CommentId = $dataRows['id'];
                    $DateTimeOfComment = $dataRows['datetime'];
                    $CommenterName = $dataRows['name'];
                    $CommentContent = $dataRows['comment'];
                    $CommentPostId = $dataRows['post_id'];
                    $SrNo++;

                    ?>

                    <tbody>
                    <tr>
                        <td><?= htmlentities($SrNo);?></td>
                        <td><?= htmlentities($DateTimeOfComment); ?></td>
                        <td><?= htmlentities($CommenterName); ?></td>
                        <td><?= htmlentities($CommentContent); ?></td>
                        <td><a href="ApproveComments.php?id=<?= $CommentId;?>" class="btn btn-success">Approve</a></td>
                        <td><a href="DeleteComments.php?id=<?= $CommentId;?>" class="btn btn-danger">Delete</a></td>
                        <td><a class="btn btn-primary" href="FullPost.php?id=<?= $CommentPostId;?>" target="_blank">Preview</a></td>

                    </tr>

                    </tbody>
                <?php }  ?>
            </table>

            <h2>Approved comments</h2>
            <?php
            echo  ErrorMessage();
            echo  SuccessMessage();
            ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Date&Time</th>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Revert</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
                </thead>

                <?php
                global $connectingDB;
                $sql = "SELECT * FROM comments WHERE status = 'ON' ORDER BY id DESC";
                $execute = $connectingDB->query($sql);
                $SrNo = 0;

                while($dataRows = $execute->fetch()){
                    $CommentId = $dataRows['id'];
                    $DateTimeOfComment = $dataRows['datetime'];
                    $CommenterName = $dataRows['name'];
                    $CommentContent = $dataRows['comment'];
                    $CommentPostId = $dataRows['post_id'];
                    $SrNo++;

                    ?>

                    <tbody>
                    <tr>
                        <td><?= htmlentities($SrNo);?></td>
                        <td><?= htmlentities($DateTimeOfComment); ?></td>
                        <td><?= htmlentities($CommenterName); ?></td>
                        <td><?= htmlentities($CommentContent); ?></td>
                        <td><a href="DisapproveComments.php?id=<?= $CommentId;?>" class="btn btn-warning">Disapprove</a></td>
                        <td><a href="DeleteComments.php?id=<?= $CommentId;?>" class="btn btn-danger">Delete</a></td>
                        <td><a class="btn btn-primary" href="FullPost.php?id=<?= $CommentPostId;?>" target="_blank">Preview</a></td>

                    </tr>

                    </tbody>
                <?php }  ?>
            </table>




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