<?php
function themeConfig($form) {
	$topNotice = new Typecho_Widget_Helper_Form_Element_Text('topNotice', NULL, NULL, _t('顶部公告'), _t('这里可以输入一段文字显示顶部公告。（留空为不显示）'));
	$form->addInput($topNotice);
	$tongji = new Typecho_Widget_Helper_Form_Element_Text('tongji', NULL, NULL, _t('统计代码'), _t('在这里填入统计代码，此处填入的代码不统计id=1的用户的访问量。'));
	$form->addInput($tongji);
	$sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
	array('ShowSearchBox' => _t('显示搜索工具'),
	'ShowRecentPosts' => _t('显示最新文章'),
	'ShowRecentComments' => _t('显示最近回复'),
	'ShowTagCloud' => _t('显示标签云'),
	'ShowCategory' => _t('显示分类'),
	'ShowArchive' => _t('显示归档'),
	'ShowOther' => _t('显示其它杂项'),
	'ShowBlogroll' => _t('显示友情链接'),
	'ShowQRCode' => _t('显示二维码')),
	array('ShowRecentPosts', 'ShowRecentComments','ShowTagCloud', 'ShowCategory', 'ShowArchive','ShowQRCode',), _t('边栏选项'));  
	$form->addInput($sidebarBlock->multiMode());
}