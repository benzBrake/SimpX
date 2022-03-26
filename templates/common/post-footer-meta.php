<div class="post-footer-meta">
    <ul>
        <li class="meta-date"><i class="icon-calendar"></i><?php $this->date('Y-m-d'); ?></li>
        <li class="meta-cat"><i class="icon-list"></i><?php $this->category(','); ?></li>
        <li class="meta-comments"><i class="icon-comment"></i><a
                href="<?php $this->permalink() ?>#comments"
                title="在《 <?php $this->title() ?>》的评论"><?php $this->commentsNum('没有评论', '1 条评论', '%d 条评论'); ?></a>
        </li>
    </ul>
    <p class="morelink">
        <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"
           rel="bookmark"><i class="icon-forward"></i></a></p>
    <div class="clear"></div>
</div>
