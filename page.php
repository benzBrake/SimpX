<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<?php $this->need('left-sidebar.php'); ?>

<div id="main" class="floatleft">
    <article class="post entry box" itemscope itemtype="http://schema.org/BlogPosting">
			<header class="entry-header">
	<h1 class="entry-title" itemprop="name headline"><a itemtype="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
			</header>
        <div class="entry-content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>
    </article>
    <?php $this->need('comments.php'); ?>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
