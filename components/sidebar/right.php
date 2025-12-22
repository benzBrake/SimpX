<?php

/**
 * 右侧边栏模板
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/* @var Widget_Archive $this */
?>

<div id="right-sidebar" class="sidebar">
    <!-- searchform start -->
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowSearchBox', $this->options->sidebarBlock)): ?>
        <div id="search-box" class="box">
            <form action="" method="get">
                <label for="s" class="screen-reader-text">Search for:</label>
                <input type="text" class="search-field" name="s" size="24" value="" />
                <input type="submit" name="button" id="search-submit" value="Search" class="search-button" />
            </form>
        </div>
    <?php endif; ?>
    <!-- searchform end -->
    <!--[if IE 6]>
        <div class="widget">
            <div class="widget-browser">
                <div class="widget-body">
                    <p class="browser">You are using IE 6 right now, we will work better for you if you upgrade to IE 8 or switch to another browser.</p>
                    <a href="https://www.mozilla.com/en-US/" title="Firefox" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/firefox.png'); ?>" width="64" height="64" /></a>&nbsp;
                    <a href="https://www.google.com/chrome" title="Google Chrome" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/chrome.png'); ?>" width="64" height="64" /></a>&nbsp;
                    <a href="https://www.opera.com/" title="Opera" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/opera.png'); ?>" width="64" height="64" /></a>&nbsp;
                    <a href="https://www.apple.com/safari/download/" title="Apple Safari" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/safari.png'); ?>" width="64" height="64" /></a>
                </div>
            </div>
        </div>
        <![endif]-->
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-list"></i>Recent Posts</h3>
            <div class="widget-body recent-posts">
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=6')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
        <?php if ($this->is('index')): ?>
            <div class="widget widget-comments">
                <h3 class="widget-title"><i class="icon-user"></i>Recent Comments</h3>
                <div class="widget-body">
                    <ul>
                        <?php /** @var Widget_Comments_Recent $comments */
                        $this->widget('Widget_Comments_Recent', 'ignoreAuthor=true')->to($comments); ?>
                        <?php while ($comments->next()): ?>
                            <li>
                                <a class="widget-comments-item" href="<?php $comments->permalink(); ?>">
                                    <?php $comments->gravatar(28); ?>
                                    <div class="widget-comments-item-content">
                                        <div class="widget-comments-item-author">
                                            <?php $comments->author(false); ?>
                                        </div>
                                        <div class="widget-comments-item-excerpt">
                                            <?php $comments->excerpt(20, '...'); ?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowTagCloud', $this->options->sidebarBlock)): ?>
        <div class="widget" id="tagCloud">

            <h3 class="widget-title"><i class="icon-tag"></i>Tag Cloud</h3>
            <div class="widget-body">
                <?php /** @var Widget_Metas_Tag_Cloud $tags */
                $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=50')->to($tags); ?>
                <?php while ($tags->next()): ?>
                    <a href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'><?php $tags->name(); ?></a>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>