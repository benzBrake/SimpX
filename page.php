<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('components/header.php'); ?>

<?php $this->need('components/left-sidebar.php'); ?>

<div id="main" class="floatleft">
    <article class="post entry box" itemscope itemtype="http://schema.org/BlogPosting">
			<header class="entry-header">
	<h1 class="entry-title" itemprop="name headline"><a itemtype="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
			</header>
        <div class="entry-content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>
    </article>
    <?php $this->need('components/comments.php'); ?>
</div><!-- end #main-->

<?php $this->need('components/sidebar.php'); ?>
<?php $this->need('components/footer.php'); ?>
