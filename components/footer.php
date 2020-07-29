<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</div><!-- end .row -->
</div>
</div><!-- end #body -->
<?php if (!is_pjax()) : ?>
        <footer id="footer" role="contentinfo">
                &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.&nbsp;Theme <a href="https://doufu.ru/">SimpX v2</a>.&nbsp;
                <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动'); ?>.
                <div class="fixed-btn">
                        <a id="backtop" href="" title="<?php _e('返回顶部'); ?>" data-track="Footer,Click,BackTop">
                                <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="page-qrcode" title="<?php _e('可以使用手机扫一扫哦'); ?>">
                                <i class="fa fa-qrcode"></i>
                                <div class="qrcode-img">
                                        <img src="<?php echo qrcode(str_replace('&', '%26', $this->permalink)); ?>" />
                                </div>
                        </a>
                </div>
        <?php endif; ?>
        <script src="<?php $this->options->themeUrl('js/jquery-2.0.3.min.js'); ?>"></script>
        <script src="<?php $this->options->themeUrl('js/jquery.pjax.js'); ?>"></script>
        <?php ajaxCommentJs($this); ?>
        <script>
                $("#backtop").click(function() {
                        $('body,html').animate({
                                scrollTop: 0
                        }, 200);
                        return false;
                });
                $(".mobile-menu").click(function() {
                        $("#mobile-menu").toggleClass('hidden');
                });
                $(document).ready(function() {
                        $(document).pjax(':not(#comments) a[href^="<?php Helper::options()->siteUrl() ?>"][rel!=gallery][target!=_blank]:not(a[no-pjax], a[onclick])', {
                                container: "#body",
                                fragment: "#body",
                                timeout: 8000,
                        }).on("pjax:send", function() {
                                // 隐藏导航菜单
                                if (!$("#mobile-menu").hasClass('hidden')) {
                                        $("#mobile-menu").toggleClass('hidden');
                                }
                        }).on("pjax:complete", function() {
                                bindCommentSubmit(); // AJAX 评论
                                if (typeof _hmt !== 'undefined') {
                                        _hmt.push(['_trackPageview', location.pathname + location.search]);
                                }
                        });
                });
        </script>
        </div>
        <?php $this->footer(); ?>
        </footer>
        </body>
        <div class="spinnerContainer">
                <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                </div>
        </div>

        </html>