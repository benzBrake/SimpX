  <!-- footer start -->
  <div id="footer">
    <div class="content">
      <p><a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title() ?>"><?php $this->options->title() ?></a> is licensed under a <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" title="Creative Commons Attribution 3.0 License" rel="external nofollow">Creative Commons Attribution 3.0 License</a>. <a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章'); ?> RSS</a> and <a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论'); ?> RSS</a>. </p>
      <p>Powered by <a href="http://www.typecho.org" title="typecho.org" rel="external nofollow">Typecho)))</a>. Theme designed by <a href="http://welee.me/" title="weleeTime" rel="external nofollow">weleeTime</a>&<a href="http://32mb.cn" title="逗妇乳">Tammy</a></p>
      <div class="gotop"><a href="#" title="Top">Top</a></div>
    </div>
  </div>
  <!-- footer end -->
</div>
<!-- wrapper end -->

<!-- javascript start -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('js/base.js'); ?>"></script>
<!--baidu share start--> 
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6787278" ></script> 
<script type="text/javascript" id="bdshell_js"></script> 
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script> 
<!--baidu share end-->
<!-- javascript end -->
<?php $this->footer(); ?>
<?php
if ($this->is('single')) {
    Helper::threadedCommentsScript();
}
?>
</body>
</html>