<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<?php $this->need('left-sidebar.php'); ?>
	<div id="main" class="post-list floatleft">
        <h3 class="archive-title"><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?></h3>
        <?php if ($this->have()): ?>
    	<?php while($this->next()): ?>
            <article class="post entry box" itemscope itemtype="http://schema.org/BlogPosting">
			<header class="entry-header">
    			<h2 class="entry-title" itemprop="name headline"><a itemtype="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
    			<ul class="entry-meta">
    				<li itemprop="author" itemscope itemtype="http://schema.org/Person"><?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></li>
    				<li><?php _e('时间: '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time></li>
    				<li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
                    <li itemprop="interactionCount"><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a></li>
    			</ul>
			</header>
                <div class="entry-content" itemprop="articleBody">
        			<?php $this->content('- 阅读剩余部分 -'); ?>
                </div>
    		</article>
    	<?php endwhile; ?>
        <?php else: ?>
            <article class="post">
                <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
            </article>
        <?php endif; ?>

        <?php $this->pageNav('Newer', 'Older', 3,'...', array('class' => 'box')); ?>
    </div><!-- end #main -->

	<?php $this->need('sidebar.php'); ?>
	<?php $this->need('footer.php'); ?>
