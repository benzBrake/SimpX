<?php
/**
 * 左侧边栏模板
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/* @var Widget_Archive $this */
?>

<div id="left-sidebar" class="sidebar">
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-layout"></i><?php _e('Categories'); ?></h3>
            <div class="widget-body">
                <ul>
                    <?php $this->widget('Widget_Metas_Category_List')
                        ->parse('<li><a href="{permalink}">{name}</a></li>'); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isPluginEnabled('Links')): ?>
        <?php if (empty($this->options->sidebarBlock) || in_array('ShowBlogroll', $this->options->sidebarBlock)): ?>
            <div class="widget">
                <h3 class="widget-title"><i class="icon-users"></i>Friends</h3>
                <div class="widget-body">
                    <ul>
                        <?php Links_Plugin::output(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowArchive', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-calendar"></i>Archives</h3>
            <div class="widget-body">
                <ul>
                    <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y')
                        ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowQRCode', $this->options->sidebarBlock)): ?>
        <div class="widget widget-qrcode">
            <h3 class="widget-title"><i class="icon-earth"></i>QRCode</h3>
            <div class="widget-body">
                <img class="qrcode"
                    src="<?php echo Typecho_Common::url('?qrcode&text=' . $this->permalink, $this->options->index) ?>" />
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($this->options->sidebarBlock) || in_array('ShowOther', $this->options->sidebarBlock)): ?>
        <div class="widget">
            <h3 class="widget-title"><i class="icon-forward"></i>Other</h3>
            <div class="widget-body">
                <ul>
                    <?php if ($this->user->hasLogin()): ?>
                        <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?>
                                (<?php $this->user->screenName(); ?>)</a></li>
                        <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                    <?php else: ?>
                        <li class="last"><a
                                href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>