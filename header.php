<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=<?php $this->options->charset(); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php $this->options->title(); ?><?php $this->archiveTitle(); ?></title>
<?php $this->header(); ?>
<!-- robots start -->
<meta name="robots" content="index,follow" />
<!-- robots end -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php $this->options->themeUrl('style.css'); ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php $this->options->themeUrl('plugins.css'); ?>" />
<link rel="shortcut icon" href="/favicon.ico" />
<script src="<?php $this->options->themeUrl('/js/tag.js'); ?>"></script>
<script type="text/javascript"> 
    jQuery(document).ready(function($) {
        $(function() {
    function addEditor(a, b, c) {
        if (document.selection) {
            a.focus();
            sel = document.selection.createRange();
            c ? sel.text = b + sel.text + c: sel.text = b;
            a.focus()
        } else if (a.selectionStart || a.selectionStart == '0') {
            var d = a.selectionStart;
            var e = a.selectionEnd;
            var f = e;
            c ? a.value = a.value.substring(0, d) + b + a.value.substring(d, e) + c + a.value.substring(e, a.value.length) : a.value = a.value.substring(0, d) + b + a.value.substring(e, a.value.length);
            c ? f += b.length + c.length: f += b.length - e + d;
            if (d == e && c) f -= c.length;
                a.focus();
                a.selectionStart = f;
                a.selectionEnd = f
            } else {
                a.value += b + c;
                a.focus()
            }
        }
            var g = document.getElementById('comment') || 0;
            var h = {
                strong: function() {
                    addEditor(g, '<strong>', '</strong>')
                },
                em: function() {
                addEditor(g, '<em>', '</em>')
            },
            del: function() {
                addEditor(g, '<del>', '</del>')
            },
            quote: function() {addEditor(g, '<blockquote>', '</blockquote>')},
            Jiong: function() {addEditor(g, '(/ □ \\)')},
            Qie: function() {addEditor(g, 'o(-\"-)o')},
            Huan: function() {addEditor(g, '\\(^o^)/')},
            Yun: function() {addEditor(g, '(+﹏+)~')},
            Yv: function() {addEditor(g, '⊙︿⊙')},
            empty: function(){
                g.value="";g.focus()
            },
        };
        window['SIMPALED'] = {};
        window['SIMPALED']['Editor'] = h
    });
});
</script>
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
<!--[if lt IE 7]>
	<![endif]-->
<!--[if IE 6]>
	<script src="<?php $this->options->themeUrl('/js/DD_belatedPNG.js'); ?>"></script>
	<script>DD_belatedPNG.fix('*');</script>
	<![endif]-->
<!--[if IE]>
	<link rel="stylesheet" media="screen" href="<?php $this->options->themeUrl('ie.css'); ?>" />
	<![endif]-->
<link rel='index' title='<?php $this->options->title() ?>' href='<?php $this->options->siteUrl(); ?>' />
<style type="text/css">.recentcomments a {display:inline !important;padding:0 !important;margin:0 !important;}</style>
</head>
<body>
<!-- wrapper start -->
<div id="wrapper">
  <!-- header start -->
  <div id="header">
    <div class="content">
      <div id="logo">Hi@<a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title() ?>"><?php $this->options->title() ?></a>$su root-</div>
      <div id="nav">
        <ul id="menus">
		  <li<?php if($this->is('index')): ?> class="home current_page_item"<?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><?php _e('Home'); ?></a></li>
		 <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
		 <?php while($pages->next()): ?>
		 <li class="page_item<?php if($this->is('page', $pages->slug)): ?> current_page_item<?php endif; ?>"><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
	   	 <?php endwhile; ?>

        </ul>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <!-- header end -->
  <!-- topbox start -->
  <div id="topbox" class="box">
    <div class="welcome left"> <?php if($this->user->hasLogin()): ?>Welcome back, <a href="<?php $this->options->adminUrl(); ?>"><?php $this->user->screenName(); ?></a>, how about you today. <?php else: ?>Hi, new friend, nice to meet you, welcome to my blog. <?php endif; ?></div>

    <div class="subscribe right">
      <ul>
        <li class="rssfeed"><span><a href="<?php $this->options->feedUrl(); ?>" title="Subscribe RSS Feed"><i class="icon-rss"></i></a></span></li>
        <?php if ($this->options->weibo): ?>
            <li><span><a href="<?php $this->options->weibo() ?>" target="_blank" class="weibo text-hide" data-toggle="tooltip" data-placement="auto" title="关注我的微博">微博</a></li></span>
            <?php endif; ?>
      </ul>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
  <!-- topbox end -->