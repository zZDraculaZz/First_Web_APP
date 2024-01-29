<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h1>
                    <a href="<?php echo BASE_URL ?>">My blog</a>
                </h1>
            </div>
            <nav class = "col-8">
                <ul>
                    <li>
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
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>