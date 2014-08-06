<h2>ログイン</h2>

<form action="<?php echo $base_url; ?>/admin/auth/login" method="post">
    

    <?php if (isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', array('errors' => $errors)); ?>
    <?php endif; ?>

	<table>
	    <tbody>
	        <tr>
	            <th>ユーザID</th>
	            <td>
	                <input type="text" name="username" value="<?php echo $this->escape($this->get('username')); ?>" />
	            </td>
	        </tr>
	        <tr>
	            <th>パスワード</th>
	            <td>
	                <input type="password" name="password" value="<?php echo $this->escape($this->get('password')); ?>" />
	            </td>
	        </tr>
	    </tbody>
	</table>

    <p>
        <input type="submit" value="ログイン" />
    </p>
</form>
