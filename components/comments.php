<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php
function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    $commentLevelClass = $comments->levels > 0 ? 'comment-child' : 'comment-parent'; ?>
    <li id="<?php $comments->theId(); ?>" class="<?php echo $commentLevelClass; ?>">
        <div class="comment-body">
            <div class="comment-body-left">
                <?php gravatar($comments->mail, 'size=50'); ?>
            </div>
            <div class="comment-body-right">
                <div class="comment-meta <?php if ($comments->authorId == $comments->ownerId) : ?> author<?php endif; ?>">
                    <cite class="fn"><?php $comments->author(); ?></cite>
                    <time class="date" datetime="<?php $comments->date('c'); ?>" itemprop="datePublished"><?php $comments->date(); ?></time>
                </div>
                <div class="comment-content">
                    <?php $comments->content(); ?>
                </div>
                <?php if ($comments->levels < intval(Helper::options()->commentsMaxNestingLevels)) : ?>
                    <span class="comment-reply cr-<?php $comments->theId(); ?>">
                        <a href="#" rel="nofollow" data-tid="<?php $comments->coid(); ?>"><?php _e("回复"); ?></a>
                    </span>
                    <span class="cancel-comment-reply ccr-<?php $comments->theId(); ?>" style="display:none">
                        <a href="#" rel="nofollow"><?php _e("取消"); ?></a>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($comments->children) { ?>
            <div class="comment-children">
                <?php $comments->threadedComments($options); ?>
            </div>
        <?php } ?>
    </li>
<?php } ?>

<div id="comments" class="post-comments">
    <?php $this->comments()->to($comments); ?>
    <?php $user = $this->widget('Widget_User'); ?>
    <?php if ($this->allow('comment') && $user->hasLogin() || $this->status != "hidden") : ?>
        <div id="<?php $this->respondId(); ?>" class="comment-respond">
            <h3 id="reply-title" class="comment-reply-title"><?php _e("发表评论"); ?></h3>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form" role="form">
                <?php gravatar($this->user->mail, 'size=50'); ?>
                <input name="_" type="hidden" id="comment_" value="<?php echo Helper::security()->getToken(str_replace(array('?_pjax=%23main', '&_pjax=%23main'), '', Typecho_Request::getInstance()->getRequestUrl())); ?>" />
                <p class="comment-form-wrap">
                    <label class="comment-label show" for="text" class="required"></label>
                    <textarea rows="8" cols="45" name="text" id="comment" class="textarea" placeholder="<?php _e("想法..."); ?>" required><?php $this->remember('text'); ?></textarea>
                </p>
                <div id="comment-settings">
                    <div class="comment-fields">
                        <?php if ($this->user->hasLogin()) : ?>
                            <div class="login-user">
                                <?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a no-pjax href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
                            </div>
                        <?php else : ?>
                            <div class="comment-form-author">
                                <label for="author"><?php _e('昵称'); ?></label>
                                <input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" size="30" required />

                            </div>
                            <div class="comment-form-email">
                                <label for="mail"><?php _e('邮箱'); ?></label>
                                <input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>" size="30" <?php if ($this->options->commentsRequireMail) : ?> required<?php endif; ?> />
                                <?php if ($this->options->commentsRequireMail) : ?><span class="required"></span><?php endif; ?>
                            </div>
                            <div class="comment-form-url">
                                <label for="url"><?php _e('网站'); ?></label>
                                <input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>" size="30" <?php if ($this->options->commentsRequireURL) : ?> required<?php endif; ?> />
                                <?php if ($this->options->commentsRequireURL) : ?><span class="required"></span><?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <footer class="comment-form-footer clearfix">
                    <button id="submit" type="submit" class="submit btn btn-primary"><?php _e('评论'); ?></button>
                </footer>
            </form>
        </div>
    <?php else : ?>
        <h3 class="comment-closed"><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
    <h3 id="comments-title" class="comments-title text-uppercase"><?php _e("评论列表("); ?><?php $this->commentsNum(_t('暂无评论'), _t('1条'), _t('%d条')); ?><?php _e(")"); ?></h3>
    <?php if ($comments->have()) : ?>
        <?php $comments->listComments('before=<ul class="comments-list">&after=</ul>'); ?>
        <?php $comments->pageNav(_t('&laquo; 前一页', '后一页 &raquo;')); ?>
    <?php endif; ?>
</div>