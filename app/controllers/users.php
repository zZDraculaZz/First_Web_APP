<?php
include SITE_ROOT . "/settings.php" ;
$is_submit = False;
$reg_info_msg = "";
$auth_info_msg = "";

function user_auth($my_db, $email)
{
    $id = $my_db->get_data("id","users","email",$email);
    $user = $my_db->get_array_data("users","id",$id);
    $_SESSION["id"] = $user["id"];
    $_SESSION["login"] = $user["login"];
    $_SESSION["admin"] = $user["admin"];

    if($_SESSION["admin"])
    {
        header("location:" . BASE_URL . "admin/posts/index.php");
    }
    else
    {
        header("location: " . BASE_URL);
    }
}

function get_pages_cnt($limit_posts, $my_db,$params=[],$add_params="")
{
    $posts_cnt=$my_db->take_data("COUNT(*)","posts",$params,$add_params)[0]["COUNT(*)"];
    if (empty($posts_cnt % $limit_posts)) {
        $pages_cnt = intdiv($posts_cnt, $limit_posts);
    } else {
        $pages_cnt = (intdiv($posts_cnt, $limit_posts)) + 1;
    }
    return $pages_cnt;
}
function get_page($pages_cnt)
{
    if (empty($_GET["page"]) or trim($_GET["page"]) < 1) {
        $page = 1;
    } elseif ($_GET["page"] > $pages_cnt) {
        $page = $pages_cnt;
    } else {
        $page = $_GET["page"];
    }
    return $page;
}
function get_posts($limit_posts,$my_db,$page,$params=[],$add_params="")
{
    $offset=($page-1)*$limit_posts;
    $posts = $my_db->take_data("*","posts",$params,"{$add_params}LIMIT $limit_posts OFFSET $offset");
    return $posts;
}

// код для регистрации
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["button-reg"]))
{
    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $pass_first = trim($_POST["pass-first"]);
    $pass_second = trim($_POST["pass-second"]);
    $admin = 0;

    if($login === "" or $email === "" or $pass_first === "" or $pass_second === "" )
    {
        $reg_info_msg = "Не все поля заполнены!";
    }
    elseif(mb_strlen($login,"UTF-8") <= 2)
    {
        $reg_info_msg = "Логин должен быть более 2-х символов!";
    }
    elseif(mb_strlen($pass_first,"UTF-8") <= 5)
    {
        $reg_info_msg = "Пароль должен быть более 5-и символов!";
    }
    elseif($pass_first != $pass_second)
    {
        $reg_info_msg = "Пароли в обеих полях должны совпадать!";
    }
    else
    {

        if ($my_db->search_data("login", "users", "login", $login))
        {
            $reg_info_msg = "Такой логин уже зарегистрирован!";
        }
        elseif($my_db->search_data("email", "users", "email", $email))
        {
            $reg_info_msg = "Такой email уже зарегистрирован!";
        }
        else
        {

            $password = password_hash($pass_first, PASSWORD_DEFAULT);
            $my_db->create_user($email,$login,$password,$admin);

            user_auth($my_db, $email);
        }
    }
    $is_submit = True;
}
else
{
    $login = '';
    $email = '';
}

// код для авторизации
if($_SERVER["REQUEST_METHOD"] === "POST" and isset($_POST["button-auth"]))
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    if($_SESSION["trying-auth"] === 5 and empty($_SESSION["time-out"]))
    {
        $_SESSION["time-out"] = time();
    }
    if($_SESSION["trying-auth"] === 5 and isset($_SESSION["time-out"]))
    {
        $time_left=time()-($_SESSION["time-out"]+180);
        if ($time_left<=0)
        {
            $auth_info_msg = "Вы использовали много попыток входа, попробуйте через " . ($time_left * -1) . " секунд(ы)";
        }
        else
        {
            unset($_SESSION["time-out"]);
            unset($_SESSION["trying-auth"]);
            if($email === "" or $password === "")
            {
            $auth_info_msg = "Не все поля заполнены!";
            }
            elseif($my_db->search_data("email", "users", "email", $email))
            {
                if(password_verify($password, $my_db->get_data("password","users","email",$email)))
                {
                    user_auth($my_db, $email);
                }
                else
                {
                    $_SESSION["trying-auth"] += 1;
                    $auth_info_msg = "Неверный пароль!";
                }
            }
            else
            {
                $_SESSION["trying-auth"] += 1;
                $auth_info_msg = "Такого Email не найдено!";
            }
        }
    }

    elseif($email === "" or $password === "")
    {
        $auth_info_msg = "Не все поля заполнены!";
    }
    elseif($my_db->search_data("email", "users", "email", $email))
    {
        if(password_verify($password, $my_db->get_data("password","users","email",$email)))
        {
            user_auth($my_db, $email);
            unset($_SESSION["trying-auth"]);
        }
        else
        {
            $_SESSION["trying-auth"] += 1;
            $auth_info_msg = "Неверный пароль!";
        }
    }
    else
    {
        $_SESSION["trying-auth"] += 1;
        $auth_info_msg = "Такого Email не найдено!";
    }
}


// код для поиска
if($_SERVER["REQUEST_METHOD"] === "GET" and isset($_GET["search-button"]) or isset($_GET["topic"]) or isset($_GET["content"]) or isset($_GET["page"]))
{
    $content=$_GET["content"];
    $topic=$_GET["topic"];
    $content = trim(strip_tags(htmlspecialchars($content)));
    $topic = trim(strip_tags(htmlspecialchars($topic)));

    if (empty($content) and !empty($topic))
    {
        $pages_cnt = get_pages_cnt($limit_posts,$my_db,["status"=>1,"topic_id"=>$topic]);
        $page = get_page($pages_cnt);
        $posts = get_posts($limit_posts,$my_db,$page,["status"=>1,"topic_id"=>$topic]);
    }
    elseif(empty($topic) and !empty($content))
    {
        $pages_cnt = get_pages_cnt($limit_posts,$my_db,["status"=>1],"AND (\"content\" LIKE \"%$content%\" OR \"title\" LIKE \"%$content%\") ");
        $page = get_page($pages_cnt);
        $posts = get_posts($limit_posts,$my_db,$page,["status"=>1],"AND (\"content\" LIKE \"%$content%\" OR \"title\" LIKE \"%$content%\") ");
    }
    elseif(empty($topic) and empty($content))
    {
        $pages_cnt = get_pages_cnt($limit_posts,$my_db,["status"=>1]);
        $page = get_page($pages_cnt);
        $posts = get_posts($limit_posts,$my_db,$page,["status"=>1]);
    }
    else
    {
        $pages_cnt = get_pages_cnt($limit_posts,$my_db,["status"=>1, "topic_id"=>$topic],"AND (\"content\" LIKE \"%$content%\" OR \"title\" LIKE \"%$content%\") ");
        $page = get_page($pages_cnt);
        $posts = get_posts($limit_posts,$my_db,$page,["status"=>1,"topic_id"=>$topic],"AND (\"content\" LIKE \"%$content%\" OR \"title\" LIKE \"%$content%\") ");
    }
}