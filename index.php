<?php
/**
 * 三栏主题：SimpX （重构）
 * 
 * @package SimpX
 * @author 逗妇乳
 * @version 0.2.1 alpha1
 * @link http://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>
<?php if(!is_pjax()): ?>
<?php $this->need('left-sidebar.php'); ?>
<?php endif; ?>
	<div id="main" class="floatleft">
	<div class="post-list">
	<?php while($this->next()): ?>
		<article class="post hentry box format" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
			<?php $thumb = $this->getThumb;
				if (($thumb === "unknown") || $thumb === "" || $thumb === null) {
					$allFields = unserialize($this->___fields());
					if (array_key_exists('thumbUrl',unserialize($this->___fields()))) {
						$thumb = $allFields['thumbUrl'];
					} 
				}
				if ($thumb !== "") { ?>
					<a class="post-cover" itemprop="image" href="<?php $this->permalink() ?>"><img src="<?php echo $thumb; ?>" /></a>
				<?php } ?>
			<header class="entry-header">
				<h2 class="entry-title"></i><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark" data-pjax><?php $this->title() ?></a></h2>
				<ul class="entry-meta">
					<li class="meta-date"><?php $this->date('F j, Y'); ?></li>
					<li class="meta-cat"><?php $this->category(','); ?></li>
					<li class="meta-comments"><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
					<?php $currGroup = get_object_vars($this->user) ['row']['group'];
						if ($currGroup == "administrator"): ?>
							<li><a data-no-instant="" href="<?php $this->options->siteUrl(); ?>admin/write-post.php?cid=<?php echo $this->cid; ?>"><?php  _e('Edit'); ?></a></li>
					<?php endif; ?>
				</ul>
			</header>
<?php if(!is_mobile()): ?>
			<div class="entry-summary">
				<?php $this->excerpt(350, '...'); ?>
			</div>
<?php endif; ?>
			<div class="entry-footer">
				<span itemprop="keywords" class="tags-links"><?php $this->tags(', ', true, 'none'); ?></span>
				<p class="morelink"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php _e('继续阅读 »'); ?></a></p>
			</div>
		</article>
	<?php endwhile; ?>
	</div>
	<!-- pagenavi START -->
	<div class="page-navi">
		<ol class="pages">
			<?php $this->pageNav('Newer', 'Older', 3,'...'); ?>
		</ol>
	</div>
    <!-- pagenavi END -->
	</div>
	<?php $this->need('sidebar.php'); ?>
</div>
<?php $this->need('footer.php'); ?>