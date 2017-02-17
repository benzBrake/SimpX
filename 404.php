<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
	 <div class="main error-page">
		<h2 class="entry-title">404 - <?php _e('页面没找到'); ?></h2>
		<p style="font-size:2em;text-align:center;padding:5px"><?php _e('不如看一下: '); ?></p>
		<section id="ramdom-posts">
			<?php randomPosts(); ?>
		</section>
		<p style="font-size:2em;text-align:center;padding:5px"><?php _e('或者搜索看看:  '); ?></p>
		<form method="post">
				<p><input type="text" name="s" class="text" autofocus /></p>
				<p><button type="submit" class="submit"><?php _e('搜索'); ?></button></p>
			</form>
		</div>
	</div><!-- end #content-->
	<?php $this->need('footer.php'); ?>
