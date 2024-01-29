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

        <?php include SITE_ROOT . "/app/include/sidebar_admin.php";?>

        <div class="posts col-10">
            <div class="button row">
                <a href="<?= BASE_URL . "admin/users/create.php" ?>" class="col-4 btn btn-success">Добавить пользователя</a>
                <span class="col-1"></span>
                <a href="<?= BASE_URL . "admin/users/index.php" ?>" class="col-4 btn btn-warning">Управлять пользователями</a>
            </div>

            <div class="row title-table">
                <h2>Добавление пользователя</h2>
            </div>
            <div class="row add-posts">
                <form action="create.php" method="post">

                    <div class="col err">
                        <!-- Вывод массива с ошибками -->
                        <?php include SITE_ROOT . "/app/helps/error_info.php";?>
                    </div>

                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Логин</label>
                        <input name="login" value="<?=$login?>" type="text" class="form-control" id="formGroupExampleInput" placeholder="Введите логин">
                    </div>

                    <div class="col">
                        <label for="exampleInputEmail1" class="form-label">Email адрес</label>
                        <input name="email" type="email" value="<?=$email?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Введите почту">
                    </div>

                    <div class="col">
                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                        <input name="pass-first" type="password" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
                    </div>

                    <div class="col">
                        <label for="exampleInputPassword2" class="form-label">Подтверждение пароля</label>
                        <input name="pass-second" type="password" class="form-control" id="exampleInputPassword2" placeholder="Повторите пароль">
                    </div>

                    <div class="col">
                        <label for="content" class="form-label">Выбор категории пользователя</label>
                        <select name="admin" class="form-select" aria-label="Default select example">
                            <option selected value="<?=$admin?>"><?php if($admin === 0 or $admin=== "0"){echo "User";}elseif($admin === 1 or $admin === "1"){echo "Admin";}else{echo "Нажмите, чтобы выбрать категорию пользователя";}?></option>
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>

                    <div class="col">
                        <button name="user-create" class="btn btn-primary" type="submit">Создать пользователя</button>
                    </div>

                </form>
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
