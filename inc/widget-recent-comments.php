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
							<?php
								$host = 'https://secure.gravatar.com';
								$url = '/avatar/';
								$size = '32';
								$rating = Helper::options()->commentsAvatarRating;
								$hash = md5(strtolower($comments->mail));
								$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=';
							?>
							<img class="avatar" src="<?php echo $avatar ?>" alt="<?php echo $comments->author; ?>" width="<?php echo $size ?>" height="<?php echo $size ?>" />
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