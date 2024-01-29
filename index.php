<?php
include "path.php";
include SITE_ROOT . "/app/controllers/users.php";

$pages_cnt = get_pages_cnt($limit_posts,$my_db,["status"=>1]);
$page = get_page($pages_cnt);
$posts = get_posts($limit_posts,$my_db,$page,["status"=>1]);


$id_Top_topics = $my_db->get_data("id","topics","name","Top posts");
$top_posts = $my_db->take_data("*","posts",["topic_id"=>$id_Top_topics,"status"=>1]);
if(count($top_posts)>$limit_top_posts){
    $cnt_top_posts = $limit_top_posts;
}else{
    $cnt_top_posts = count($top_posts);
}
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
<?php include SITE_ROOT . "/app/include/header.php"; ?>
<!-- HEADER END-->
<!-- кнопка наверх -->
<div class="upward" style="background: url(<?= BASE_URL . "/assets/images/upward.png";?>)" onclick="scrollTopTop()"></div>
<!-- блок карусели START-->
<?php if ($cnt_top_posts>0):?>
<div class="container">
    <div class=row">
        <h2 class="slider-title">Топ блогов</h2>
    </div>
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <?php for($tmp_cnt=1;$tmp_cnt < $cnt_top_posts;$tmp_cnt++):?>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?=$tmp_cnt;?>" aria-label="<?="Slide ".($tmp_cnt+1)?>"></button>
            <?php endfor; ?>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="4000">
                <img src="<?=BASE_URL . "assets/images/posts/". $top_posts[0]["image"];?>" alt="<?=$top_posts[0]["title"];?>" class="d-block w-100">
                <div class="carousel-caption-hack carousel-caption d-none d-md-block">
                    <h5><a href="<?=BASE_URL . "single.php?post-id=" . $top_posts[0]["id"];?>"><?=mb_substr($top_posts[0]["title"],0,34,"UTF-8");?><?php if(mb_strlen($top_posts[0]["title"],"UTF-8")>34) echo "..";?></a></h5>
                </div>
            </div>

            <?php for($tmp_cnt=1;$tmp_cnt < $cnt_top_posts;$tmp_cnt++):?>
                <div class="carousel-item" data-bs-interval="4000">
                    <img src="<?=BASE_URL . "assets/images/posts/". $top_posts[$tmp_cnt]["image"];?>" alt="<?=$top_posts[$tmp_cnt]["title"];?>" class="d-block w-100">
                    <div class="carousel-caption-hack carousel-caption d-none d-md-block">
                        <h5><a href="<?=BASE_URL . "single.php?post-id=" . $top_posts[$tmp_cnt]["id"];?>"><?=mb_substr($top_posts[$tmp_cnt]["title"],0,34,"UTF-8");?><?php if(mb_strlen($top_posts[$tmp_cnt]["title"],"UTF-8")>34) echo "..";?></a></h5>
                    </div>
                </div>
            <?php endfor; ?>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php endif;?>
<!-- блок карусели END -->

<!-- блок main -->
<div class="container">
    <div class="content row">
        <!-- Main content -->
        <div class="main-content col-md-9 col-12">
            <h2>Последние публикации</h2>
            <?php  foreach ($posts as $post):?>
            <div class="post row">
                <div class="img col-12 col-md-4">
                    <img src="<?=BASE_URL . "assets/images/posts/". $post["image"];?>" alt="<?=$post["title"];?>" class="img-thumbnail">
                </div>
                <div class="post_text col-12 col-md-8">
                    <h3>
                        <a href="<?=BASE_URL . "single.php?post-id=" . $post["id"];?>"><?=mb_substr($post["title"],0,34,"UTF-8");?><?php if(mb_strlen($post["title"],"UTF-8")>34) echo "..";?></a>
                    </h3>
                    <i><a class="far fa-user"></a> <?=$my_db->get_data("login","users","id",$post["user_id"]);?></i>
                    <i><a class="far fa-calendar"></a> <?=substr($post["created"],0,10);?></i>
                    <i><a class="fa-regular fa-clock"></a> <?=substr($post["created"],10,-3);?></i>
                    <p class="preview-text"><?=mb_substr($post["content"],0,150,"UTF-8");?><?php if(mb_strlen($post["content"],"UTF-8")>150) echo "..";?></p>
                </div>
            </div>
            <?php endforeach;?>
            <!-- pages navigation -->
            <?php include SITE_ROOT . "/app/include/pagination.php";?>
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
                    foreach($topics as $topic)
                    { ?>
                        <li>
                            <a href="<?=BASE_URL . "search.php?topic=" . $topic["id"] . "&page=1";?>"><?= $topic["name"];?></a>
                        </li>
                    <?php } ?>
            </div>
        </div>

    </div>
</div>
<!-- блок main END -->

<!-- footer start -->
<?php include SITE_ROOT . "/app/include/footer.php"; ?>
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