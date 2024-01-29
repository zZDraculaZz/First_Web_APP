<?php if (count($err_msg) > 0):?>
    <?php foreach ($err_msg as $error):?>
        <br><?=$error;?>
    <?php endforeach; ?>
<?php endif; ?>