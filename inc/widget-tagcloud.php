<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
  <div class="widget box" id="tagCloud">
    <h4 class="widget-title">Tag Cloud</h4>
    <div class="widget-body">
	<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=50')->to($tags); ?>
	<?php while($tags->next()): ?>
    <a href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'><?php $tags->name(); ?></a> 
	<?php endwhile; ?>
	</div>
    </div>