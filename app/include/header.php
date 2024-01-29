<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-1 col-md-3">
                <h1>
                    <a href="<?php echo BASE_URL ?>">My blog</a>
                </h1>
            </div>
            <nav class = "col-11 col-md-9">
                <ul>
                    <li>
                        <a href="<?php echo BASE_URL ?>"><i class="fa-solid fa-house"></i> Главная</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-solid fa-circle-info"></i> О нас</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-solid fa-receipt"></i> Услуги</a>
                    </li>

                    <li>
                        <?php if(isset($_SESSION["id"])): ?>
                            <a href="#"><i class="fa-solid fa-user-tie"></i>
                                <?php echo $_SESSION["login"];?>
                            </a>
                            <ul>
                                <?php if($_SESSION["admin"]): ?>
                                <li>
                                    <a href="<?=BASE_URL . "admin/posts/index.php"?>"><i class="fa-solid fa-server"></i> Панель админа</a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo BASE_URL . "logout.php"?>"><i class="fa-solid fa-right-from-bracket"></i> Выход</a>
                                </li>
                            </ul>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL . "authorization.php"?>">
                                <i class="fa-solid fa-user-tie"></i> Вход</a>
                            <ul>
                                <li>
                                    <a href="<?php echo BASE_URL . "registration.php"?>">
                                        <i class="fa-solid fa-server"></i> Регистрация</a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</header>