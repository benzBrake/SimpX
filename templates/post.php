<?php $this->need('header.php'); ?>


    <!-- container start -->
    <div id="container">
        <!-- content start -->
        <div id="content">

            <div class="posthead box">
                <a href="/" title="Back to Home"><?php _e("首页"); ?></a> <i
                    class="icon-arrow-right"></i> <?php $this->category(','); ?> <i
                    class="icon-arrow-right"></i> <?php $this->title() ?>                </div>

            <div class="post box">
                <div class="post-header">
                    <h1 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"
                                              rel="bookmark"><?php $this->title() ?></a></h1>
                    <div class="post-header-meta">
                        <ul>
                            <li class="meta-date"><i class="icon-calendar"></i><?php $this->date('Y-m-d'); ?></li>
                            <!--li class="meta-views"></li-->
                            <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
                            <li class="meta-comments"><i class="icon-comment"></i><a
                                    href="<?php $this->permalink() ?>#comments"
                                    title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('无评论', '1 条评论', '%d 条评论'); ?></a>
                            </li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <!-- article-page start -->
                <div class="post-content">
                    <?php $this->content(); ?>
                    <div class="clear"></div>
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
            <div class="related-posts box">
                <h2 class="related_post_title"><?php _e("您可能感兴趣"); ?></h2>
                <ul class="related_post">
                    <?php $this->related(5)->to($relatedPosts); ?>
                    <?php if ($relatedPosts->have()): ?>
                        <?php while ($relatedPosts->next()): ?>
                            <li><a href="<?php $relatedPosts->permalink(); ?>"
                                   title="<?php $relatedPosts->title(); ?>"><?php $relatedPosts->title(); ?></a></li>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <li><?php _e("无"); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
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
