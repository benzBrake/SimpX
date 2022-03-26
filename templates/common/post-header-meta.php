<div class="post-header-meta">
    <ul>
        <li class="meta-date"><i class="icon-calendar"></i><?php $this->date('Y-m-d'); ?></li>
        <!--li class="meta-views"></li-->
        <?php if ($this->is('post')): ?>
            <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li><?php endif; ?>
        <li class="meta-comments"><i class="icon-comment"></i><a
                href="<?php $this->permalink() ?>#comments"
                title="Comment on <?php $this->title() ?>"><?php $this->commentsNum('无评论', '1 条评论', '%d 条评论'); ?></a>
        </li>
    </ul>
</div>
