<!-- sidebar start -->

<div id="right-sidebar" class="sidebar">
  <!-- searchform start -->
  <?php if (empty($this->options->sidebarBlock) || in_array('ShowSearchBox', $this->options->sidebarBlock)): ?>
  <div id="searchbox" class="box">
    <form action="" method="get">
      <input type="text" class="searchfield" name="s" size="24" value="" />
      <input type="submit" name="button" id="searchsubmit" value="Search" class="searchbutton" />
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
    <h3 class="widget-title"><i class="icon-list"></i>Recent Posts</h3>
  <div class="widget-body recent-posts">
    <ul>
                <?php $this->widget('Widget_Contents_Post_Recent','pageSize=6') ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
    </ul>
  </div>
  </div>
  <?php endif; ?>
  <?php if (empty($this->options->sidebarBlock) || in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
  <?php if($this->is('index')): ?>
  <div class="widget">
    <h3 class="widget-title"><i class="icon-user"></i>Recent Comments</h3>
 <div class="widget-body">
    <ul>
	        <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true')->to($comments); ?>
            <?php while($comments->next()): ?>
                <li><a href="<?php $comments->permalink(); ?>">
<?php
$u = Helper::options()->siteUrl;
$p = 'usr/img/avatar/';
$d = $u . $p . 'default.jpg';
$t = 1209600; // 設定: 14 天, 單位: 秒
$f = md5(strtolower($comments->mail));
$a = $u . $p . $f . '.jpg';
$e = __TYPECHO_ROOT_DIR__ . '/' . $p . $f . '.jpg';
if ( !is_file($e) || (time() - filemtime($e)) > $t ){//當頭像不存在或文件超過14天才更新
  $g = 'http://www.gravatar.com/avatar/' . $f . '?s=32&d=' . $d . '&r=X';
  copy($g, $e); $a = htmlspecialchars($g);
}
if ( filesize($e) < 500 ) copy($d, $e);
?>
<img class="avatar" src="<?php echo $a ?>" alt="" title="<?php echo $comments->author; ?>"/><?php $comments->author(false); ?>：</br><?php $comments->excerpt(10, '...'); ?></a></li>
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
	<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=50')->to($tags); ?>
	<?php while($tags->next()): ?>
    <a href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'><?php $tags->name(); ?></a> 
	<?php endwhile; ?>
	</div>
    </div>
<?php endif; ?>
</div>
<div id="left-sidebar" class="sidebar">
  <?php if (empty($this->options->sidebarBlock) || in_array('ShowCategory', $this->options->sidebarBlock)): ?>
  <div class="widget">
    <h3 class="widget-title"><i class="icon-layout"></i><?php _e('Categories'); ?></h3>
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
    <h3 class="widget-title"><i class="icon-users"></i>Friends</h3>
    <div class="widget-body">
    <ul>
	<?php Links_Plugin::output(); ?>
    </ul>
    </div>
  </div>
<?php endif; ?>
<?php if (empty($this->options->sidebarBlock) || in_array('ShowArchive', $this->options->sidebarBlock)): ?>
  <div class="widget">
    <h3 class="widget-title"><i class="icon-calendar"></i>Archives</h3>
    <div class="widget-body">
    <ul>
                <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y')
                ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
    </ul>
    </div>
  </div>
<?php endif; ?>
<?php if (empty($this->options->sidebarBlock) || in_array('ShowOther', $this->options->sidebarBlock)): ?>
  <div class="widget">
    <h3 class="widget-title"><i class="icon-cog"></i>Other</h3>
    <div class="widget-body">
    <ul>
                <?php if($this->user->hasLogin()): ?>
					<li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?> (<?php $this->user->screenName(); ?>)</a></li>
                    <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
    </ul>
  </div>
  </div>
<?php endif; ?>
</div>
<!-- sidebar end -->