<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 其他工具
 *
 * @package widget
 */
?>

<div class="widget box">
  <h4 class="widget-title"><i class="icon-cog"></i>Other</h4>
  <div class="widget-body">
    <ul class="widget-list">
      <?php if ($this->user->hasLogin()) : ?>
        <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?> (<?php $this->user->screenName(); ?>)</a></li>
        <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
      <?php else : ?>
        <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
      <?php endif; ?>
      <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
    </ul>
  </div>
</div>