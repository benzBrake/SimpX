<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=<?php $this->options->charset(); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <title><?php $this->options->title(); ?><?php $this->archiveTitle(); ?>
        &nbsp;-&nbsp;<?php $this->options->description() ?></title>
    <?php $this->header(); ?>
    <!-- robots start -->
    <meta name="robots" content="index,follow"/>
    <!-- robots end -->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo XCore::themeUrl('assets/css/reset.css'); ?>"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo XCore::themeUrl('assets/css/style.css'); ?>"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo XCore::themeUrl('assets/css/font.css'); ?>"/>
    <link rel="shortcut icon" href="<?php echo XCore::getFavicon(); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo XCore::themeUrl('assets/js/css3-mediaqueries.js'); ?>"></script>
	<![endif]-->
    <!--[if lt IE 7]>
    <![endif]-->
    <!--[if IE 6]>
	<script src="<?php echo XCore::themeUrl('assets/js/DD_belatedPNG.js'); ?></script>
	<script>DD_belatedPNG.fix('*');</script>
	<![endif]-->
    <!--[if IE]>
	<link rel="stylesheet" media="screen" href="<?php echo XCore::themeUrl('assets/css/ie.css'); ?>" />
	<![endif]-->
    <link rel='index' title='<?php $this->options->title() ?>' href='<?php $this->options->siteUrl(); ?>'/>
    <style type="text/css">.recentcomments a {
            display: inline !important;
            padding: 0 !important;
            margin: 0 !important;
        }</style>
</head>
<body>
<!-- wrapper start -->
<div id="wrapper">
    <!-- header start -->
    <div id="header">
        <div class="content">
            <div id="logo">Hi@<a href="<?php $this->options->siteUrl(); ?>"
                                 title="<?php $this->options->title() ?>"><?php $this->options->title() ?></a>$su root-
            </div>
            <div id="nav">
                <ul class="main-menu">
                    <?php if ($this->is('post')): ?>
                        <li class="current"><a href=""><?php _e("正文"); ?></a></li>
                    <?php endif; ?>
                    <li<?php if ($this->is('index')): ?> class="home current"<?php endif; ?>><a
                            href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a></li>
                    <li class="pages has-dropdown<?php if ($this->is('page')): ?> current<?php endif; ?>">
                        <a href="#" /><?php _e("页面"); ?></a>
                        <ul class="dropdown">
                            <?php /** @var $pages */
                            $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php while ($pages->next()): ?>
                                <li class="page_item<?php if ($this->is('page', $pages->slug)): ?> current<?php endif; ?>">
                                    <a href="<?php $pages->permalink(); ?>"
                                       title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </li>

                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- header end -->
    <!-- topbox start -->
    <div id="topbox" class="box">
        <div class="welcome left"> <?php if ($this->user->hasLogin()): ?>Welcome back, <a
                href="<?php $this->options->adminUrl(); ?>"><?php $this->user->screenName(); ?></a>, how about you today. <?php else: ?>Hi, new friend, nice to meet you, welcome to my blog. <?php endif; ?>
        </div>

        <div class="subscribe right">
            <ul>
                <li class="rssfeed"><span><a href="<?php $this->options->feedUrl(); ?>" title="Subscribe RSS Feed"><i
                                class="icon-rss"></i></a></span></li>
                <?php if ($this->options->weibo): ?>
                    <li>
                        <span>
                            <a href="<?php $this->options->weibo() ?>" target="_blank" class="weibo text-hide"
                                 data-toggle="tooltip" data-placement="auto" title="关注我的微博"><?php _e("微博"); ?></a></li></span>
                <?php endif; ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- topbox end -->
