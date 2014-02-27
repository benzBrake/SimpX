<?php include('header.php'); ?>

		
		<!-- container start -->
		<div id="container">
<!-- content START -->
<div id="content">

		
			
				<div class="posthead box"><?php _e('Archive for the category: '); ?><strong><?php $this->category(','); ?></strong></div>
	
				

		<div class="post box">
			<div class="post-header">
			<h2 class="post-title"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" rel="bookmark"><?php $this->title() ?></a></h2>
		
			<div class="postmeta">
				<ul>
					<li class="meta-date"><?php $this->date('F j, Y'); ?></li>
					<li class="meta-comments"><a href="<?php $this->permalink() ?>#comments" title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('No Comments', '1 Comment', '%d Comments'); ?></a></li>
				</ul>
				<div class="clear"></div>
			</div>
			</div>
		
			<div class="post-content">
				<?php $this->content(); ?>
			</div>
		</div>

						
							<?php $this->need('comments.php'); ?>
	
</div>
<!-- content END -->

	<?php include('sidebar.php'); ?>
			
	</div>
		<div class="clear"></div>
		<!-- container end -->
		
	<?php include('footer.php'); ?>
