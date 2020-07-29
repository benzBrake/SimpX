<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 最新发表
 *
 * @package widget
 */
?>
<div class="widget box">
	<h4 class="widget-title">Recent Posts</h4>
	<div class="widget-body recent-posts">
		<ul class="widget-list-breakword">
			<?php $this->widget('Widget_Contents_Post_Recent','pageSize=5') ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
		</ul>
	</div>
</div>