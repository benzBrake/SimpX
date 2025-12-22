<?php $this->need('header.php'); ?>


<!-- container start -->
<div class="container">
    <!-- content start -->
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
        <div class="posthead box">
            <a href="/" title="Back to Home">Home</a> <i class="icon-arrow-right"></i> <?php $this->category(','); ?> <i class="icon-arrow-right"></i> <?php $this->title() ?>
        </div>

        <div class="post box">
            <div class="post-header">
                <h1 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h1>
                <div class="post-meta">
                    <ul>
                        <li class="meta-date"><i class="icon-calendar"></i><?php $this->date('F j, Y'); ?></li>
                        <!--li class="meta-views"></li-->
                        <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
                        <li class="meta-comments"><i class="icon-comment"></i><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
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
                <p class="post-tags"><?php $this->tags(', ', true, 'none'); ?></p>
            </div>
            <!-- article-page end -->
        </div>
        <div class="post-copyright box">
            <?php $reprinted = $this->fields->reprinted;
            if (empty($reprinted)) { ?>
                <p>文章出自：<a href="<?php $this->options->siteUrl(); ?>" title="32MB.CN"><?php $this->options->title(); ?></a>版权所有。
                <?php } else { ?>
                <p>via：<a href="<?php echo $reprinted; ?>"><?php echo $reprinted; ?></a>
                <?php } ?>
                。本站文章除注明出处外，皆为作者原创文章，可自由引用，但请注明来源。</p>
        </div>

        <!-- related-posts start -->
        <div class="related-posts box">
            <h2 class="related_post_title">Related Posts</h2>
            <ul class="related_post">
                <?php $this->related(5)->to($relatedPosts); ?>
                <?php if ($relatedPosts->have()): ?>
                    <?php while ($relatedPosts->next()): ?>
                        <li><a href="<?php $relatedPosts->permalink(); ?>" title="<?php $relatedPosts->title(); ?>"><?php $relatedPosts->title(); ?></a></li>
                    <?php endwhile; ?>
                <?php else : ?>
                    <li>No Related Post</li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- related-posts end -->
        <!-- postnavi start -->
        <div class="postnavi box">
            <p class="prev right"><?php $this->thePrev(); ?><i class="icon-arrow-right"></i></p>
            <p class="next left"><i class="icon-arrow-left"></i><?php $this->theNext(); ?></p>
            <div class="clear"></div>
        </div>
        <!-- postnavi end -->
        <?php $this->need('comments.php'); ?>
    </div>
    <!-- content end -->
</div>
<div class="clear"></div>
<!-- container end -->

<?php $this->need('footer.php'); ?>