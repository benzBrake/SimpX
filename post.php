<?php $this->need('header.php'); ?>
<!-- container start -->
<div class="container single">
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
        <?php if ($this->options->topNotice) { ?>
            <div class="notice p-2 box">
                <i class="icon-info"></i>
                <?php $this->options->topNotice() ?>
            </div>
        <?php } ?>
        <div class="post-breadcrumb box">
            <a href="<?php $this->options->index(); ?>" title="<?php _e("回到首页") ?>"><?php _e("首页") ?></a><i class="icon-arrow-right"></i><?php $this->category(','); ?><i class="icon-arrow-right"></i><?php $this->title() ?>
        </div>
        <div class="post box">
            <div class="post-header">
                <h2 class="post-title"><i class="icon-text"></i><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>
                <ul class="post-meta">
                    <li class="meta-date"><i class="icon-calendar"></i><span><?php $this->date(); ?></span></li>
                    <!--li class="meta-views"></li-->
                    <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
                    <li class="meta-comments"><i class="icon-comment"></i><a href="<?php $this->permalink() ?>#comments" title="<?php _e("对《%s》发表评论", $this->title) ?>"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></a></li>
                </ul>
                <?php if ($this->allow('edit')): ?>
                    <a class="post-edit-button" href="<?php $this->options->adminUrl('write-post.php?cid=' . $this->cid) ?>"><i class="icon-pencil"></i></a>
                <?php endif; ?>
            </div>
            <!-- article-page start -->
            <div class="post-content">
                <?php $this->content(); ?>
            </div>
            <div class="post-footer">
                <p class="post-tags"><i class="icon-tag"></i><?php $this->tags(', ', true, _t('Notice: undefined index: 0 in post.php')); ?></p>
            </div>
            <!-- article-page end -->
        </div>
        <div class="post-copyright box">
            <?php $copyright = $this->fields->copyright;
            if (empty($copyright)) { ?>
                <p><?php echo sprintf(_t("文章出自：%s&nbsp;版权所有，本文链接：%s。", "%s", sprintf('<a href="%s" title="%s">%s</a>', $this->permalink, $this->title, $this->title)), sprintf('<a href="%s" title="%s">%s</a>', $this->options->siteUrl, $this->options->title, $this->options->title)); ?></p>
            <?php } else {
                $decoded = json_decode($copyright, true);
                if (is_array($decoded) && count($decoded) > 0) { ?>
                    <p><?php _e("文章参考自，可能有所删改："); ?><span>
                    <?php
                    $links = array();
                    foreach ($decoded as $item) {
                        $url = isset($item['url']) ? $item['url'] : '';
                        $title = isset($item['title']) && $item['title'] !== '' ? $item['title'] : $url;
                        $author = isset($item['author']) && $item['author'] !== '' ? $item['author'] : _t('佚名');
                        if ($url) {
                            $links[] = '<a class="text-break" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</a>' . '（' . htmlspecialchars($author, ENT_QUOTES, 'UTF-8') . '）';
                        } else {
                            $links[] = htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '（' . htmlspecialchars($author, ENT_QUOTES, 'UTF-8') . '）';
                        }
                    }
                    echo implode('；', $links);
                    ?>
                <?php } else { ?>
                    <p>via：<a href="<?php echo htmlspecialchars($copyright, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($copyright, ENT_QUOTES, 'UTF-8'); ?></a>
                <?php } ?>
            <?php } ?>
            <?php _e("本站文章除注明出处外，皆为作者原创文章，可自由引用，但请注明来源。"); ?></p>
        </div>

        <!-- related-posts start -->
        <div class="related-posts box">
            <h2 class="related-post-title"><i class="icon-text"></i><?php _e("相关文章"); ?></h2>
            <ul class="related-posts-list">
                <?php $this->related(5)->to($relatedPosts); ?>
                <?php if ($relatedPosts->have()): ?>
                    <?php while ($relatedPosts->next()): ?>
                        <li><span class="icon"></span><a href="<?php $relatedPosts->permalink(); ?>" title="<?php $relatedPosts->title(); ?>"><?php $relatedPosts->title(); ?></a></li>
                    <?php endwhile; ?>
                <?php else : ?>
                    <li><?php _e("暂无相关文章") ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- related-posts end -->
        <!-- post-navi start -->
        <div class="post-navi box">
            <div class="post-navi-next text-left"><i class="icon-arrow-left"></i><?php $this->theNext(); ?></div>
            <div class="post-navi-prev text-right"><?php $this->thePrev(); ?><i class="icon-arrow-right"></i></div>
            <div class="clear"></div>
        </div>
        <!-- post-navi end -->
        <?php $this->need('comments.php'); ?>
    </div>
    <!-- content end -->
</div>
<div class="clear"></div>
<!-- container end -->
<?php $this->need('footer.php'); ?>