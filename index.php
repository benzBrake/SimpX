<?php

/**
 * 一款淡蓝主题，采用了<del>高大上</del>的字体图标(ie 6 不支持图标字体)。
 * @package 三栏主题：SimpX  (Theme designed by weleeTime.Mod By Tammy)
 * @author Tammy
 * @version 0.1.4
 * @link http://32mb.cc
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<!-- content start -->
<?php $status = getSiderbarStatus(); ?>
<?php if ($status->showLeftSidebar): ?>
    <?php $this->need('components/sidebar/left.php'); ?>
<?php endif; ?>
<?php if ($status->showRightSidebar): ?>
    <?php $this->need('components/sidebar/right.php'); ?>
<?php endif; ?>
<div id="main" class="content">
    <?php if ($this->options->topNotice) { ?>
        <div class="notice p-2 box">
            <i class="icon-info"></i>
            <?php $this->options->topNotice() ?>
        </div>
    <?php } ?>
    <div class="post-list">
        <?php while ($this->next()): ?>
            <div class="post box">
                <div class="post-header">
                    <h2 class="post-title"><i class="icon-text"></i><a href="<?php $this->permalink() ?>"
                            title="<?php $this->title() ?>"
                            rel="bookmark"><?php $this->title() ?></a>
                    </h2>
                </div>
                <div class="post-content-wrapper"><div class="post-content-placeholder">&nbsp;<br>&nbsp;<br>&nbsp;<br></div><div class="post-content"><?php $this->excerpt(350, '...'); ?></div>
                </div>
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
            </div>
        <?php endwhile; ?>
    </div>
    <!-- pagenavi START -->
    <div class="pagenavi">
        <ol class="pages clearfix">
            <?php $this->pageNav(); ?>
        </ol>
        <div class="clear"></div>
    </div>
    <!-- pagenavi END -->
</div>
<!-- content end -->
<?php $this->need('footer.php'); ?>