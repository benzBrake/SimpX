<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('components/header.php'); ?>
<?php $this->need('components/left-sidebar.php'); ?>
	<div id="main" class="floatleft">
	<article class="post entry box" itemscope itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<h1 class="entry-title" itemprop="name headline"><?php $this->title() ?></h1>
		<ul class="entry-meta">
			<li itemprop="author" itemscope itemtype="http://schema.org/Person"><?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></li>
            <li><?php _e('时间: '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time></li>
            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
					<?php $currGroup = get_object_vars($this->user) ['row']['group'];
						if ($currGroup == "administrator"): ?>
							<li><a data-no-instant="" href="<?php $this->options->siteUrl(); ?>admin/write-post.php?cid=<?php echo $this->cid; ?>"><?php  _e('Edit'); ?></a></li>
					<?php endif; ?>
        </ul>
	</header>
		<div class="entry-content" itemprop="articleBody">
			<?php $this->content(); ?>
		</div>
		<div class="entry-footer">
			<?php $allFields = unserialize($this->___fields()); 
				if (array_key_exists('copyright',unserialize($this->___fields()))) {
					$fields = str_replace("\r\n","，",$allFields['copyright']);
					$copyright = '本文参考自' . $fields . "。";
				} else {
					$copyright = '本文章为原创，转载请以链接形式注明本文地址 ';
				} ?>
			<div class="copyright"><?php _e($copyright); ?></div>
			<span itemprop="keywords" class="tags-links"><?php $this->tags('', true, ''); ?></span>
		</div>
    </article>
    <ul class="entry-near">
        <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
    </ul>
    <?php $this->need('components/comments.php'); ?>
</div>
<?php $this->need('components/sidebar.php'); ?>
<?php $this->need('components/footer.php'); ?>