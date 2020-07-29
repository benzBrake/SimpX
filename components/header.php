<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js">

<head>
	<title><?php $this->archiveTitle(array(
				'category'  =>  _t('Category: %s'),
				'search'	=>  _t('包含关键字 %s 的文章'),
				'tag'	   =>  _t('标签 %s 下的文章'),
				'author'	=>  _t('%s 发布的文章')
			), '', ' - '); ?><?php $this->options->title(); ?></title>
	<meta charset="<?php $this->options->charset(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">>
	<!-- 使用url函数转换相关路径 -->
	<link rel="stylesheet" href="http://cdn.staticfile.org/normalize/2.1.3/normalize.min.css">
	<link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
	<link rel="stylesheet" href="<?php $this->options->themeUrl('css/grid.css'); ?>">
	<link rel="stylesheet" href="<?php $this->options->themeUrl('fonts/font-awesome.min.css'); ?>">

	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- 通过自有函数输出HTML头部信息 -->
	<?php $this->header('commentReply=&keywords=&description='); ?>
</head>

<body>
	<!--[if lt IE 8]>
	<div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->

	<header id="header" class="bg-info clearfix">
		<div class="site-name">
			<a id="logo" href="<?php $this->options->siteUrl(); ?>">
				<?php if ($this->options->logoUrl) : ?>
					<img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" />
				<?php endif; ?>
				<?php $this->options->title() ?>
			</a>
		</div>
		<?php $this->need('components/navbar.php'); ?>
	</header><!-- end #header -->
	<div id="body">
		<div class="container wp">
			<div class="row">