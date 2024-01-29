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


// Код для создания категории
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["topic-create"]))
{
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);

    if($name === "" or $description === "")
    {
        array_push($err_msg, "Не все поля заполнены!");
    }
    if(mb_strlen($name,"UTF-8") <= 2)
    {
        array_push($err_msg, "Название категории должно быть более 2-х символов!");
    }
    if(mb_strlen($name,"UTF-8") >= 20)
    {
        array_push($err_msg, "Название категории должно быть менее 20-и символов!");
    }
    if ($my_db->search_data("name", "topics", "name", $name))
    {
        array_push($err_msg, "Такая категория уже создана!");
    }
    if(count($err_msg) === 0)
    {
        $my_db->insert_data("topics",["name"=>$name, "description"=>$description]);

        header("location: ". BASE_URL . "admin/topics/index.php");
    }
}
else
{
    $name = "";
    $description = "";
}


// Редактирование категории
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["id"]))
{
    $id = $_GET["id"];
    $topic = $my_db->get_array_data("topics","id",$id);
    $id = $topic["id"];
    $name = $topic["name"];
    $description = $topic["description"];

}

if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["topic-edit"]))
{
    $id = $_POST["id"];
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);

    if($name === "" or $description === "")
    {
        array_push($err_msg, "Не все поля заполнены!");
    }
    if(mb_strlen($name,"UTF-8") <= 2)
    {
        array_push($err_msg, "Название категории должно быть более 2-х символов!");
    }
    if(mb_strlen($name,"UTF-8") >= 20)
    {
        array_push($err_msg, "Название категории должно быть менее 20-и символов!");
    }
    if (($my_db->search_data("name", "topics", "name", $name)) and ($my_db->get_data("id","topics","name",$name)!=$id))
    {
        array_push($err_msg, "Такая категория уже создана!");
    }
    if(count($err_msg) === 0)
    {
        $my_db->update_data("topics","name",$name,"id",$id);
        $my_db->update_data("topics","description",$description,"id",$id);
        header("location: ". BASE_URL . "admin/topics/index.php");
    }
}



// Удаление категории
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["delete-id"]))
{

    $id = $_GET["delete-id"];
    $my_db->delete_data("topics","id",$id);
    header("location: ". BASE_URL . "admin/topics/index.php");
}
