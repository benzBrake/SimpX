<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('components/header.php'); ?>
<div class="main error-page">
	<h2 class="entry-title">404 - <?php _e('页面没找到'); ?></h2>
	<p style="font-size:2em;text-align:center;padding:5px"><?php _e('不如看一下: '); ?></p>
	<section id="ramdom-posts">
		<?php randomPosts(); ?>
	</section>
	<div class="error-search"><?php _e('或者搜索看看:  '); ?>
		<form id="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
			<label for="s" class="sr-only"><?php _e('搜索'); ?></label>
			<input type="text" name="s" class="search-input bg-white" placeholder="<?php _e('输入关键字搜索'); ?>" />
			<button type="submit" class="submit search-submit"></button>
		</form>
	</div>
</div>
</div><!-- end #content-->
<?php $this->need('components/footer.php'); ?>