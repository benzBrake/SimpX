<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" debug="true">

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=<?php $this->options->charset(); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title><?php $this->options->title(); ?><?php $this->archiveTitle(); ?>
        &nbsp;-&nbsp;<?php $this->options->description() ?></title>
    <?php $this->header(); ?>
    <!-- robots start -->
    <meta name="robots" content="index,follow" />
    <!-- robots end -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen"
        href="<?php $this->options->themeUrl('assets/css/style.css'); ?>" />
    <link rel="stylesheet" type="text/css" media="screen"
        href="<?php $this->options->themeUrl('assets/css/plugins.css'); ?>" />
    <link rel="stylesheet" type="text/css" media="screen"
        href="<?php $this->options->themeUrl('assets/css/tip-twitter.min.css'); ?>" />
    <!--[if lt IE 9]>
    <script src="<?php $this->options->themeUrl('/assets/js/css3-mediaqueries.min.js'); ?>">"></script>
    <![endif]-->
    <!--[if lt IE 7]>
    <![endif]-->
    <script>
        var SimpX = {
            "assets": {
                "js": "<?php $this->options->themeUrl('assets/js/'); ?>",
                "css": "<?php $this->options->themeUrl('assets/css/'); ?>"
            }
        }
    </script>
    <link rel='index' title='<?php $this->options->title() ?>' href='<?php $this->options->siteUrl(); ?>' />
</head>

<body>
    <!-- header start -->
    <div id="header" data-fixed>
        <div class="container">
            <div id="logo">Hi@<a href="<?php $this->options->siteUrl(); ?>"
                    title="<?php $this->options->title() ?>"><?php $this->options->title() ?></a>$su root-
            </div>
            <ul class="nav-menu">
                <li class="nav-item<?php if ($this->is('index')): ?> nav-item-active<?php endif; ?>">
                    <a href="<?php $this->options->siteUrl(); ?>" class="nav-link"><?php _e('首页'); ?></a>
                </li>
                <li class="nav-item nav-item-has-dropdown<?php if ($this->is('category')): ?> nav-item-active<?php endif; ?>">
                    <a href="javascript:void(0)" class="nav-link"><?php _e("分类"); ?><span class="nav-arrow">▼</span></a>
                    <ul class="nav-dropdown">
                        <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
                        <?php while ($categories->next()): ?>
                            <li class="nav-item<?php if ($this->is('category', $categories->slug)): ?> nav-item-active<?php endif; ?>">
                                <a href="<?php $categories->permalink(); ?>" class="nav-link" title="<?php $categories->name(); ?>"><?php $categories->name(); ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while ($pages->next()): ?>
                    <li class="nav-item<?php if ($this->is('page', $pages->slug)): ?> nav-item-active<?php endif; ?>">
                        <a href="<?php $pages->permalink(); ?>" class="nav-link" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <!-- header end -->
    <div id="wrapper" class="<?php $status = getSiderbarStatus();
                                echo $status->wrapperClass ?>">
        <!-- container start-->
        <div class="container">
            <!-- top-box start -->
            <div id="top-box" class="box p-1">
                <div class="welcome inline-block float-left"> <?php if ($this->user->hasLogin()): ?><?php _e("Welcome back, %s, , how about you today.", sprintf('<a href="%s">%s</a>', $this->options->adminUrl, $this->user->screenName)) ?><?php else: ?><?php _e("Hi, new friend, nice to meet you, welcome to my blog"); ?>.<?php endif; ?>
                </div>
                <ul class="connections float-right">
                    <li class="rss-feed"><a class="has-tooltip" href="<?php $this->options->feedUrl(); ?>" title="<?php _e("订阅 RSS Feed"); ?>"><i
                                class="icon-rss"></i></a></li>
                    <?php if ($this->options->weibo): ?>
                        <li><span><a class="has-tooltip" href="<?php $this->options->weibo() ?>" target="_blank" class="weibo"
                                    data-toggle="tooltip" data-placement="auto" title="<?php _e("关注我的微博"); ?>"></a></li></span>
                    <?php endif; ?>
                </ul>
                <div class="clear"></div>
            </div>
            <!-- top-box end -->