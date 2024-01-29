<?php
include "../../path.php";
include SITE_ROOT . "/app/controllers/users_admin.php";
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

        <?php include  SITE_ROOT . "/app/include/sidebar_admin.php"?>

        <div class="posts col-10">
            <div class="button row">
                <a href="<?= BASE_URL . "admin/users/create.php" ?>" class="col-4 btn btn-success">Добавить пользователя</a>
                <span class="col-1"></span>
                <a href="<?= BASE_URL . "admin/users/index.php" ?>" class="col-4 btn btn-warning">Управлять пользователями</a>
            </div>

            <div class="row title-table ">
                <h2>Управление пользователями</h2>
                <div class="id col-1">ID</div>
                <div class="login col-2">Логин</div>
                <div class="login col-2">Email</div>
                <div class="admin col-3" style="padding-left: 75px;">Роль</div>
                <div class="red col-4">Управление</div>
            </div>
            <div class="row all-posts">

                <?php
                $users = $my_db->get_all_table("users");
                foreach($users as $key => $user)
                { ?>
                    <div class="row post">
                        <div class="id col-1"><?php echo $key+1;?></div>
                        <div class="login col-2"><?php echo $user["login"];?></div>
                        <div class="login col-3"><?php echo $user["email"];?></div>
                        <?php if($user["admin"] === 1)
                        { ?>
                            <div class="admin col-2" style="color:#00b400;">Admin</div>

                        <?php } else{?>
                            <div class="admin col-2">User</div>
                        <?php } ?>
                        <div class="red col-2"><a href="edit.php?id=<?=$user["id"]; ?>">edit</a></div>
                        <div class="del col-2"><a href="index.php?delete-id=<?=$user["id"]; ?>">delete</a></div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- MAIN END-->

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
</body>
</html>

