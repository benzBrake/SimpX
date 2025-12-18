<?php
function getPermalinkFromCoid($coid) {   
    $db       = Typecho_Db::get();   
    $options  = Typecho_Widget::widget('Widget_Options');   
    $contents = Typecho_Widget::widget('Widget_Abstract_Contents');   
    
    $row = $db->fetchRow($db->select('cid, type, author, text')->from('table.comments')   
              ->where('coid = ? AND status = ?', $coid, 'approved'));   
    
    if (empty($row)) return 'Comment not found!';   
    $cid = $row['cid'];   
    
    $select = $db->select('coid, parent')->from('table.comments')   
              ->where('cid = ? AND status = ?', $cid, 'approved')->order('coid');   
    
    if ($options->commentsShowCommentOnly)   
        $select->where('type = ?', 'comment');   
    
    $comments = $db->fetchAll($select);   
    
    if ($options->commentsOrder == 'DESC')   
        $comments = array_reverse($comments);   
    
    foreach ($comments as $key => $val)   
        $array[$val['coid']] = $val['parent'];   
    
    $i = $coid;   
    while ($i != 0) {   
        $break = $i;   
        $i = $array[$i];   
    }   
    
    $count = 0;   
    foreach ($array as $key => $val) {   
        if ($val == 0) $count++;    
        if ($key == $break) break;    
    }   
    
    $parentContent = $contents->push($db->fetchRow($contents->select()->where('table.contents.cid = ?', $cid)));   
    $permalink = rtrim($parentContent['permalink'], '/');   
    
    $page = ($options->commentsPageBreak)   
          ? '/comment-page-' . ceil($count / $options->commentsPageSize)   
          : ( substr($permalink, -5, 5) == '.html' ? '' : '/' );   
    
    return array(   
        "author" => $row['author'],   
        "text" => $row['text'],   
        "href" => "{$permalink}{$page}#{$row['type']}-{$coid}"  
    );   
}      
function themeConfig($form) {
        echo('<style>body{font-family:Microsoft Yahei,微软雅黑;}</style><div style="font-size:14px;border-left:5px solid #0093f0;padding-left:8px;"><h2>SimpX</h2>&nbsp;Theme&nbsp;版本：1.5&nbsp;&nbsp;<strong>主题设置页</strong>&nbsp;&nbsp;<a href="http://doufu.ru/typecho-theme-simpx.html" title="检查更新">检查更新</a></div>');
	$topNotice = new Typecho_Widget_Helper_Form_Element_Text('topNotice', NULL, NULL, _t('顶部公告'), _t('这里可以输入一段文字显示顶部公告。（留空为不显示）'));
	$form->addInput($topNotice);
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