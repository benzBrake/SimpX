<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 标签云
 *
 * @package widget
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
  <div class="widget box">
    <h4 class="widget-title">Tags Cloud</h4>
    <div class="widget-body tags-cloud">
	<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=50')->to($tags); ?>
	<?php while($tags->next()): ?>
    <a href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'><?php $tags->name(); ?></a> 
	<?php endwhile; ?>
	</div>
    </div>