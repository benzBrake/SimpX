<?php include('header.php'); ?>


<!-- container start -->
<div id="container">
    <!-- content START -->
    <div id="content">


        <?php if ($this->is('archive')): ?>
            <div class="posthead box"><?php _e('分类: '); ?><strong><?php $this->category(','); ?></strong></div>
        <?php endif; ?>

        <?php while ($this->next()): ?>
            <div class="post box">
                <div class="post-header">
                    <h2 class="post-title">
                        <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark">
                            <?php $this->title() ?>
                        </a>
                    </h2>
                </div>

                <div class="post-content">
                    <?php $this->excerpt(350, '...'); ?>
                </div>
                <?php if ($this->is('archive')): ?>
                    <div class="post-footer">
                        <?php $this->need("common/post-footer-meta.php"); ?>
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

    <?php include('sidebar.php'); ?>

</div>
<div class="clear"></div>
<!-- container end -->

<?php include('footer.php'); ?>
