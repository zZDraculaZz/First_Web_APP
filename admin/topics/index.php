<?php
include "../../path.php";
include SITE_ROOT . "/app/controllers/topics.php";
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
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <title>My blog</title>
</head>
<body>

<!-- HEADER START -->
<?php include SITE_ROOT . "/app/include/header_admin.php"; ?>
<!-- HEADER END-->

<!-- MAIN START-->
<div class="container">
    <div class="row">

        <?php include SITE_ROOT . "/app/include/sidebar_admin.php";?>

        <div class="posts col-10">
            <div class="button row">
                <a href="<?= BASE_URL . "admin/topics/create.php" ?>" class="col-4 btn btn-success">Добавить категорию</a>
                <span class="col-1"></span>
                <a href="<?= BASE_URL . "admin/topics/index.php" ?>" class="col-4 btn btn-warning">Управлять категориями</a>
            </div>

            <div class="row title-table">
                <h2>Управление категориями</h2>
                <div class="id col-1">ID</div>
                <div class="title col-2">Название</div>
                <div class="description col-5">Описание</div>
                <div class="red col-4">Управление</div>
            </div>
            <div class="row all-posts">
                <?php
                $topics = $my_db->get_all_table("topics");
                    foreach($topics as $key => $topic)
                    { ?>
                        <div class="row post">
                            <div class="id col-1"><?php echo $key+1;?></div>
                            <div class="title col-2"><?php echo $topic["name"];?></div>
                            <div class="description col-5"><?=mb_substr($topic["description"],0,55,"UTF-8");?><?php if(mb_strlen($topic["description"],"UTF-8")>55) echo "...";?></div>
                            <div class="red col-2"><a href="edit.php?id=<?=$topic["id"]; ?>">edit</a></div>
                            <div class="del col-2"><a href="index.php?delete-id=<?=$topic["id"]; ?>">delete</a></div>
                        </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- MAIN END-->

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
</body>
</html>

