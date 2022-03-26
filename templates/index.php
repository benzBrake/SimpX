<?php
/**
 * 一款淡蓝主题，采用了高大上的字体图标(ie 6 不支持图标字体)。
 * (Theme designed by weleeTime. Mod By Ryan)
 * @package SimpX
 * @author Tammy
 * @version 0.1.4
 * @link http://32mb.cn
 */

$this->need('header.php');
?>

<!-- container start -->
<div id="container">
    <!-- content start -->
    <div id="content">
        <?php if ($this->options->topNotice): ?>
            <div class="notice box">
                <?php $this->options->topNotice() ?>
            </div>
        <?php endif; ?>
        <?php while ($this->next()): ?>
            <div class="post box">
                <div class="post-header">
                    <h2 class="post-title"><i class="icon-text"></i><a href="<?php $this->permalink() ?>"
                                                                       title="<?php $this->title() ?>"
                                                                       rel="bookmark"><?php $this->title() ?></a></h2>
                </div>
                <div class="post-content">
                    <?php echo XCore::getAbstract($this); ?>
                    <div class="clearfix"></div>
                </div>
                <div class="post-footer">
                    <?php $this->need("common/post-footer-meta.php"); ?>
                </div>
            </div>
        <?php endwhile; ?>
        <!-- pagenavi START -->
        <div class="pagenavi">
            <ol class="pages clearfix">
                <?php $this->pageNav(); ?>
            </ol>
            <div class="clear"></div>
        </div>
        <!-- pagenavi END -->
    </div>
    <!-- content end -->


    <?php $this->need('sidebar.php'); ?>

</div>
<!-- container end -->

<?php $this->need('footer.php'); ?>
