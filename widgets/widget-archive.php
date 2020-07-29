<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 日期归档
 *
 * @package widget
 */
?>
<div class="widget box">
  <h4 class="widget-title">Archives</h4>
  <div class="widget-body">
    <ul class="widget-list">
      <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y')
        ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
    </ul>
  </div>
</div>