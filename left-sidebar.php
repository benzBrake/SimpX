<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if (!is_pjax()  && !is_mobile()): ?>
<div id="left-sidebar" class="sidebar floatleft" role="complementary">
		<?php if(isset($this->options->leftSidebar)) {
			$widgets = explode("\r\n",$this->options->leftSidebar);
			foreach($widgets as $widget) {
				$this->need(simpx_get_widget($widget));
			}
		} ?>
</div>
<?php endif; ?>