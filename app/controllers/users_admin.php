<?php
include SITE_ROOT . "/settings.php" ;
if (!$_SESSION){
    header("location: " . BASE_URL . "authorization.php");
}
if ($_SESSION["admin"] === 0 )
{
    header("location: " . BASE_URL . "index.php");
}

$err_msg = [];

// код для создания пользователя с админки
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["user-create"]))
{
    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $pass_first = trim($_POST["pass-first"]);
    $pass_second = trim($_POST["pass-second"]);
    $admin = trim($_POST["admin"]);

    if($login === "" or $email === "" or $pass_first === "" or $pass_second === "" or $admin === "")
    {
        array_push($err_msg,"Не все поля заполнены!");
    }
    if(mb_strlen($login,"UTF-8") <= 2)
    {
        array_push($err_msg,"Логин должен быть более 2-х символов!");
    }
    if($admin === "")
    {
        array_push($err_msg,"Выберите категорию пользователя!");
    }
    if(mb_strlen($pass_first,"UTF-8") <= 5)
    {
        array_push($err_msg,"Пароль должен быть более 5-и символов!");
    }
    if($pass_first != $pass_second)
    {
        array_push($err_msg,"Пароли в обеих полях должны совпадать!");
    }
    if(count($err_msg)===0)
    {

        if ($my_db->search_data("login", "users", "login", $login))
        {
            array_push($err_msg,"Такой логин уже зарегистрирован!");
        }
        elseif($my_db->search_data("email", "users", "email", $email))
        {
            array_push($err_msg,"Такой email уже зарегистрирован!");
        }
        else
        {

            $password = password_hash($pass_first, PASSWORD_DEFAULT);
            $my_db->create_user($email,$login,$password,$admin);

            header("location: ". BASE_URL . "admin/users/index.php");
        }
    }
}
else
{
    $login = '';
    $email = '';
    $admin = "";
}

// Редактирование пользователя
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["id"]))
{
    $user = $my_db->get_array_data("users","id",$_GET["id"]);
    $id = $user["id"];
    $login = $user["login"];
    $email = $user["email"];
    $admin = $user["admin"];
}
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["user-edit"]))
{
    $id = $_POST["id"];
    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $pass_first = trim($_POST["pass-first"]);
    $pass_second = trim($_POST["pass-second"]);
    $admin = trim($_POST["admin"]);

    if($login === "" or $email === ""  or $admin === "")
    {
        array_push($err_msg,"Не все поля заполнены!");
    }
    if(mb_strlen($login,"UTF-8") <= 2)
    {
        array_push($err_msg,"Логин должен быть более 2-х символов!");
    }
    if($admin === "")
    {
        array_push($err_msg,"Выберите категорию пользователя!");
    }
    if(mb_strlen($pass_first,"UTF-8") <= 5 and mb_strlen($pass_first,"UTF-8") != 0)
    {
        array_push($err_msg,"Пароль должен быть более 5-и символов!");
    }
    if($pass_first != $pass_second)
    {
        array_push($err_msg,"Пароли в обеих полях должны совпадать!");
    }
    if(count($err_msg)===0)
    {

        if (($my_db->search_data("login", "users", "login", $login)) and ($my_db->get_data("id","users","login",$login)!=$id))
        {
            array_push($err_msg,"Такой логин уже зарегистрирован!");
        }
        elseif(($my_db->search_data("email", "users", "email", $email)) and ($my_db->get_data("id","users","email",$email)!=$id))
        {
            array_push($err_msg,"Такой email уже зарегистрирован!");
        }
        else
        {

            $my_db->update_data("users","login",$login,"id",$id);
            $my_db->update_data("users","email",$email,"id",$id);
            $my_db->update_data("users","admin",$admin,"id",$id);
            if (strlen($pass_first)>0)
            {
                $password = password_hash($pass_first, PASSWORD_DEFAULT);
                $my_db->update_data("users","password",$password,"id",$id);
            }

            header("location: ". BASE_URL . "admin/users/index.php");
        }
    }
}


// Удаление пользователя
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["delete-id"]))
{

    $id = $_GET["delete-id"];
    $user_posts=$my_db->take_data("*","posts",["user_id"=>$id]);

    foreach($user_posts as $key => $user_post)
    {
        $old_image = $user_post["image"];
        $old_image_destination = ROOT_PATH . "/assets/images/posts/" . $old_image;
        unlink($old_image_destination);
        $my_db->delete_data("posts","id",$user_post["id"]);
    }
    $my_db->delete_data("users","id",$id);
    header("location: ". BASE_URL . "admin/users/index.php");
}