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
        <div class="posthead box"><a href="/" title="Back to Home">Home</a> <i class="icon-arrow-right"></i> <?php _e('Page: '); ?><strong><?php $this->title() ?></strong></div>

        <div class="post box">
            <div class="post-header">
                <h2 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>

                <div class="postmeta">
                    <ul>
                        <li class="meta-date"><?php $this->date('F j, Y'); ?></li>
                        <li class="meta-comments"><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
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

<?php include('footer.php'); ?>