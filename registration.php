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
<?php include  SITE_ROOT . "/app/include/header.php"; ?>
<!-- HEADER END-->

<!-- FORM -->
<div class="container registration_form">
    <form class="row justify-content-center" method="post" action="registration.php">
        <h2 class="col-12">Регистрация</h2>
        <div class="mb-3 col-12 col-md-4 err">
            <p><?=$reg_info_msg?></p>
        </div>
        <div class="w-100"></div>
        <div class="mb-3 col-12 col-md-4">
            <label for="formGroupExampleInput" class="form-label">Логин</label>
            <input name="login" value="<?=$login?>" type="text" class="form-control" id="formGroupExampleInput" placeholder="Введите логин">
            <div id="loginHelp" class="form-text">Используйте латинские буквы</div>
        </div>
        <div class="w-100"></div>
        <div class="mb-3 col-12 col-md-4">
            <label for="exampleInputEmail1" class="form-label">Email адрес</label>
            <input name="email" type="email" value="<?=$email?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Введите вашу почту">
            <div id="emailHelp" class="form-text">Укажите вашу действительную почту</div>
        </div>
        <div class="w-100"></div>
        <div class="mb-3 col-12 col-md-4">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input name="pass-first" type="password" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
            <div id="passwordHelp" class="form-text">Постарайтесь придумать сложный пароль</div>
        </div>
        <div class="w-100"></div>
        <div class="mb-3 col-12 col-md-4">
            <label for="exampleInputPassword2" class="form-label">Подтверждение пароля</label>
            <input name="pass-second" type="password" class="form-control" id="exampleInputPassword2" placeholder="Повторите пароль">
        </div>
        <div class="w-100"></div>
        <div class="submit mb-3 col-12 col-md-4">
            <button type="submit" class="btn btn-primary" name="button-reg">Зарегистрироваться</button>
        </div>
        <div class="w-100"></div>
        <div class="aut_help row justify-content-between mb-3 col-md-4 col-12">
            <div class="col-4">
                <a class="authorization" href="authorization.php">Войти</a>
            </div>
            <div class="col-4">
                <a class="help" href="#">Помощь</a>
            </div>
        </div>
    </form>
</div>
<!-- END FORM -->

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
