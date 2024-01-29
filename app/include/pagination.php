<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php if($page > 1 ): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo "?page=" . $page-1; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content";?>">Назад</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">Назад</a>
            </li>
        <?php endif; ?>

        <!-- Первая страница -->
        <?php if($page!=1 and $page-1!=1 and $page-1 > 0):?>
        <li class="page-item"><a class="page-link" href="<?php echo "?page=1"; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content"; ?>">1</a></li>
        <?php endif;?>


        <?php if($page-1 > 0):?>
            <li class="page-item"><a class="page-link" href="<?php echo "?page=" . $page-1; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content";?>"><?= $page-1; ?></a></li>
        <?php endif;?>

        <li class="page-item disabled"><a class="page-link" href="<?php echo "?page=" . $page; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content";?>"><?= $page; ?></a></li>

        <?php if($page!=$pages_cnt-1 and $page != $pages_cnt and $page<$pages_cnt):?>
            <li class="page-item"><a class="page-link" href="<?php echo "?page=" . $page+1; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content";?>"><?= $page+1 ;?></a></li>
        <?php endif;?>


        <!-- Последняя страница -->
        <?php if($page+1!=$pages_cnt+1 and $page<$pages_cnt):?>
        <li class="page-item"><a class="page-link" href="<?php echo "?page=" . $pages_cnt; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content";?>"><?= $pages_cnt; ?></a></li>
        <?php endif;?>


        <?php if($page < $pages_cnt): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo "?page=" . $page+1; if(!empty($topic))echo "&topic=$topic";if(!empty($content))echo "&content=$content";?>">Следующая</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">Следующая</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>