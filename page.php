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
        <?php if ($this->options->topNotice) { ?>
            <div class="notice p-2 box">
                <i class="icon-info"></i>
                <?php $this->options->topNotice() ?>
            </div>
        <?php } ?>
        <div class="post-breadcrumb box">
            <a href="<?php $this->options->index(); ?>" title="<?php _e("回到首页") ?>"><?php _e("首页") ?></a><i class="icon-arrow-right"></i><?php _e('页面：<strong>%s</strong>', $this->title); ?>
        </div>
        <div class="post box">
            <div class="post-header">
                <h2 class="post-title">
                    <i class="icon-text"></i>
                    <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a>
                    <?php if ($this->allow('edit')): ?>
                        <a class="post-edit-button" href="<?php $this->options->adminUrl('write-page.php?cid=' . $this->cid) ?>"><i class="icon-pencil"></i></a>
                    <?php endif; ?>
                </h2>
                <ul class="post-meta">
                    <li class="meta-date"><i class="icon-calendar"></i><span><?php $this->date(); ?></span></li>
                    <li class="meta-comments"><i class="icon-comment"></i><a href="<?php $this->permalink() ?>#comments" title="<?php _e("对《%s》发表评论", $this->title) ?>"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></a></li>
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