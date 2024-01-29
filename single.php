<?php
include "path.php";
include SITE_ROOT . "/app/controllers/users.php";
include SITE_ROOT . "/app/controllers/single.php";
?>
<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/5ea2531bac.js" crossorigin="anonymous"></script>

    <!-- Custom Styling -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>My blog</title>
</head>
<body>

<!-- HEADER START -->
<?php include  SITE_ROOT . "/app/include/header.php"; ?>
<!-- HEADER END-->
<!-- кнопка наверх -->
<div class="upward" style="background: url(<?= BASE_URL . "/assets/images/upward.png";?>)" onclick="scrollTopTop()"></div>
<!-- блок main -->
<div class="container">
    <div class="content row">
        <!-- Main content -->
        <div class="main-content col-md-9 col-12">
            <h2><?=$post["title"];?></h2>
            <div class="single_post row">
                <div class="single_img col-12">
                    <img src="<?=BASE_URL . "assets/images/posts/". $post["image"];?>" alt="<?=$post["title"];?>" class="img-thumbnail">
                </div>
                <div class="single_post_text col-12">
                    <div class="post-content">
                    <h3><?=$post["title"];?></h3>
                        <div class="post-text"">
                            <?=$post["content"];?>
                        </div>
                        <div class="information col-12" style="text-align: right;margin-bottom: 50px;">
                            <i><a class="far fa-user"></a> <?=$my_db->get_data("login","users","id",$post["user_id"]);?></i>
                            <i><a class="far fa-calendar"></a> <?=substr($post["created"],0,10);?></i>
                            <i><a class="fa-regular fa-clock"></a> <?=substr($post["created"],10,-3);?></i>
                        </div>
                    </div>

                    <!-- блок с комментариями -->
                    <?php include  SITE_ROOT . "/app/include/comments.php"; ?>
                </div>
            </div>
        </div>

        <!-- sidebar Content -->
        <div class="sidebar col-md-3 col-12">
            <div class="section search">
                <h3>Поиск</h3>
                <form action="search.php" method="get">
                    <input type="text" name="content" class="text-input" placeholder="Ввод...">
                </form>
            </div>

            <div class="section topics">
                <h3>Категории</h3>
                <ul>
                    <?php
                    $topics = $my_db->get_all_table("topics");
                    foreach($topics as $topic): ?>
                        <li>
                            <a href="<?=BASE_URL . "search.php?topic=" . $topic["id"] . "&page=1";?>"><?= $topic["name"];?></a>
                        </li>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- блок main END -->

<!-- footer start -->
<?php include  SITE_ROOT . "/app/include/footer.php"; ?>
<!-- footer end -->

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
<script src="assets/js/upper.js"></script>
</body>
</html>