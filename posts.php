<?php
require_once 'includes/DB.php';
require_once 'includes/functions.php';
require_once 'includes/sessions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet/less" type="text/css" href="css/style.css" />
    <script src="https://kit.fontawesome.com/4966d9d9f9.js"></script>

    <title>Posts</title>
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
                <h1> <i class="fas fa-blog" style="color: rgba(62,81,180,0.7)"> </i> Blog posts</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="addNewPosts.php" class="btn btn-primary btn-block" >
                    <i class="fas fa-edit"></i>Add new post
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Categories.php" class="btn btn-info btn-block" >
                    <i class="fas fa-folder-plus"></i>Add new category
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Admins.php" class="btn btn-warning btn-block" >
                    <i class="fas fa-user-plus"></i>Add new admin
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Comments.php" class="btn btn-success btn-block" >
                    <i class="fas fa-check"></i>Approve comments
                </a>
            </div>



        </div>
    </div>
</header>
<br>

<!--main area-->
<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-dark">

                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date & Time</th>
                    <th>Author</th>
                    <th>Banner</th>
                    <th>Comments</th>
                    <th>Action</th>
                    <th>Live Preview</th>
                </tr>
                </thead>


                <?php
                $sr = 0;

                $sql = "SELECT * FROM posts";
                $stmt = $connectingDB->query($sql);

                while($dataRows = $stmt->fetch()) {
                    $id = $dataRows['id'];
                    $dateTime = $dataRows['datetime'];
                    $PostTitle = $dataRows['title'];
                    $Category = $dataRows['category'];
                    $Admin = $dataRows['author'];
                    $Image = $dataRows['image'];
                    $PostText = $dataRows['post'];
                    $sr++;


                ?>
            <tbody>
                <tr>
                    <td><?php echo $sr;  ?></td>
                    <td><?php echo $PostTitle; ?></td>
                    <td><?php echo $Category; ?></td>
                    <td><?php echo $dateTime; ?></td>
                    <td><?php echo $Admin; ?></td>
                    <td><img src="upload/<?php echo $Image; ?>" width="170px; height=50px;"</td>
                    <td>Comments</td>
                    <td>
                        <a href=""><span class="btn btn-warning">Edit</span></a>
                        <a href=""><span class="btn btn-danger">Delete</span></a>

                    </td>
                    <td>
                        <a href=""><span class="btn btn-primary">Live preview</span></a>
                    </td>

                </tr>
            </tbody>
                <?php } ?>


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