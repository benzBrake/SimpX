<?php include('header.php'); ?>


<!-- container start -->
<div class="container">
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
        <?php if ($this->is('archive')): ?>
            <div class="post-breadcrumb box"><?php _e('Archive for the category: '); ?><strong><?php $this->category(','); ?></strong></div>
        <?php endif; ?>

        <?php while ($this->next()): ?>
            <div class="post box">
                <div class="post-header">
                    <h2 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>
                </div>
                <div class="post-content-wrapper">
                    <div class="post-content-placeholder">&nbsp;<br>&nbsp;<br>&nbsp;<br></div>
                    <div class="post-content"><?php $this->excerpt(350, '...'); ?></div>
                </div>
                <?php if ($this->is('archive')): ?>
                    <div class="post-footer">
                        <div class="more-link">
                            <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"
                                rel="bookmark"><?php _e("查看全文"); ?></a>
                        </div>
                        <ul class="post-meta">
                            <li class="meta-date"><i class="icon-calendar"></i><?php $this->date(); ?></li>
                            <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
                            <li class="meta-comments"><i class="icon-comment"></i><a
                                    href="<?php $this->permalink() ?>#comments"
                                    title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a>
                            </li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>


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
</div>
<div class="clear"></div>
<!-- container end -->

<?php include('footer.php'); ?>