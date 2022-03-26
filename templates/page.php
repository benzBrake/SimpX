<?php include('header.php'); ?>


<!-- container start -->
<div id="container">
    <!-- content START -->
    <div id="content">
        <div class="posthead box"><a href="/" title="Back to Home"><?php _e("首页"); ?></a> <i
                class="icon-arrow-right"></i> <?php _e('页面: '); ?><strong><?php $this->title() ?></strong></div>

        <div class="post box">
            <div class="post-header">
                <h2 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"
                                          rel="bookmark"><?php $this->title() ?></a></h2>

                <?php $this->need("common/post-header-meta.php"); ?>
            </div>

            <div class="post-content">
                <?php $this->content(); ?>
            </div>
        </div>


        <?php $this->need('comments.php'); ?>

    </div>
    <!-- content END -->

    <?php include('sidebar.php'); ?>

</div>
<!-- container end -->

<?php include('footer.php'); ?>
