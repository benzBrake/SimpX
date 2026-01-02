<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
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
    <?php if ($this->is('archive')): ?>
        <div class="post-breadcrumb box"><?php _e('Archive for the category: '); ?><strong><?php $this->category(','); ?></strong></div>
    <?php endif; ?>
    <div class="post-list">
        <?php while ($this->next()): ?>
            <div class="post box">
                <div class="post-header">
                    <h2 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>
                </div>
                <div class="post-content-wrapper">
                    <div class="post-content-placeholder
            ">&nbsp;<br>&nbsp;<br>&nbsp;<br></div>
                    <div
                        class="post-content"><?php $this->excerpt(350, '...'); ?></div>
                </div>
                <?php if ($this->is('archive')): ?>
                    <div class="post-footer">
                        <div class="more-link">
                            <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"
                                rel="bookmark"><?php _e("查看全文"); ?></a>
                        </div>
                        <ul class="post-meta">
                            <li class="meta-date"><i class="icon-calendar"></i><span class="has-tooltip" title="<?php _e("发布时间：%s", date(Helper::options()->postDateFormat, $this->created)) ?>"><?php $this->date(); ?></span></li>
                            <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
                            <li class="meta-comments"><i class="icon-comment"></i><a
                                    class="has-tooltip"
                                    href="<?php $this->permalink() ?>#comments"
                                    title="<?php _e("评论《%s》", $this->title); ?>"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></a>
                            </li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    <!-- pagenavi START -->
    <div class="pagenavi">
        <ol class="pages clearfix">
            <?php $this->pageNav(); ?>
        </ol>
        <div class="fixed"></div>
    </div>
    <!-- pagenavi END -->


</div>
<!-- content END -->
<?php $this->need('footer.php'); ?>