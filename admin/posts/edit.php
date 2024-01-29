<?php
include "../../path.php";
include SITE_ROOT . "/app/controllers/posts.php";
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

        <?php include ("../../app/include/sidebar_admin.php")?>

        <div class="posts col-10">
            <div class="button row">
                <a href="<?= BASE_URL . "admin/posts/create.php" ?>" class="col-4 btn btn-success">Добавить пост</a>
                <span class="col-1"></span>
                <a href="<?= BASE_URL . "admin/posts/index.php" ?>" class="col-4 btn btn-warning">Управлять постами</a>
            </div>

            <div class="row title-table">
                <h2>Редактирование записи</h2>
            </div>
            <div class="col err">
                <!-- Вывод массива с ошибками -->
                <?php include SITE_ROOT . "/app/helps/error_info.php";?>
            </div>
            <div class="row add-posts">
                <form action="edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$id;?>">
                    <div class="col mb-4">
                        <label for="content" class="form-label">Название статьи</label>
                        <input type="text" value="<?=$title;?>" name="title" class="form-control" placeholder="Введите название статьи" aria-label="title">
                    </div>

                    <div class="row col mb-4">
                        <div class="col-6 mb-4" style="margin-top:0;">
                            <label for="content" class="form-label">Выбор категории</label>
                            <select name="topic" class="form-select" aria-label="Default select example">
                                <option selected value="<?=$topic?>"> <?php if($topic != ""){echo $my_db->get_data("name","topics","id",$topic);}else{echo "Нажмите, чтобы выбрать категорию поста";}?></option>
                                <?php
                                $topics = $my_db->get_all_table("topics");
                                foreach($topics as $key => $topic)
                                { ?>
                                    <option value="<?=$topic["id"];?>"><?=$topic["name"];?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-6 mb-4" style="margin-top:0;">
                            <label for="content" class="form-label">Выбор статуса публикации</label>
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option selected value="<?=$status?>"><?php if($status === 0 or $status === "0"){echo "Не опубликовывать";}elseif($status === 1 or $status === "1"){echo "Опубликовать";}else{echo "Нажмите, чтобы выбрать статус публикации";}?></option>
                                <option value="1">Опубликовать</option>
                                <option value="0">Не опубликовывать</option>
                            </select>
                        </div>

                    </div>

                    <div class="input-group col mb-4 ">
                        <input name="image" type="file" class="form-control" id="inputGroupFile02">
                        <label class="input-group-text" for="inputGroupFile02">Перевыбрать</label>
                    </div>

                    <div class="col mb-4 text-content">
                        <label for="editor" class="form-label">Содержимое статьи</label>
                        <textarea name="content" class="form-control" placeholder="Введите текст статьи" id="editor" rows="6"><?=$content;?></textarea>
                    </div>

                    <div class="col mb-4">
                        <button name="post-edit" class="btn btn-primary" type="submit">Изменить статью</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- MAIN END-->

<!-- footer start -->
<?php include ("../../app/include/footer.php"); ?>
<!-- footer end -->

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Добавление визуального редактора к текстовому полю админки -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
<script src="../../assets/js/scripts.js"></script>
</body>
</html>
