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


// Код для создания записи
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["post-create"]))
{
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $topic = trim($_POST["topic"]);
    $status = trim($_POST["status"]);

    if($title === "" or $content === "" or $topic === "" or $status === "")
    {
        array_push($err_msg, "Не все поля заполнены!");
    }
    if(mb_strlen($title,"UTF-8") <= 7 or mb_strlen($title,"UTF-8") > 255)
    {
        array_push($err_msg, "Название поста должно быть более 7-b символов и не более 255 символов!");
    }
    if ($topic === "")
    {
        array_push($err_msg, "Выберите категорию поста!");
    }
    if ($status === "")
    {
        array_push($err_msg, "Выберите статус публикации!");
    }

    if(!empty($_FILES["image"]["name"]))
    {

        $image_name = time() . "_" . $_FILES["image"]["name"];
        $file_tmp_name = $_FILES["image"]["tmp_name"];
        $file_type = $_FILES["image"]["type"];
        $destination = ROOT_PATH . "/assets/images/posts/" . $image_name;

        if (strpos($file_type, "image") === false)
        {
            array_push($err_msg, "Можно загружать только изображения!");
        }
        else {
            if (count($err_msg) === 0) {
                $result = move_uploaded_file($file_tmp_name, $destination);

                if ($result) {
                    $_POST["image"] = $image_name;
                    $my_db->insert_data("posts", ["user_id" => $_SESSION["id"], "title" => $title, "content" => $content, "topic_id" => $topic, "image" => $_POST["image"], "status" => $status]);
                    header("location: " . BASE_URL . "admin/posts/index.php");
                } else {
                    array_push($err_msg, "Ошибка загрузки изображения на сервер!");
                }
            }
        }
    }
    else
    {
        array_push($err_msg, "Выберите файл картинки!");
    }


}
else
{
    $title = "";
    $content = "";
    $status = "";
    $topic = "";
}


// Редактирование категории
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["id"]))
{
    $post = $my_db->get_array_data("posts","id",$_GET["id"]);
    $id = $post["id"];
    $title = $post["title"];
    $content = $post["content"];
    $topic = $post["topic_id"];
    $status = $post["status"];
}

if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["post-edit"])) {
    $id = $_POST["id"];
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $topic = trim($_POST["topic"]);
    $status = trim($_POST["status"]);

    if ($title === "" or $content === "" or $topic === "" or $status === "") {
        array_push($err_msg, "Не все поля заполнены!");
    }
    if (mb_strlen($title,"UTF-8") <= 7 or mb_strlen($title,"UTF-8") > 255) {
        array_push($err_msg, "Название поста должно быть более 7-b символов и не более 255 символов!");
    }
    if ($topic === "") {
        array_push($err_msg, "Выберите категорию поста!");
    }
    if ($status === "") {
        array_push($err_msg, "Выберите статус публикации!");
    }
    if (!empty($_FILES["image"]["name"])) {
        $image_name = time() . "_" . $_FILES["image"]["name"];
        $file_tmp_name = $_FILES["image"]["tmp_name"];
        $file_type = $_FILES["image"]["type"];
        $destination = ROOT_PATH . "/assets/images/posts/" . $image_name;

        if (strpos($file_type, "image") === false)
        {
            array_push($err_msg, "Можно загружать только изображения!");
        } else {
            if (count($err_msg) === 0) {
                $result = move_uploaded_file($file_tmp_name, $destination);

                if ($result) {
                    $old_image = $my_db->get_data("image","posts","id",$id);
                    $old_image_destination = ROOT_PATH . "/assets/images/posts/" . $old_image;
                    unlink($old_image_destination);

                    $_POST["image"] = $image_name;
                    $my_db->update_data("posts", "title", $title, "id", $id);
                    $my_db->update_data("posts", "content", $content, "id", $id);
                    $my_db->update_data("posts", "topic_id", $topic, "id", $id);
                    $my_db->update_data("posts", "image", $_POST["image"], "id", $id);
                    $my_db->update_data("posts", "status", $status, "id", $id);

                    header("location: " . BASE_URL . "admin/posts/index.php");

                } else {
                    array_push($err_msg, "Ошибка загрузки изображения на сервер!");
                }
            }
        }
    } else {
        if (count($err_msg) === 0) {
            $my_db->update_data("posts", "title", $title, "id", $id);
            $my_db->update_data("posts", "content", $content, "id", $id);
            $my_db->update_data("posts", "topic_id", $topic, "id", $id);
            $my_db->update_data("posts", "status", $status, "id", $id);
            header("location: " . BASE_URL . "admin/posts/index.php");
        }
    }
}

// Удаление категории
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["delete-id"]))
{

    $id = $_GET["delete-id"];
    $old_image = $my_db->get_data("image","posts","id",$id);
    $old_image_destination = ROOT_PATH . "/assets/images/posts/" . $old_image;
    unlink($old_image_destination);
    $my_db->delete_data("posts","id",$id);
    header("location: ". BASE_URL . "admin/posts/index.php");
}

// Смена статуса публикации
if ($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["publish-id"]))
{
    $id = $_GET["publish-id"];
    $my_db->update_data("posts","status","1","id",$id);
    header("location: ". BASE_URL . "admin/posts/index.php");
}
elseif ($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["unpublish-id"]))
{
    $id = $_GET["unpublish-id"];
    $my_db->update_data("posts","status","0","id",$id);
    header("location: ". BASE_URL . "admin/posts/index.php");
}

