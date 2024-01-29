<?php
include "path.php";
include SITE_ROOT . "/app/controllers/users.php";
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
<!-- блок main -->
<div class="container">
    <div class="content row">
        <!-- Main content -->
        <div class="main-content">

            <div class="section full-search col-12 col-md-12">
                <form action="search.php" method="get">
                <div class="row col-12 col-md-12">
                    <div class ="col-6 col-md-3">
                        <label for="content" class="form-label">Поиск по названию</label>
                        <input type="text" value="<?php if(!empty($content)) echo $content;?>" name="content" class="text-input" placeholder="Ввод...">
                    </div>
                    <div class="col-6 col-md-3">
                        <label for="content" class="form-label">Выбор категории</label>
                        <select name="topic" class="form-select topic-search" aria-label="Default select example">
                            <option selected value="<?php if($topic!= "") echo $topic;?>"> <?php if($topic != ""){echo $my_db->get_data("name","topics","id",$topic);}else{echo "Выберите категорию";}?></option>
                            <?php if ($topic != "")
                            {?>
                            <option value="">Выберите категорию</option>
                            <?php }
                            $topics = $my_db->get_all_table("topics");
                            foreach($topics as $key => $one_topic)
                            { ?>
                                <option value="<?=$one_topic["id"];?>"><?=$one_topic["name"];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col md-4">
                    <button name="search-button" class="btn btn-primary search-button" type="submit">Искать</button>
                </div>
                </form>
            </div>

            <h2>Результаты поиска</h2>
            <?php  foreach ($posts as $post):?>
            <div class="post row">
                <div class="img col-12 col-md-4">
                    <img src="<?=BASE_URL . "assets/images/posts/". $post["image"];?>" alt="<?=$post["title"];?>" class="img-thumbnail">
                </div>
                <div class="post_text col-12 col-md-8">
                    <h3>
                        <a href="<?=BASE_URL . "single.php?post-id=" . $post["id"];?>"><?=mb_substr($post["title"],0,70,"UTF-8");?><?php if(mb_strlen($post["title"],"UTF-8")>70) echo "..";?></a>
                    </h3>
                    <i><a class="far fa-user"></a> <?=$my_db->get_data("login","users","id",$post["user_id"]);?></i>
                    <i><a class="far fa-calendar"></a> <?=substr($post["created"],0,10);?></i>
                    <i><a class="fa-regular fa-clock"></a> <?=substr($post["created"],10,-3);?></i>
                    <p class="preview-text"><?=mb_substr($post["content"],0,300,"UTF-8");?><?php if(mb_strlen($post["content"],"UTF-8")>300) echo "..";?></p>
                </div>
            </div>
            <?php endforeach;?>
            <!-- pages navigation -->
            <?php include SITE_ROOT . "/app/include/pagination.php";?>
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