<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 最近评论
 *
 * @package widget
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
  <div class="widget box">
    <h4 class="widget-title">Recent Comments</h4>
 <div class="widget-body">
    <ul class="widget-list">
            <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true')->to($comments); ?>
            <?php while($comments->next()): ?>
                <li>
					<article id ="<?php $comments->theId() ?>">
						<div class="comment-author">
							<img class="avatar" src="<?php echo gravatarUrl($comments->mail, 'size=32') ?>" alt="<?php echo $comments->author; ?>" width="32" height="32" />
							<p><?php $comments->author(false); ?></p>
						</div>
						<a href="<?php $comments->permalink(); ?>">
							<p class="comment-text"><?php $comments->excerpt(15, '...'); ?></p>
						</a>
					</article>
				</li>
            <?php endwhile; ?>
    </ul>
  </div>
  </div>