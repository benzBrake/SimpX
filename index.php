<?php 
/**
 * 一款淡蓝主题，采用了高大上的字体图标(ie 6 不支持图标字体)。
 * @package 三栏主题：SimpX  (Theme designed by weleeTime.Mod By Tammy)
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
       <?php if ($this->options->topNotice) { ?>
       <div class="notice box">
         <?php $this->options->topNotice() ?>
       </div>
       <?php } else {} ?>
<?php while($this->next()): ?>
      <div class="post box">
       <div class="post-header">
        <h2 class="post-title"><i class="icon-text"></i><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>
       </div>
        <div class="post-content">
          <?php $this->excerpt(350, '...'); ?>
          <!--<?php $this->content(); ?>-->
          <div class="clear"></div>
        </div>
        <div class="post-footer">
<div class="postmeta">
          <ul>
            <li class="meta-date"><i class="icon-calendar"></i><?php $this->date('F j, Y'); ?></li>
            <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
            <li class="meta-comments"><i class="icon-comment"></i><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
          </ul>
          <p class="morelink"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><i class="icon-forward"></i></a></p>
          <div class="clear"></div>
        </div>
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
  <div class="clear"></div>
  <!-- container end -->

<?php $this->need('footer.php'); ?>