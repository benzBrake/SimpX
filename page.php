<?php $this->need('header.php'); ?>
<!-- container start -->
<div class="container single">
    <!-- content START -->
    <?php $status = getSiderbarStatus(); ?>
    <?php if ($status->showLeftSidebar): ?>
        <div id="left-sidebar" class="sidebar">
            <?php $this->need('components/sidebar/left.php'); ?>
        </div>
    <?php endif; ?>
    <?php if ($status->showRightSidebar): ?>
        <div id="right-sidebar" class="sidebar">
            <?php $this->need('components/sidebar/right.php'); ?>
        </div>
    <?php endif; ?>
    <div id="main" class="content">
        <div class="post-breadcrumb box">
            <a href="<?php $this->options->index(); ?>" title="<?php _e("回到首页") ?>"><?php _e("首页") ?></a><i class="icon-arrow-right"></i><?php _e('页面：<strong>%s</strong>', $this->title); ?>
        </div>
        <div class="post box">
            <div class="post-header">
                <h2 class="post-title">
                    <i class="icon-text"></i>
                    <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a>
                </h2>
                <ul class="post-meta">
                    <li class="meta-date"><?php $this->date(); ?></li>
                    <li class="meta-comments"><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
                </ul>
            </div>
            <div class="post-content">
                <?php $this->content(); ?>
            </div>
        </div>
        <?php $this->need('comments.php'); ?>
    </div>
    <!-- content END -->
</div>
<div class="clear"></div>
<!-- container end -->

<?php $this->need('footer.php'); ?>