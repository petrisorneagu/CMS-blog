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

    <title>Blog</title>
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
            global $connectingDB;
            echo  ErrorMessage();
            echo  SuccessMessage();

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

            }  //query when pagination is active ex.: Blog.php?page=2
            elseif(isset($_GET['page'])){
                $page =  $_GET['page'];

                if($page <= 1){
                    $showPostsFrom = 0;
                }else {
                    $showPostsFrom = ($page * 4) - 4;
                }

                $sql = "SELECT * FROM posts ORDER BY id ASC LIMIT {$showPostsFrom},4";
                $stmt = $connectingDB->query($sql);
            }
//            category active in url
            elseif(isset($_GET['category'])){
                $category = $_GET['category'];
                $sql = "SELECT * FROM posts WHERE category = :categoryName ORDER BY id desc ";

                $stmt = $connectingDB->prepare($sql);
                $stmt->bindValue(':categoryName', $category);
                $stmt->execute();
            }
//                default query without search
            else {
                $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0, 4";
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

                        <small class="text-muted">Category: <span class="text-dark"><?= htmlentities($category);?> - </span> Written by <span class="text-dark"><a
                                        href="Profile.php?username=<?= htmlentities($Admin);?>"><?php echo htmlentities($Admin) ;?></a></span> on <?php echo htmlentities($DateTime) ;?></small>
                        <span style="float: right;" class="badge badge-dark text-light">Comments
                            <?php
                            echo  ApproveCommentsAcordingToPost($PostId);
                            ?>
                        </span>
                        <hr>
                        <p class="card-text"> <?php if(strlen($PostDescription) > 150){
                                echo substr($PostDescription, 0, 150) . '...';
                            }?>
                        </p>

                        <a href="FullPost.php?id=<?= $PostId; ?>" style="float: right"><span class="btn btn-info">Read more >> </span></a>
                    </div>
                </div>

            <?php } ?>

            <!--            Pagination-->
            <nav>
                <ul class="pagination pagination-lg">
                    <?php
                    if(isset($page)){
//                          show backward button ..except for the first page
                        if($page>1){
                            ?>

                            <li class="page-item">
                                <a href="Blog.php?page=<?= $page-1;?>" class="page-link">&laquo;</a>
                            </li>

                        <?php } } ?>

                    <?php
                    global $connectingDB;
                    $sql ="SELECT COUNT(*) FROM posts";
                    $stmt = $connectingDB->query($sql);
                    $rowPagination = $stmt->fetch();
                    $totalPosts = array_shift($rowPagination);
                    //                    echo $totalPosts . '<br>';
                    $postPagination = ceil($totalPosts/4);
                    //                                        echo $postPagination;



                    for($i=1; $i <= $postPagination; $i++){

                        if(isset($_GET['page'])) {
                            $page = $_GET['page'];

                            ?>
                            <li class="page-item <?php if($i == $page){echo 'active';}{echo '';} ?>">
                                <a href="Blog.php?page=<?= $i;?>" class="page-link"><?= $i;?></a>
                            </li>

                        <?php } }
                    //                    }  ?>

                    <?php
                    if(isset($page) && !empty($page)){
//                          show forward button ..except for the last page
                        if($page+1 <= $postPagination){

                            ?>

                            <li class="page-item">
                                <a href="Blog.php?page=<?= $page+1;?>" class="page-link">&raquo;</a>
                            </li>

                        <?php } } ?>

                </ul>
            </nav>
        </div>

        <!--        right side area-->
        <div class="col-sm-4" >
            <div class="card mt-4">
                <div class="card-body">
                    <img src="images/join_us.jpg" class="d-block img-fluid" alt="">
                    <div class="text-center">
                        A lot of people forget to properly formulate the purpose of their blog post or article. But if you do not properly define the aim of your text, you could be missing out on valuable opportunities. You shouldn’t write just for the sake of writing but because you have an idea of what you want your audience to know or do. Let’s discuss why defining the purpose of your text is important, plus, some great writing tips!
                    </div>
                </div>

            </div>
            <br>
            <div class="card-header bg-dark text-light">
                <h2 class="lead">Sign Up!</h2>
            </div>
            <div class="card-body">
                <button class="btn btn-success btn-block text-center text-white">Join the forum</button>
                <button class="btn btn-danger btn-block text-center text-white"><a href="Login.php">Login</a></button>
                <div class="input-group mb-3 mt-2">
                    <input type="text" class="form-control" placeholder="Enter your email">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm text-center text-white" type="button" name="button">Subscribe now</button>
                    </div
                </div>
            </div>

            <br>
            <div class="card-header bg-primary text-light">
                <h2 class="lead">Categories</h2>
            </div>

            <div class="card-body">
                <?php
                global $connectingDB;
                $sql = "SELECT * FROM category ORDER BY id DESC";
                $stmt = $connectingDB->query($sql);

                while($dataRows = $stmt->fetch()){
                    $categoryId = $dataRows['id'];
                    $categoryName = $dataRows['title'];
                    ?>
                    <a href="Blog.php?category=<?=$categoryName;?>"><span class="heading"><?= $categoryName;?></span><br></a>

                <?php } ?>

            </div>

            <br>
            <div class="card">
                <div class="card-header bg-info text-light">
                    <h2 class="lead">Recent Posts</h2>
                </div>
                <div class="card-body">

                    <?php
                    global $connectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
                    $stmt = $connectingDB->query($sql);

                    while($dataRows = $stmt->fetch()){
                        $Id = $dataRows['id'];
                        $Title = $dataRows['title'];
                        $DateTime = $dataRows['datetime'];
                        $Image = $dataRows['image'];
                        ?>

                        <div class="media">
                            <img src="upload/<?= htmlentities($Image);?>" class="d-block img-fluid align-self-start local-right-area" alt="">
                            <div class="media-body ml-2">
                                <a href="FullPost.php?id=<?= htmlentities($Id);?>"><h6 class="lead"><?= htmlentities($Title);?></h6></a>
                                <p class="small"><?=htmlentities($DateTime);?></p>
                            </div>

                        </div>
                        <hr>
                    <?php } ?>

                </div>
            </div>
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