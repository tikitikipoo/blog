

<a href="<?php echo $base_url; ?>/admin/top/">トップへ</a>
<a href="<?php echo $base_url; ?>/admin/post/add">投稿する</a>

<h2>投稿一覧</h2>


<?php foreach ($this->get('posts') as $post) :?>
<div>
	<div class="post_title"><a href="<?php echo $base_url; ?>/admin/post/edit/<?php echo $post->id ?>">
		<?php echo $this->escape($post->title)?></a>
	</div>

	<div class="post_body"><?php echo nl2br($this->escape($post->body)) ?></body>

</dev>
<?php endforeach; ?>