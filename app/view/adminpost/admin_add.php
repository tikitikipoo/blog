<h2>新規投稿</h2>

<form action="<?php echo $base_url; ?>/admin/post/add" method="post">
    

    <?php if (isset($errors) && count($errors) > 0): ?>
    <?php echo $this->render('errors', array('errors' => $errors)) ?>
    <?php endif; ?>

    <p>
    <span>タイトル：</span>
    <input type="text" name="title" value="<?php echo $this->escape($this->get('title')) ?>" />
    </p>

    <p>
    <span>本文：</span>
    <textarea name="body" rows="6" cols="60"><?php echo $this->escape($this->get('body')); ?></textarea>
    </p>
    <p>
        <input type="submit" value="投稿" />
    </p>
</form>