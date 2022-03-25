<!-- sidebar start -->

<div id="right-sidebar" class="sidebar">
    <!-- searchform start -->
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowSearchBox', $this->options->sidebarBlock)): ?>
        <div id="searchbox" class="box">
            <form action="" method="get">
                <input type="text" class="searchfield" name="s" size="24" value=""/>
                <input type="submit" name="button" id="searchsubmit" value="Search" class="searchbutton"/>
            </form>
        </div>
    <?php endif; ?>
    <!-- searchform end -->
    <!--[if IE 6]>
				<div class="widget">
				<div class="widget-browser">
				<div class="widget-body">
					<p class="browser">You are using IE 6 right now, we will work better for you if you upgrade to IE 8 or switch to another browser.</p>
					<a href="http://www.mozilla.com/en-US/" title="Firefox" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/firefox.png'); ?>" width="64" height="64" /></a>&nbsp;
					<a href="http://www.google.com/chrome" title="Google Chrome" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/chrome.png'); ?>" width="64" height="64" /></a>&nbsp;
					<a href="http://www.opera.com/" title="Opera" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/opera.png'); ?>" width="64" height="64" /></a>&nbsp;
					<a href="http://www.apple.com/safari/download/" title="Apple Safari" rel="external nofollow"><img src="<?php $this->options->themeUrl('img/safari.png'); ?>" width="64" height="64" /></a>
				</div>
				</div>
				</div>
				<![endif]-->
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-list"></i><?php _e("最新发表"); ?></h3>
            <div class="widget-body recent-posts">
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Recent')->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
        <?php if ($this->is('index')): ?>
            <div class="widget">
                <h3 class="widget-title"><i class="icon-user"></i><?php _e("最新评论"); ?></h3>
                <div class="widget-body">
                    <ul>
                        <?php /** @var $comments */
                        $this->widget('Widget_Comments_Recent', 'ignoreAuthor=true')->to($comments); ?>
                        <?php while ($comments->next()): ?>
                            <li><a href="<?php $comments->permalink(); ?>">
                                    <?php XCore::gravatar($comments->mail); ?>
                                    <?php $comments->author(false); ?>：</br><?php $comments->excerpt(10, '...'); ?>
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

            <h3 class="widget-title"><i class="icon-tag"></i><?php _e("标签云"); ?></h3>
            <div class="widget-body">
                <?php /** @var $tags */
                $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=50')->to($tags); ?>
                <?php while ($tags->next()): ?>
                    <a class="color<?php echo mt_rand(0, 6); ?> size<?php echo mt_rand(0, 6); ?> weight<?php echo mt_rand(0, 6); ?>"
                       href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'><?php $tags->name(); ?></a>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<div id="left-sidebar" class="sidebar">
    <?php if (DIRECTORY_SEPARATOR === '/'): ?>
    <div class="widget tz">
        <h3 class="widget-title"><i class="icon-layout"></i><?php _e('探针'); ?></h3>

        <div class="widget-body">
            <div class="ram">
                <?php $fh = fopen('/proc/meminfo', 'r');
                $memTotal = 0;
                $memUsed = 0;
                $memAvailable = 0;
                while ($line = fgets($fh)) {
                    $pieces = array();
                    if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                        $memTotal = $pieces[1];
                    }
                    if (preg_match('/^MemAvailable:\s+(\d+)\skB$/', $line, $pieces)) {
                        $memAvailable = $pieces[1];
                    }
                }
                $memUsed = $memTotal - $memAvailable;
                fclose($fh); ?>
                <div><?php echo (int) ($memUsed / 1024) ?> MB / <?php echo $memTotal / 1024 ?> MB</div>
                <div class="total" >
                    <div class="usage" style="width: <?php echo $memUsed / $memTotal * 100; ?>%"></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-layout"></i><?php _e('分类'); ?></h3>
            <div class="widget-body">
                <ul>
                    <?php $this->widget('Widget_Metas_Category_List')
                        ->parse('<li><a href="{permalink}">{name}</a></li>'); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowBlogroll', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-users"></i><?php _e("友情链接"); ?></h3>
            <div class="widget-body">
                <ul>
                    <?php if (XCore::isPluginEnabled('Links')): ?>
                        <?php Links_Plugin::output(); ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowArchive', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-calendar"></i><?php _e("归档"); ?></h3>
            <div class="widget-body">
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y-m')
                        ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowQRCode', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-earth"></i><?php _e("拿起手机扫一扫"); ?></h3>
            <div class="widget-body">
                <img class="qrcode " src="<?php echo XCore::getQRCodeUrl($this->permalink); ?>"/>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowOther', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-cog"></i>Other</h3>
            <div class="widget-body">
                <ul>
                    <?php if ($this->user->hasLogin()): ?>
                        <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?>
                                (<?php $this->user->screenName(); ?>)</a></li>
                        <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                    <?php else: ?>
                        <li class="last"><a
                                href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- sidebar end -->
