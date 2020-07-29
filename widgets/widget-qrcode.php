<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 二维码
 *
 * @package widget
 */
?>
<div class="widget box">
    <h4 class="widget-title">QRCode</h4>
    <div class="widget-body">
        <?php $qrcode = qrcode(str_replace('&', '%26', $this->permalink)); ?>
        <a href="<?php echo $qrcode; ?>" tittle="本页二维码"><img class="qrcode " src="<?php echo $qrcode; ?>" /></a>
    </div>
</div>