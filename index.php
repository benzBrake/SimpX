<?php

/**
 * 三栏主题：SimpX （重构）
 * 
 * @package SimpX
 * @author 逗妇乳
 * @version 0.2.2
 * @link http://doufu.ru
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('components/header.php');
?>
<?php if (!is_pjax()) : ?>
	<?php $this->need('components/left-sidebar.php'); ?>
<?php endif; ?>
<div id="main" class="floatleft">
	<div class="post-list">
		<?php while ($this->next()) : ?>
			<article class="post hentry box format" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
				<a class="post-cover" itemprop="image" href="<?php $this->permalink() ?>"><img src="<?php thumbs($this, 1, false, false) ?>" /></a>
				<header class="entry-header">
					<h2 class="entry-title"></i><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark" data-pjax><?php $this->title() ?></a></h2>
					<?php if (!is_mobile()) : ?>
						<ul class="entry-meta">
							<li class="meta-date"><?php $this->date('F j, Y'); ?></li>
							<li class="meta-cat"><?php $this->category(','); ?></li>
							<li class="meta-comments"><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
							<?php $currGroup = get_object_vars($this->user)['row']['group'];
							if ($currGroup == "administrator") : ?>
								<li><a data-no-instant="" href="<?php $this->options->siteUrl(); ?>admin/write-post.php?cid=<?php echo $this->cid; ?>"><?php _e('Edit'); ?></a></li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</header>

				<div class="entry-summary">
					<?php $this->excerpt(350, '...'); ?>
				</div>
				<div class="entry-footer">
					<span itemprop="keywords" class="tags-links"><?php $this->tags('', true, ''); ?></span>
					<p class="morelink"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php _e('继续阅读 »'); ?></a></p>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
	<!-- pagenavi START -->
	<div class="page-navi">
		<ol class="pages">
			<?php $this->pageNav('Newer', 'Older', 3, '...'); ?>
		</ol>
	</div>
	<!-- pagenavi END -->
</div>
<?php $this->need('components/sidebar.php'); ?>
</div>
<?php $this->need('components/footer.php'); ?>