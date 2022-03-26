<div class="related-posts box">
    <h2 class="related_post_title"><?php _e("您可能感兴趣"); ?></h2>
    <ul class="related_post">
        <?php /** @var $relatedPosts */$this->related(5)->to($relatedPosts); ?>
        <?php if ($relatedPosts->have()): ?>
            <?php while ($relatedPosts->next()): ?>
                <li><a href="<?php $relatedPosts->permalink(); ?>"
                       title="<?php $relatedPosts->title(); ?>"><?php $relatedPosts->title(); ?></a></li>
            <?php endwhile; ?>
        <?php else : ?>
            <li><?php _e("无"); ?></li>
        <?php endif; ?>
    </ul>
</div>
