<?php
function themeConfig($form) {
    $topNotice = new Typecho_Widget_Helper_Form_Element_Text('topNotice', NULL, NULL, _t('顶部公告'), _t('这里可以输入一段文字显示顶部公告。（留空为不显示）'));
    $form->addInput($topNotice);
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('OnlyShowIcon' => _t('小工具标题只显示图标'),
    'ShowSearchBox' => _t('显示搜索工具'),
    'ShowRecentPosts' => _t('显示最新文章'),
    'ShowRecentComments' => _t('显示最近回复'),
    'ShowTagCloud' => _t('显示标签云'),
    'ShowCategory' => _t('显示分类'),
    'ShowArchive' => _t('显示归档'),
    'ShowOther' => _t('显示其它杂项'),
    'ShowBlogroll' => _t('显示友情链接')),
    array('OnlyShowIcon','ShowRecentPosts', 'ShowRecentComments','ShowTagCloud', 'ShowCategory', 'ShowArchive',), _t('边栏选项'));  
    $form->addInput($sidebarBlock->multiMode());
}