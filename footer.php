<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->
<?php if(!is_pjax()): ?>
<footer id="footer" role="contentinfo">
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.&nbsp;Theme SimpX v2.&nbsp;
    <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动'); ?>.
		<div class="fixed-btn">
		<a id="backtop" href="" title="<?php _e('返回顶部'); ?>" data-track="Footer,Click,BackTop">
			<i class="fa fa-chevron-up"></i>
		</a>
		<a class="page-qrcode" title="<?php _e('可以使用手机扫一扫哦'); ?>">
			<i class="fa fa-qrcode"></i>
			<div class="qrcode-img">
				<img src="http://qr.liantu.com/api.php?w=128&m=10&inpt=00BCD4&fg=00BCD4& pt=00BEEE&text=<?php echo str_replace('&','%26',$this->permalink); ?>" />
			</div>
		</a>
		</div>
<?php endif; ?>
		<script src="//upcdn.b0.upaiyun.com/libs/jquery/jquery-2.0.3.min.js"></script>
		<script src="<?php $this->options->themeUrl('jquery.pjax.js'); ?>"></script>
<script>
$("#backtop").click(function () {
        $('body,html').animate({ scrollTop: 0 }, 200);
        return false;
 });
$(".mobile-menu").click(function () {
        $('#site-menu').toggle(300,function() {
                $('#site-menu').toggleClass('mobile');
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