<div class="header">

	<div class="title">BLOG</div>
</div>

<div class="container">
	<div class="main-container">

		<?php foreach ($this->get('posts') as $post) :?>
		<div class="article">
			<div class="article-title">
				<?php echo $this->escape($post->title)?></a>
			</div>
			<div class="article-content">
				<?php echo nl2br($this->escape($post->body)) ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<div class="sub-container">

	</div>
</div>
