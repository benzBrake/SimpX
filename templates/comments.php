<div id="comments">
    <?php /** @var $comments */
    $this->comments('comment')->to($comments); ?>
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <div class="cancel-comment-reply"><?php $comments->cancelReply(); ?></div>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form">
                <?php if ($this->user->hasLogin()): ?>
                    <p>
                        <a href="<?php $this->options->profileUrl(); ?>">
                            <?php $this->user->screenName(); ?></a>.<a href="<?php $this->options->logoutUrl(); ?>"
                                                                       title="退出">退出</a>
                    </p>
                <?php else: ?>
                    <ul class="login_meta">
                        <li>
                            <label for="author">称呼<span class="required">*</span></label>
                            <input type="text" name="author" id="author" size="15"
                                   value="<?php $this->remember('author'); ?>" required/>
                        </li>
                        <li>
                            <label for="mail">电子邮件
                                <?php if ($this->options->commentsRequireMail): ?>
                                    <span class="required">*</span>
                                <?php endif; ?>
                            </label>
                            <input type="text" name="mail" id="mail" size="15" value="<?php $this->remember('mail'); ?>"
                                   required/>
                        </li>
                        <li class="urltext">
                            <label for="url">网站
                                <?php if ($this->options->commentsRequireURL): ?>
                                    <span class="required">*</span>
                                <?php endif; ?>
                            </label>
                            <input type="text" name="url" id="url" size="15" value="<?php $this->remember('url'); ?>"/>
                        </li>
                    </ul>
                <?php endif; ?>
                <p><textarea rows="5" id="comment" cols="50" name="text" placeholder="<?php _e("添加一条评论"); ?>"
                             required><?php $this->remember('text'); ?></textarea></p>
                <div id="math-problem"><?php spam_protection_math(); ?></div>
                <p class="submit">
                    <button type="submit" class="submit btn btn-primary"><?php _e("发射"); ?></button>
                </p>
                <script type="text/javascript">
                    Smilies = {
                        dom: function (id) {
                            return document.getElementById(id)
                        },
                        showBox: function () {
                            this.dom('smiley').style.display = 'block';
                            document.onclick = function () {
                                Smilies.hideBox()
                            }
                        },
                        hideBox: function () {
                            this.dom('smiley').style.display = 'none'
                        },
                        grin: function (tag) {
                            tag = ' ' + tag + ' ';
                            myField = this.dom('comment');
                            document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag)
                        },
                        insertTag: function (tag) {
                            myField = Smilies.dom('comment');
                            myField.selectionStart || myField.selectionStart == '0' ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus());
                            this.hideBox()
                        }
                    };
                </script>
                <div id="Smilies">
                    <a href="javascript:Smilies.grin(':?:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_question.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':razz:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_razz.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':sad:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_sad.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':evil:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_evil.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':!:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_exclaim.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':smile:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_smile.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':oops:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_redface.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':grin:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_biggrin.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':eek:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_surprised.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':shock:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_eek.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':???:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_confused.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':cool:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_cool.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':lol:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_lol.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':mad:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_mad.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':twisted:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_twisted.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':roll:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_rolleyes.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':wink:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_wink.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':idea:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_idea.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':arrow:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_arrow.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':neutral:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_neutral.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':cry:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_cry.gif" alt=""
                            class="smiley"></a>
                    <a href="javascript:Smilies.grin(':mrgreen:')"><img
                            src="<?php $this->options->themeUrl('assets/img/Smilies/'); ?>icon_mrgreen.gif" alt=""
                            class="smiley"></a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="msg-error"><?php _e("评论已关闭"); ?></div>
    <?php endif; ?>
    <?php if ($comments->have()): ?>
        <div class="comments_count">
            <?php $this->commentsNum(_t('当前暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?>
        </div>
        <div class="comments_box">
            <?php $comments->listComments(); ?>
            <?php $comments->pageNav(); ?>
        </div>
    <?php endif; ?>
</div>
