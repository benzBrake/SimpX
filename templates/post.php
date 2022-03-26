<?php $this->need('header.php'); ?>


    <!-- container start -->
    <div id="container">
        <!-- content start -->
        <div id="content">

            <div class="posthead box">
                <a href="/" title="Back to Home"><?php _e("首页"); ?></a><i
                    class="icon-arrow-right"></i> <?php $this->category(','); ?><i
                    class="icon-arrow-right"></i> <?php $this->title() ?></div>

            <div class="post box">
                <div class="post-header">
                    <h1 class="post-title"><a
                            href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a>
                    </h1>
                    <?php $this->need("common/post-header-meta.php"); ?>
                </div>
                <!-- article-page start -->
                <div class="post-content">
                    <?php $this->content(); ?>
                </div>
                <div class="post-footer">
                    <p class="post-tags"><?php $this->tags(', ', true, ''); ?></p>
                </div>
                <!-- article-page end -->
            </div>
            <div class="post-copyright box">
                <?php $reprinted = $this->fields->reprinted;
                if (empty($reprinted)) { ?>
                <p>文章出自：<a href="<?php $this->options->siteUrl(); ?>"
                           title="<?php $this->options->title(); ?>"><?php $this->options->title(); ?></a>版权所有。
                    <?php } else { ?>
                <p>via：<a href="<?php echo $reprinted; ?>"><?php echo $reprinted; ?></a>
                    <?php } ?>
                    。本站文章除注明出处外，皆为作者原创文章，可自由引用，但请注明来源。</p>
            </div>

            <!-- related-posts start -->
            <?php $this->need("common/post-related.php"); ?>
            <!-- related-posts end -->

            <!-- postnavi start -->
            <div class="postnavi box">
                <p class="prev right"><?php $this->thePrev(); ?><i class="icon-arrow-right"></i></p>
                <p class="next left"><i class="icon-arrow-left"></i><?php $this->theNext(); ?></p>
                <div class="clearfix"></div>
            </div>
            <!-- postnavi end -->

            <?php $this->need('comments.php'); ?>

        </div>
        <!-- content end -->
        <?php $this->need('sidebar.php'); ?>
    </div>
    <!-- container end -->
<?php $this->need('footer.php'); ?>
