<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('FBlogoUrl', NULL, NULL, _t('站点LOGO地址（FB分享时使用）'), _t('在这里填入一个图片URL地址, 以便在Facebook分享网站时使用'));
    $form->addInput($logoUrl);
    $moreLinks = new Typecho_Widget_Helper_Form_Element_Text('moreLinks', NULL, NULL, _t('附加链接'), _t('导航栏附加链接'));
    $form->addInput($moreLinks);
    $leftSidebar = new Typecho_Widget_Helper_Form_Element_Textarea('leftSidebar', NULL, NULL, _t('左边栏模块'), _t('一行一个'));
    $form->addInput($leftSidebar);
    $rightSidebar = new Typecho_Widget_Helper_Form_Element_Textarea('rightSidebar', NULL, NULL, _t('右边栏模块'), _t('一行一个'));
    $form->addInput($rightSidebar);
    $defaultThumb = new Typecho_Widget_Helper_Form_Element_Text('defaultThumb', NULL, _t('https://ooo.0o0.ooo/2017/02/13/58a165406ce28.png'), _t('默认缩略图'), _t('没有设置题图用此框中的图片链接代替，留空为不显示图片(默认图片：https://ooo.0o0.ooo/2017/02/13/58a165406ce28.png)'));
    $form->addInput($defaultThumb);
}


/*
function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $layout->addItem($logoUrl);
}
*/
function is_pjax(){   
    return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];   
}
function is_mobile() {
	$request = Typecho_Request::getInstance();
	return $request->isMobile();
}
function simpx_get_template_by_part($part) {
	$DIR_SEP = DIRECTORY_SEPARATOR;
    $part = ($part == "") ? "" : "-".$part;
    $template = file_exists( dirname(__FILE__).$DIR_SEP.'content'.$part.".php") ? "content".$part.".php" : "content.php";
    return $template;
}
function simpx_get_widget($part) {
	$DIR_SEP = DIRECTORY_SEPARATOR;
	$part = ($part == "") ? "-none" : "-".$part;
	$template = file_exists( dirname(__FILE__).$DIR_SEP.'inc'.$DIR_SEP.'widget'.$part.".php") ? "inc".$DIR_SEP."widget".$part.".php" : "inc".$DIR_SEP."widget-none.php";
	 return $template;
}
function getDayAgo($date){
	$d = new Typecho_Date(Typecho_Date::gmtTime());
	$now = $d->format('Y-m-d H:i:s');
	$post = $date->format('Y-m-d H:i:s');
	$t = strtotime($now) - strtotime($post);
	if($t < 60) return $t . '秒前';
	if($t < 3600) return floor($t / 60) .  '分钟前';
	if($t < 86400) return floor($t / 3670) . '小时前';
	if($t < 604800) return floor($t / 86400) . '天前';
	if($t < 2419200) return floor($t / 604800) .  '周前';
	if($t < 31536000 ) return floor($t / 2592000 ).'月前';
	return floor($t / 31536000 ).'年前';
}
function randomPosts(){
	$defaults = array(
		'number' => 5,
		'before' => '<ul class="list">',
		'after' => '</ul>',
		'xformat' => '<li><a href="{permalink}" title="{title}">{title}</a></li>'
	);
	$db = Typecho_Db::get();
	$sql = $db->select()->from('table.contents')
		->where('status = ?','publish')
		->where('type = ?', 'post')
		->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
		->limit($defaults['number'])
		->order('RAND()');
	$result = $db->fetchAll($sql);
	echo $defaults['before'];
	foreach($result as $val){
		$val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($val);
		echo str_replace(array('{permalink}', '{title}'),array($val['permalink'], $val['title']), $defaults['xformat']);
	}
	echo $defaults['after'];
}
/**
 * Get First Image.
 */
function clearmix_get_first_image($content) {
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	return $matches[1][0];
}
