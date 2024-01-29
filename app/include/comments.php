<div class="col-md-12 col-12 comments">
    <!-- Вывод массива с ошибками -->
    <div class="col err">
        <?php include SITE_ROOT . "/app/helps/error_info.php";?>
    </div>
    <h3>Оставить комментарий</h3>
    <form action="<?=BASE_URL . "single.php?post-id=" . $post_id;?>" method="post">
        <input type="hidden" name="post-id" value="<?=$post_id?>">
        <div class="mb-3 col-md-12 col 12">
            <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" placeholder="Введите свой комментарий..." rows="4"></textarea>
        </div>
        <div class="col-12">
            <button name="send_comment" class="btn btn-primary" type="submit">Отправить</button>
        </div>
    </form>
    <?php if(!empty($comments)): ?>
    <div class="row all-comments">
        <h3>Коментарии к записи</h3>
        <?php for($i=count($comments)-1; $i >= 0; $i--): ?>
            <div class="one-comment col-12">
                <div class="information col-12" style="margin-bottom: 5px;">
                    <i style="font-size: 20px;"><a class="far fa-user"></a> <?=$my_db->get_data("login","users","id",$comments[$i]["user_id"]);?></i>
                    <i style="font-size:17px; float: right;"><?=substr($comments[$i]["created"],10,-3);?></i>

                </div>
                <div class="col-12 text-comment">
                    <?=$comments[$i]["comment"]?>
                </div>
                <div class="information col-12" style="margin-bottom: 5px;">
                    <i style="font-size: 17px;float: right;"><a class="far fa-calendar"></a> <?=substr($comments[$i]["created"],0,10);?></i>
                </div>

            </div>
        <?php endfor?>
    </div>
    <?php endif; ?>
</div>
