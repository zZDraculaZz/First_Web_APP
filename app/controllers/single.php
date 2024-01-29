<?php

$err_msg = [];
// переход на сингл стр
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["post-id"]))
{
    $post_id = $_GET["post-id"];
    $post = $my_db->get_array_data("posts", "id", $post_id);
    if (empty($post)) header("location: " . BASE_URL);
    if ($post["status"] === 0) header("location: " . BASE_URL);
    $comments = $my_db->take_data("*","comments",["post_id"=>$post_id]);
}

// сохранение комментария
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["post-id"]) and isset($_POST["comment"]))
{
    if (empty($_SESSION["id"])) header("location: " . BASE_URL . "authorization.php");
    $post_id = trim(strip_tags(htmlspecialchars($_GET["post-id"])));
    $post = $my_db->get_array_data("posts", "id", $post_id);
    if (empty($post)) header("location: " . BASE_URL);
    if ($post["status"] === 0) header("location: " . BASE_URL);
    $user_id=$_SESSION["id"];
    $comment = trim(strip_tags(htmlspecialchars($_POST["comment"])));
    if (empty($comment) or mb_strlen($comment,"UTF-8")<5)
    {
        array_push($err_msg, "Вы не можете оставить комментрай в котором меньше 5 символов!!");
    }
    else
    {
        $my_db->insert_data("comments", ["user_id" => $user_id, "post_id" => $post_id, "comment" => $comment]);
        $comments = $my_db->take_data("*", "comments", ["post_id" => $post_id]);
    }
}