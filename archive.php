<?php include('header.php'); ?>

		
		<!-- container start -->
		<div id="container">
<!-- content START -->
<div id="content">

		
<?php if($this->is('archive')): ?>			
				<div class="posthead box"><?php _e('Archive for the category: '); ?><strong><?php $this->category(','); ?></strong></div>
<?php endif; ?>	
				
<?php while($this->next()): ?>
		<div class="post box">
			<div class="post-header">
			<h2 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>
			</div>
		
			<div class="post-content">
				<?php $this->excerpt(350, '...'); ?>
			</div>
<?php if($this->is('archive')): ?>
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
<?php endif; ?>
		</div>
		<?php endwhile; ?>
						
				
		<!-- pagenavi START -->
		<div class="pagenavi">
        <ol class="pages clearfix">
            <?php $this->pageNav(); ?>
        </ol>
			<div class="fixed"></div>
		</div>
		<!-- pagenavi END -->
		
	
</div>
<!-- content END -->

	<?php include('sidebar.php'); ?>
			
	</div>
		<div class="clear"></div>
		<!-- container end -->
		
	<?php include('footer.php'); ?>