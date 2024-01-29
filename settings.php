<?php
include SITE_ROOT . "/app/database/db_interface.php";
include SITE_ROOT . "/app/database/db_functional.php";

session_start();

$host = "localhost";
$db_name = "/app/database/my_db.sqlite";
$my_db = SQLiteDB::get_instance(SITE_ROOT . $db_name);

$limit_posts = 3;
$limit_top_posts = 5;

// создать админа
//$my_db->create_user("admin@gmail.com","Admin",password_hash("123456",PASSWORD_DEFAULT),"1");