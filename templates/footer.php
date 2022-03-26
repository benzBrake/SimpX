<div class="clearfix"></div>
<!-- footer start -->
<div id="footer">
    <div class="content">
        <p><a href="<?php $this->options->siteUrl(); ?>"
              title="<?php $this->options->title() ?>"><?php $this->options->title() ?></a> is licensed under a <a
                href="http://creativecommons.org/licenses/by-nc-sa/3.0/"
                title="Creative Commons Attribution 3.0 License" rel="external nofollow">Creative Commons Attribution
                3.0 License</a>. <a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章'); ?> RSS</a> and <a
                href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论'); ?> RSS</a>. </p>
        <p>Powered by <a href="http://www.typecho.org" title="typecho.org" rel="external nofollow">Typecho)))</a>. Theme
            designed by <a href="http://welee.me/" title="weleeTime" rel="external nofollow">weleeTime</a>&<a
                href="https://32mb.cc" title="<?php _e("逗妇乳"); ?>"><?php _e("逗妇乳"); ?></a></p>
        <div class="gotop"><a href="#" title="Top">Top</a></div>
    </div>
</div>
<!-- footer end -->
</div>
<!-- wrapper end -->

<!-- javascript start -->
<script src="<?php echo XCore::themeUrl('assets/js/jquery-1.9.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo XCore::themeUrl('assets/js/base.js'); ?>"></script>
<!-- javascript end -->
<?php $this->footer(); ?>
</body>
</html>
