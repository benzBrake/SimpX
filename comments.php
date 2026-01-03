<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <div class="cancel-comment-reply"><?php $comments->cancelReply(); ?></div>
            <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form">
                <div class="respond-header">
                    <h2 class="respond-title">
                        <i class="icon-reply"></i>
                        <span><?php _e("欢迎参与讨论"); ?></span>
                    </h2>
                </div>
                <div class="respond-body">
                    <?php if ($this->user->hasLogin()): ?>
                        <div id="welcome-back">
                            <?php _e('欢迎回来，<strong>%s</strong>，不是您的账号？', $this->user->screenName); ?>
                            <a class="badge badge-danger has-tooltip" href="<?php $this->options->logoutUrl(); ?>" title="<?php _e('点击退出登录'); ?>"><?php _e('登出'); ?></a>
                        </div>
                    <?php else: ?>
                        <div id="welcome-back" class="hidden">
                            <?php _e(
                                '欢迎回来, %s&nbsp;%s',
                                '<span class="username badge">{user}</span>',
                                sprintf(
                                    '<a id="change-profile" class="change badge badge-danger" href="javascript:void(0)" title="%s">%s</a>',
                                    _t("更换身份"),
                                    _t("更换身份 »")
                                )
                            ); ?>
                        </div>
                        <ul class="login-meta">
                            <li><label for="author"><?php _e("称呼"); ?><span class="required">*</span></label>
                                <input type="text" name="author" id="author" value="<?php $this->remember('author'); ?>" required>
                            </li>
                            <li><label for="mail"><?php _e("电子邮件"); ?><span class="required">*</span></label>
                                <input type="text" name="mail" id="mail" value="<?php $this->remember('mail'); ?>" required>
                            </li>
                            <li class="urltext"><label for="url"><?php _e("网站"); ?></label>
                                <input type="text" name="url" id="url" value="<?php $this->remember('url'); ?>">
                            </li>
                        </ul>
                    <?php endif; ?>

                    <div id="comment-editor-group" class="comment-editor-group">
                        <div id="comment-wysiwyg" class="hidden comment-editor" contenteditable=""></div>
                        <textarea id="comment-source" class="comment-editor" name="text" placeholder="<?php _e('在此直接编辑 Markdown 文本，支持 ![]() 插入图片、:smile: 表情等'); ?>"><?php $this->remember('text'); ?></textarea>
                        <div id="comment-preview" class="comment-preview"></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div id="respond-similies-panel">
                    <?php
                    $smilies = [
                        ':?:' => 'icon_question.gif',
                        ':razz:' => 'icon_razz.gif',
                        ':sad:' => 'icon_sad.gif',
                        ':evil:' => 'icon_evil.gif',
                        ':!:' => 'icon_exclaim.gif',
                        ':smile:' => 'icon_smile.gif',
                        ':oops:' => 'icon_redface.gif',
                        ':grin:' => 'icon_biggrin.gif',
                        ':eek:' => 'icon_surprised.gif',
                        ':shock:' => 'icon_eek.gif',
                        ':cool:' => 'icon_cool.gif',
                        ':lol:' => 'icon_lol.gif',
                        ':mad:' => 'icon_mad.gif',
                        ':wink:' => 'icon_wink.gif',
                        ':cry:' => 'icon_cry.gif',
                    ];
                    foreach ($smilies as $tag => $img): ?>
                        <a data-tag="<?php echo $tag; ?>" href="javascript:void(0)">
                            <img class="smiley" src="<?php $this->options->themeUrl('assets/img/Smilies/' . $img); ?>" alt="<?php echo $tag; ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
                <div id="respond-footer" class="respond-footer">
                    <div id="editor-mode"><label for="editor-mode"><input type="checkbox" name="editor-mode" /><?php _e("源码模式"); ?></label></div>
                    <button type="button" id="respond-similies" class="btn btn-secondary"><?php _e("表情"); ?></button>
                    <button type="button" id="respond-image" class="btn btn-secondary"><?php _e("图片"); ?></button>
                    <button type="submit" id="respond-submit" class="btn btn-primary"><?php _e("发表"); ?></button>
                </div>
            </form>

            <script type="text/javascript">
                var smiliesMap = {};
                <?php foreach ($smilies as $tag => $img): ?>
                    smiliesMap[<?php echo json_encode($tag); ?>] = "<?php $this->options->themeUrl('assets/img/Smilies/' . $img); ?>";
                <?php endforeach; ?>
            </script>


            <script>
                (function() {
                    function $(selector, context) {
                        if (typeof selector === 'string') {
                            if (selector.charAt(0) === '#') {
                                return document.getElementById(selector.slice(1));
                            } else {
                                var els = (context || document).getElementsByTagName('*');
                                var arr = [];
                                for (var i = 0; i < els.length; i++) {
                                    if (hasClass(els[i], selector)) {
                                        arr.push(els[i]);
                                    }
                                }
                                return arr;
                            }
                        } else if (selector && selector.nodeType) {
                            return selector;
                        }
                        return null;
                    }

                    function hasClass(element, cls) {
                        var classNames = element.className.split(/\s+/);
                        for (var i = 0; i < classNames.length; i++) {
                            if (classNames[i] === cls) {
                                return true;
                            }
                        }
                        return false;
                    }

                    function addClass(element, cls) {
                        if (!hasClass(element, cls)) {
                            var classNames = element.className.split(/\s+/);
                            classNames.push(cls);
                            element.className = classNames.join(' ');
                        }
                    }

                    function removeClass(element, cls) {
                        if (hasClass(element, cls)) {
                            var classNames = element.className.split(/\s+/);
                            var newClassNames = [];
                            for (var i = 0; i < classNames.length; i++) {
                                if (classNames[i] !== cls) {
                                    newClassNames.push(classNames[i]);
                                }
                            }
                            element.className = newClassNames.join(' ');
                        }
                    }

                    function isIE(version, op) {
                        var isIEBrowser = false;
                        var ieVersion = 0;

                        // 检查是否是IE浏览器
                        if (!!window.ActiveXObject || "ActiveXObject" in window) {
                            isIEBrowser = true;

                            // 尝试获取IE版本
                            var ua = navigator.userAgent.toLowerCase();

                            // IE11的userAgent中没有msie，但有trident
                            if (ua.indexOf('msie') !== -1) {
                                ieVersion = parseInt(ua.match(/msie (\d+)/)[1], 10);
                            } else if (ua.indexOf('trident') !== -1) {
                                // IE11的版本号在rv:后面
                                ieVersion = parseInt(ua.match(/rv:(\d+)/)[1], 10);
                            }

                            // 如果没有提供参数，直接返回是否是IE
                            if (arguments.length === 0) {
                                return isIEBrowser;
                            }

                            // 如果只提供了version参数，没有提供op参数，检查是否等于该版本
                            if (arguments.length === 1) {
                                return ieVersion === version;
                            }

                            // 提供了version和op参数，进行版本比较
                            switch (op) {
                                case '<':
                                    return ieVersion < version;
                                case '<=':
                                    return ieVersion <= version;
                                case '>':
                                    return ieVersion > version;
                                case '>=':
                                    return ieVersion >= version;
                                case '=':
                                case '==':
                                case '===':
                                    return ieVersion === version;
                                default:
                                    // 如果op参数无效，默认检查是否等于version
                                    return ieVersion === version;
                            }
                        }

                        // 不是IE浏览器
                        return false;
                    }

                    // 添加一个函数，用于通过类名获取单个元素
                    function getByClass(className, context) {
                        var elements = $(className, context);
                        return elements.length > 0 ? elements[0] : null;
                    }

                    // 添加一个事件绑定函数，兼容IE6
                    function addEvent(element, event, handler) {
                        if (element.addEventListener) {
                            element.addEventListener(event, handler, false);
                        } else if (element.attachEvent) {
                            element.attachEvent('on' + event, handler);
                        } else {
                            element['on' + event] = handler;
                        }
                    }

                    // 添加一个设置元素样式的函数
                    function setStyle(element, styles) {
                        for (var property in styles) {
                            if (styles.hasOwnProperty(property)) {
                                element.style[property] = styles[property];
                            }
                        }
                    }

                    /**
                     * 获取一个元素的当前渲染宽度（内容区宽度）
                     * 兼容 IE6-8, IE9+ 以及其他现代浏览器
                     *
                     * @param {HTMLElement} el 需要获取宽度的DOM元素
                     * @returns {number} 元素的宽度，单位为像素。如果元素不可见或参数无效，返回 0。
                     */
                    function getWidth(el) {
                        // 1. 基本的参数检查和元素可见性判断
                        if (!el || el.nodeType !== 1) {
                            return 0;
                        }

                        // 如果元素或者其祖先元素 display 为 'none'，则 offsetWidth 为 0
                        // 这种情况下无法获取精确尺寸
                        if (el.offsetWidth === 0) {
                            // 注意：这里简单返回0，更复杂的库（如jQuery）会临时显示元素来测量
                            // 对于绝大多数场景，返回0是合理的
                            return 0;
                        }

                        // 2. 优先使用 getComputedStyle（现代浏览器和 IE9）
                        // 这是最准确、最标准的方式
                        if (window.getComputedStyle) {
                            var styles = window.getComputedStyle(el, null);
                            // parseFloat 用于去掉 'px' 等单位
                            var width = parseFloat(styles.width);
                            // 如果获取到的是有效数字，则返回
                            if (!isNaN(width)) {
                                return width;
                            }
                        }

                        // 3. 回退到 IE6-8 的 currentStyle（代码能执行到这里，说明是 IE8 或更早版本）
                        if (el.currentStyle) {
                            var currentWidth = el.currentStyle.width;

                            // 如果 currentStyle.width 已经是一个带单位的字符串 (如 '100px')
                            if (currentWidth.indexOf('px') > -1) {
                                return parseFloat(currentWidth);
                            }

                            // 如果 width 是 'auto' 或百分比，currentStyle 可能无法给出准确值
                            // 此时，需要使用 offsetWidth 进行计算，并减去 padding 和 border
                            // 这是处理 IE6-8 兼容性的核心步骤

                            // 获取 padding 和 border 值
                            // 在 currentStyle 中，如果值为 'medium'（border的默认值），需要手动转换为像素
                            var getBorderWidth = function(side) {
                                var borderWidth = el.currentStyle['border' + side + 'Width'];
                                if (borderWidth === 'medium') {
                                    return 2; // 在 IE 中，'medium' 通常被视为 2px
                                }
                                return parseFloat(borderWidth) || 0;
                            };

                            var paddingLeft = parseFloat(el.currentStyle.paddingLeft) || 0;
                            var paddingRight = parseFloat(el.currentStyle.paddingRight) || 0;
                            var borderLeft = getBorderWidth('Left');
                            var borderRight = getBorderWidth('Right');

                            // offsetWidth = content width + padding + border
                            // 所以 content width = offsetWidth - padding - border
                            return el.offsetWidth - paddingLeft - paddingRight - borderLeft - borderRight;
                        }

                        // 4. 最后的兜底方案（虽然不太可能走到这里）
                        // 直接使用 offsetWidth，但要注意它包含了 padding 和 border
                        // 在没有其他办法时，这是一个近似值
                        return el.offsetWidth;
                    }

                    // 兼容 IE6 的 replaceAll
                    function replaceAll(str, find, replace) {
                        return str.split(find).join(replace);
                    }

                    /**
                     * 兼容 IE6 的 closest 方法实现
                     * 从当前元素开始，向上查找匹配选择器的第一个元素（包括当前元素）
                     * @param {HTMLElement} element 当前元素
                     * @param {String} selector CSS 选择器
                     * @return {HTMLElement|null} 匹配的元素或 null
                     */
                    function closest(element, selector) {
                        // 如果浏览器原生支持 closest 方法，则直接使用
                        if (element.closest) {
                            return element.closest(selector);
                        }

                        // 兼容 IE6 的实现
                        var el = element;

                        // 首先检查当前元素是否匹配
                        if (matches(el, selector)) {
                            return el;
                        }

                        // 然后向上查找父元素
                        while ((el = el.parentElement) !== null) {
                            if (matches(el, selector)) {
                                return el;
                            }
                        }

                        return null;
                    }

                    /**
                     * 兼容 IE6 的元素匹配检测
                     * @param {HTMLElement} element 要检测的元素
                     * @param {String} selector CSS 选择器
                     * @return {Boolean} 是否匹配
                     */
                    function matches(element, selector) {
                        // 如果浏览器原生支持 matches 方法，则直接使用
                        if (element.matches) {
                            return element.matches(selector);
                        }
                        if (element.msMatchesSelector) {
                            return element.msMatchesSelector(selector);
                        }

                        // 兼容 IE6 的实现
                        var matches = (element.document || element.ownerDocument).querySelectorAll(selector),
                            i = 0;

                        while (matches[i] && matches[i] !== element) {
                            i++;
                        }

                        return matches[i] ? true : false;
                    }


                    window.CommentEditor = {
                        savedSelection: {
                            wysiwyg: null,
                            source: null
                        },
                        init: function() {
                            this.egl = $('#comment-editor-group');
                            this.we = $('#comment-wysiwyg');
                            this.se = $('#comment-source');
                            this.pe = $('#comment-preview');
                            this.rf = $('#respond-footer');
                            this.initWelcomeBack();
                            if (isIE(8, '<=')) {
                                this.initSplitMode();
                            } else {
                                this.initNormalMode();
                            }
                            removeClass(this.we, 'hidden');
                            removeClass(this.se, 'hidden');
                            removeClass(this.pe, 'hidden');
                            this.initSmiliesPanel();
                            this.initImageInsert();
                            this.renderCommentList($('#comments-box'));
                        },
                        initWelcomeBack: function() {
                            var author_input = $('#author');
                            var author_email = $('#mail');
                            var author_url = $('#url');
                            var welcome_back = $('#welcome-back');
                            if (author_input && author_email && welcome_back) {
                                if (author_input.value && author_email.value) {
                                    welcome_back.innerHTML = welcome_back.innerHTML.replace('{user}', author_input.value);
                                    removeClass(welcome_back, 'hidden');
                                    var login_meta = closest(author_input, '.login-meta');
                                    addClass(login_meta, 'hidden');
                                    var change_profile = $('#change-profile');
                                    if (change_profile) {
                                        addEvent(change_profile, 'click', function() {
                                            addClass(welcome_back, 'hidden');
                                            removeClass(login_meta, 'hidden');
                                        });
                                    }
                                }
                            }
                        },
                        initSplitMode: function() {
                            addClass(this.egl, 'split-mode');
                            addClass(this.rf, 'split-mode');
                            addClass($('#editor-mode'), 'hidden');
                            var self = this;

                            function adjustHeight() {
                                if (isIE(7, '>=')) {
                                    var t = self.se;
                                    var newHeight = Math.max(100, t.scrollHeight);
                                    setStyle(t, 'height', newHeight + 'px');
                                }
                                self.pe.style.height = self.se.style.height;
                            }
                            addEvent(this.se, 'input', adjustHeight, false);
                            addEvent(this.se, 'keyup', adjustHeight, false);
                            addEvent(this.se, 'propertychange', adjustHeight, false);
                            this.bindPreviewSync();
                        },
                        initNormalMode: function() {
                            addClass(this.rf, 'normal-mode');
                            this.modeCheckbox = $('#editor-mode').getElementsByTagName('input')[0];
                            this.setModeByCheckbox();
                            this.initModeSwitch();
                            this.bindWysiwygSync();
                            this.initWysiwygSaveSelection();
                        },
                        initModeSwitch: function() {
                            var self = this;
                            var wrapper = $('#editor-mode');
                            var cb = this.modeCheckbox;

                            addEvent(wrapper, 'click', function(e) {
                                e = e || window.event;
                                var target = e.target || e.srcElement;
                                if (target.tagName && target.tagName.toLowerCase() === 'label') {
                                    cb.checked = !cb.checked;
                                }
                                self.setModeByCheckbox();
                            });
                        },

                        setModeByCheckbox: function() {
                            var cb = this.modeCheckbox;

                            // 切换前，保存当前模式光标
                            if (hasClass(this.egl, 'source-mode')) {
                                this.saveSourceSelection();
                            } else {
                                this.saveWysiwygSelection();
                            }

                            removeClass(this.egl, 'normal-mode');
                            removeClass(this.egl, 'source-mode');

                            if (cb.checked) {
                                addClass(this.egl, 'source-mode');
                                this.restoreSourceSelection(); // ★
                            } else {
                                addClass(this.egl, 'normal-mode');
                                // ★ 关键修复：从 textarea 同步内容到 WYSIWYG
                                this.syncSourceToWysiwyg();
                                this.restoreWysiwygSelection(); // ★
                            }
                        },


                        initTextareaSaveSelection: function() {
                            var self = this;
                            addEvent(this.se, 'mouseup', function() {
                                self.saveSourceSelection();
                            });
                            addEvent(this.se, 'keyup', function() {
                                self.saveSourceSelection();
                            });
                            addEvent(this.se, 'blur', function() {
                                self.saveSourceSelection();
                            });
                        },

                        saveSourceSelection: function() {
                            var ta = this.se;
                            if (!ta) return;

                            // IE6-8
                            if (document.selection && ta.createTextRange) {
                                ta.focus();
                                var range = document.selection.createRange();
                                var dup = range.duplicate();

                                dup.moveToElementText(ta);
                                dup.setEndPoint('EndToEnd', range);

                                this.savedSelection.source = {
                                    start: dup.text.length - range.text.length,
                                    end: dup.text.length
                                };
                                return;
                            }

                            // Modern browsers
                            if (typeof ta.selectionStart === 'number') {
                                this.savedSelection.source = {
                                    start: ta.selectionStart,
                                    end: ta.selectionEnd
                                };
                            }
                        },


                        restoreSourceSelection: function() {
                            var ta = this.se;
                            var sel = this.savedSelection.source;
                            if (!ta || !sel) return;

                            ta.focus();

                            // IE6-8
                            if (ta.createTextRange) {
                                var range = ta.createTextRange();
                                range.collapse(true);
                                range.moveStart('character', sel.start);
                                range.moveEnd('character', sel.end - sel.start);
                                range.select();
                                return;
                            }

                            // Modern browsers
                            if (typeof ta.selectionStart === 'number') {
                                ta.selectionStart = sel.start;
                                ta.selectionEnd = sel.end;
                            }
                        },

                        initWysiwygSaveSelection: function() {
                            var self = this;
                            addEvent(this.we, 'mouseup', function() {
                                self.saveWysiwygSelection();
                            });
                            addEvent(this.we, 'keyup', function() {
                                self.saveWysiwygSelection();
                            });
                            addEvent(this.we, 'blur', function() {
                                self.saveWysiwygSelection();
                            });
                        },

                        saveWysiwygSelection: function() {
                            var editor = this.we;
                            if (!editor) return;

                            // IE6-8
                            if (document.selection && document.selection.createRange) {
                                try {
                                    this.savedSelection.wysiwyg = document.selection.createRange();
                                } catch (e) {}
                                return;
                            }

                            // Modern
                            if (window.getSelection) {
                                var sel = window.getSelection();
                                if (sel.rangeCount > 0) {
                                    this.savedSelection.wysiwyg = sel.getRangeAt(0).cloneRange();
                                }
                            }
                        },

                        restoreWysiwygSelection: function() {
                            var range = this.savedSelection.wysiwyg;
                            if (!range) return;

                            // IE6-8
                            if (range.select) {
                                try {
                                    range.select();
                                } catch (e) {}
                                return;
                            }

                            // Modern
                            if (window.getSelection) {
                                var sel = window.getSelection();
                                sel.removeAllRanges();
                                sel.addRange(range);
                            }
                        },


                        initSmiliesPanel: function() {
                            var self = this;
                            var btn = $('#respond-similies');
                            var panel = $('#respond-similies-panel');

                            // 点击表情按钮显示/隐藏
                            addEvent(btn, 'click', function() {
                                panel.style.display = (panel.style.display === 'block') ? 'none' : 'block';
                            });

                            // 点击表情
                            addEvent(panel, 'click', function(e) {
                                e = e || window.event;
                                var target = e.target || e.srcElement;

                                // 如果点击 img，取父 a
                                if (target.tagName.toLowerCase() === 'img') {
                                    target = target.parentNode;
                                }

                                if (target.tagName.toLowerCase() === 'a') {
                                    var tag = target.getAttribute('data-tag');
                                    if (!tag) return;
                                    // 根据当前模式插入
                                    if (hasClass(self.egl, 'split-mode')) {
                                        // source-mode → 低版本 IE，只插入 tag 到 textarea
                                        self.insertToTextarea(self.se, tag);
                                    } else {
                                        // normal-mode → 现代浏览器，插入 <img> 到 WYSIWYG
                                        self.insertsmileyToWysiwyg(tag);
                                        self.syncWysiwygToSource();
                                    }

                                    // panel.style.display = 'none';
                                }
                            });
                        },

                        initImageInsert: function() {
                            // 在 CommentEditor.initSmiliesPanel 后面添加：
                            var self = this;
                            addEvent($('#respond-image'), 'click', function() {

                                var url = '',
                                    title = '<?php _e("图片") ?>',
                                    alt = '';

                                // 现代浏览器支持 <dialog>
                                if (typeof HTMLDialogElement === 'function') {
                                    // 创建模态框
                                    var dialog = document.createElement('dialog');
                                    dialog.style.padding = '20px';
                                    dialog.innerHTML = '' +
                                        '<form method="dialog">' +
                                        '<label>图片URL: <input type="text" id="img-url" style="width:100%"></label><br><br>' +
                                        '<label>标题(title): <input type="text" id="img-title" style="width:100%"></label><br><br>' +
                                        '<label>替代文字(alt): <input type="text" id="img-alt" style="width:100%"></label><br><br>' +
                                        '<menu>' +
                                        '<button value="cancel">取消</button>' +
                                        '<button id="ok-btn" value="ok">插入</button>' +
                                        '</menu>' +
                                        '</form>';
                                    document.body.appendChild(dialog);

                                    dialog.showModal();

                                    var okBtn = $('#ok-btn', dialog);
                                    addEvent(okBtn, 'click', function() {
                                        url = $('#img-url', dialog).value;
                                        title = $('#img-title', dialog).value;
                                        alt = $('#img-alt', dialog).value || '';
                                        insertImage(url, title, alt);
                                        dialog.close();
                                        dialog.remove();
                                    });

                                    addEvent(dialog, 'cancel', function() {
                                        dialog.remove();
                                    });

                                } else {
                                    // 退回使用 prompt
                                    url = prompt("<?php _e("请输入图片 URL:"); ?>", "http://");
                                    if (!url) return;
                                    insertImage(url, title, alt);
                                }

                                function insertImage(url, title, alt) {
                                    if (!url) return;

                                    var html = '<img class="image" src="' + url + '"';
                                    if (alt) html += ' alt="' + alt + '"';
                                    if (title) html += ' title="' + title + '"';
                                    html += '>';

                                    // 判断当前模式
                                    if (hasClass(self.egl, 'split-mode')) {
                                        // 插入到 textarea
                                        self.insertToTextarea(self.se, '![](' + url + ')');
                                    } else {
                                        // 插入到 WYSIWYG
                                        self.insertToWysiwyg(html);
                                    }

                                    // 更新预览
                                    self.updatePreview();
                                }
                            });
                        },

                        // textarea 插入
                        insertToTextarea: function(textarea, text) {
                            textarea.focus();
                            this.restoreSourceSelection();
                            if (document.selection) {
                                // IE6-8
                                var sel = document.selection.createRange();
                                sel.text = text;
                                sel.collapse(false);
                                sel.select();
                            } else if (typeof textarea.selectionStart === 'number') {
                                var start = textarea.selectionStart;
                                var end = textarea.selectionEnd;
                                var value = textarea.value;

                                textarea.value = value.substring(0, start) +
                                    text +
                                    value.substring(end);

                                textarea.selectionStart = textarea.selectionEnd = start + text.length;
                            } else {
                                textarea.value += text;
                            }
                            this.updatePreview();
                        },

                        insertsmileyToWysiwyg: function(tag) {
                            var img = document.createElement('img');
                            img.src = smiliesMap[tag];
                            img.alt = tag;
                            img.className = 'smiley';
                            this.insertToWysiwyg(img);
                        },

                        // WYSIWYG 插入
                        insertToWysiwyg: function(html) {
                            var editor = this.we;
                            editor.focus();
                            this.restoreWysiwygSelection();
                            var sel = window.getSelection();

                            // ✅ 没有选区
                            if (!sel.rangeCount) {
                                if (typeof html === 'string') {
                                    editor.insertAdjacentHTML('beforeend', html);
                                } else if (html && html.nodeType) {
                                    editor.appendChild(html); // ← 关键修复
                                }
                                this.syncWysiwygToSource();
                                return;
                            }

                            var range = sel.getRangeAt(0);

                            if (!editor.contains(range.commonAncestorContainer)) {
                                if (typeof html === 'string') {
                                    editor.insertAdjacentHTML('beforeend', html);
                                } else if (html && html.nodeType) {
                                    editor.appendChild(html);
                                }
                                this.syncWysiwygToSource();
                                return;
                            }

                            // 正常插入
                            range.deleteContents();

                            if (typeof html === 'string') {
                                var temp = document.createElement('div');
                                temp.innerHTML = html;
                                var frag = document.createDocumentFragment();
                                while (temp.firstChild) {
                                    frag.appendChild(temp.firstChild);
                                }
                                range.insertNode(frag);
                            } else if (html && html.nodeType) {
                                range.insertNode(html);
                            }

                            range.collapse(false);
                            sel.removeAllRanges();
                            sel.addRange(range);

                            this.syncWysiwygToSource();
                        },

                        // WYSIWYG 同步到 textarea
                        syncWysiwygToSource: function() {
                            if (!this.we || !this.se) return;

                            var html = this.we.innerHTML;

                            // 1. 替换表情 <img> 为 tag
                            html = html.replace(/<img[^>]+alt=["']([^"']+)["'][^>]*>/ig, function(_, tag) {
                                return tag; // :smile: :sad: 等
                            });

                            // 2. 替换换行 <br> 为 \n
                            html = html.replace(/<br\s*\/?>/ig, '\n');

                            // 3. 替换段落 <p>…</p> 为 \n
                            html = html.replace(/<\/p>/ig, '\n').replace(/<p[^>]*>/ig, '');

                            // 4. 可选：替换图片 <img> Markdown 或短代码格式（如果你需要保留图片）
                            html = html.replace(/<img[^>]+src=["']([^"']+)["'][^>]*>/ig, '![]($1)');

                            // 5. 清理其他 HTML 标签
                            html = html.replace(/<\/?[^>]+>/g, '');

                            // 6. 去掉多余空行
                            html = html.replace(/\n{2,}/g, '\n');

                            // 写入 textarea
                            this.se.value = html;
                        },

                        syncSourceToWysiwyg: function() {
                            if (!this.se || !this.we) return;

                            var content = this.se.value;

                            // 复用 updatePreview 的渲染逻辑（几乎一模一样）
                            // 1. 替换表情文本为图片
                            content = content.replace(/(:[a-zA-Z0-9_?!]+:)/g, function(match) {
                                var src = smiliesMap[match];
                                if (src) {
                                    return '<img class="smiley" src="' + src + '" alt="' + match + '">';
                                }
                                return match;
                            });

                            // 2. 替换 Markdown 图片语法
                            content = content.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, function(_, alt, url) {
                                var img = '<img class="image" src="' + url + '"';
                                if (alt) img += ' alt="' + alt + '"';
                                img += '>';
                                return img;
                            });

                            // 3. 多行代码块
                            content = content.replace(/```([\s\S]*?)```/g, function(_, code) {
                                code = code.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                                return '<pre><code>' + code + '</code></pre>';
                            });

                            // 4. 行内代码
                            content = content.replace(/`([^`\n]+)`/g, function(_, code) {
                                code = code.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                                return '<code>' + code + '</code>';
                            });

                            // 5. 换行转 <br>（避免代码块内换行被转换）
                            // 先临时保护 pre 内容
                            var prePlaceholders = [];
                            content = content.replace(/<pre><code>[\s\S]*?<\/code><\/pre>/gi, function(match) {
                                prePlaceholders.push(match);
                                return '__PRE_PLACEHOLDER_' + (prePlaceholders.length - 1) + '__';
                            });

                            content = content.replace(/\n/g, '<br>');

                            // 恢复 pre
                            content = content.replace(/__PRE_PLACEHOLDER_(\d+)__/g, function(_, idx) {
                                return prePlaceholders[idx];
                            });

                            // 写入 WYSIWYG 编辑器
                            this.we.innerHTML = content;
                        },

                        bindWysiwygSync: function() {
                            var self = this;

                            if (!this.we) return;
                            addEvent(this.we, 'keyup', function() {
                                if (!self.modeCheckbox.checked) { // normal-mode
                                    self.syncWysiwygToSource();
                                }
                            });

                            addEvent(this.we, 'blur', function() {
                                if (!self.modeCheckbox.checked) { // normal-mode
                                    self.syncWysiwygToSource();
                                }
                            });
                        },
                        bindPreviewSync: function() {
                            var self = this;

                            // 只针对 split-mode/source-mode textarea
                            addEvent(this.se, 'keyup', function() {
                                self.updatePreview();
                            });
                            addEvent(this.se, 'blur', function() {
                                self.updatePreview();
                            });

                        },
                        updatePreview: function() {
                            var content = this.se.value;

                            // 1. 替换表情文本为表情图片
                            content = content.replace(/(:[a-zA-Z0-9_?!]+:)/g, function(match) {
                                var src = smiliesMap[match];
                                if (src) {
                                    return '<img class="smiley" src="' + src + '" alt="' + match + '">';
                                }
                                return match;
                            });

                            // 2. 替换 Markdown 图片语法 ![alt](url) → <img>
                            content = content.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, function(_, alt, url) {
                                return '<img class="image" src="' + url + '" alt="' + alt + '">';
                            });

                            // 3. 替换多行代码块 ```...``` → <pre><code>...</code></pre>
                            content = content.replace(/```([\s\S]*?)```/g, function(_, code) {
                                return '<pre><code>' + code.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</code></pre>';
                            });

                            // 4. 替换行内代码 `...` → <code>...</code>
                            // 注意：先处理多行代码块再处理行内代码，避免冲突
                            content = content.replace(/`([^`\n]+)`/g, function(_, code) {
                                return '<code>' + code.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</code>';
                            });

                            // 5. 换行 → <br>，忽略代码块内换行（因为多行代码块已经用 <pre> 包裹）
                            // 简单做法：先临时替换 <pre>...</pre> 中的换行为占位符
                            content = content.replace(/<pre><code>[\s\S]*?<\/code><\/pre>/gi, function(match) {
                                return match.replace(/\n/g, '\u0000'); // 临时占位
                            });

                            // 6. 剩余换行转 <br>
                            content = content.replace(/\n/g, '<br>');

                            // 7. 恢复代码块内部的换行
                            content = content.replace(/\u0000/g, '\n');

                            // 8. 输出到预览
                            this.pe.innerHTML = '<div class="preview-container">' + content + '</div>';

                            if (isIE(6)) {
                                var images = $('.image', this.pe);
                                for (var i = 0; i < images.length; i++) {
                                    var img = images[i];
                                    if (img.height > 100) img.height = 100;
                                    if (img.width > 200) img.width = 200;
                                }
                            }
                        },

                        renderCommentList: function(list) {
                            if (!list) return;
                            var contents = $('comment-content', $(list));
                            for (var i = 0; i < contents.length; i++) {
                                this.renderContent(contents[i]);
                            }
                        },

                        renderContent: function(el) {
                            if (!el || !smiliesMap) return;

                            var html = el.innerHTML;

                            // 防止重复渲染
                            if (html.indexOf('class="smiley"') === -1) {
                                for (var code in smiliesMap) {
                                    if (!smiliesMap.hasOwnProperty(code)) continue;

                                    var img =
                                        '<img class="smiley" src="' +
                                        smiliesMap[code] +
                                        '" alt="' + code + '" />';

                                    html = replaceAll(html, code, img);
                                }

                                el.innerHTML = html;
                            }

                            // 其他渲染
                        }
                    };

                    if (document.readyState === 'complete') {
                        window.CommentEditor.init();
                    } else if (document.attachEvent) {
                        document.attachEvent('onreadystatechange', function() {
                            if (document.readyState === 'complete') {
                                window.CommentEditor.init();
                            }
                        });
                    } else {
                        window.onload = function() {
                            window.CommentEditor.init();
                        };
                    }


                })();
            </script>

            <style>
                .respond,
                .comment-list-wrapper {
                    background: #f9f9f9;
                    border: 1px solid #dfdfdf;
                    margin-bottom: 10px;
                    position: relative;
                }

                .respond .hidden {
                    display: none;
                    *display: none !important;
                }

                .respond .cancel-comment-reply {
                    position: absolute;
                    top: 8px;
                    right: 8px;
                }

                .respond .respond-header {
                    padding: 10px;
                    border-bottom: 1px dotted #ddd;
                }

                .respond .respond-title {
                    font-size: 16px;
                    font-weight: bold;
                    line-height: 1;
                    text-shadow: 1px 1px 2px #ccc;
                }

                .respond .respond-body {
                    background-color: #fff;
                    position: relative;
                    *zoom: 1;
                }

                .respond .respond-body input[type="text"],
                .respond .respond-body textarea {
                    border: 1px solid #222;
                }


                .respond #welcome-back {
                    padding: 10px;
                    margin-bottom: -5px;
                }

                .respond .respond-body .login-meta {
                    padding: 10px;
                    *height: 54px;
                    overflow: hidden;
                    margin-bottom: -10px;
                    *margin-bottom: 0;
                }

                .respond .respond-body .login-meta li {
                    display: inline-block;
                }

                .respond .login-meta li {
                    float: left;
                    width: 25%;
                }

                .respond .login-meta li.urltext {
                    width: 33%;
                }

                .respond .login-meta input {
                    width: 100%;
                    height: 26px;
                    font-size: 14px;
                    padding-left: 5px;
                    box-sizing: border-box;
                    *height: 22px;
                    border-radius: 0;
                }

                .respond .login-meta label .required {
                    color: #C04E37;
                    padding-left: 5px;
                }

                .respond #welcome-back+#comment-editor-group,
                .respond .login-meta.hidden+#comment-editor-group {
                    margin-top: -10px;
                }

                .comment-editor-group {
                    padding: 10px;
                    *padding-top: 5px;
                    *zoom: 1;
                }

                .comment-editor-group.split-mode #comment-wysiwyg,
                .comment-editor-group.normal-mode #comment-source,
                .comment-editor-group.normal-mode #comment-preview,
                .comment-editor-group.source-mode #comment-wysiwyg,
                .comment-editor-group.source-mode #comment-preview {
                    display: none;
                }

                .comment-editor-group .comment-editor {
                    min-height: 100px;
                    *height: 100px;
                    width: 100%;
                    font-size: 14px;
                    padding: 5px;
                    box-sizing: border-box;
                    border: 1px solid #222;
                    resize: vertical;
                    *display: inline;
                }

                #comment-source {
                    overflow: hidden;
                    resize: none;
                    line-height: 18px;
                    height: auto;
                }

                #comment-preview {
                    overflow: hidden;
                    min-height: 100px;
                    *height: 100px;
                    border: 1px solid #ccc;
                }

                #comment-source,
                #comment-preview {
                    font: 13px/1.5 "Lucida Grande", "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
                    padding: 5px;
                    box-sizing: border-box;
                }

                #comment-preview .preview-container {
                    line-height: 21px;

                }

                * html #comment-source {
                    /* IE6不支持min-height，使用expression模拟 */
                    height: expression(this.scrollHeight > 100 ? this.scrollHeight + "px" : "100px"
                        );
                }


                .comment-editor-group.split-mode .comment-editor,
                .comment-editor-group.split-mode #comment-preview {
                    *float: left;
                    *width: 292px;
                    *display: inline;
                }

                .comment-parent .comment-editor-group.split-mode .comment-editor,
                .comment-parent .comment-editor-group.split-mode #comment-preview {
                    _width: 262px;
                }

                .comment-child .comment-editor-group.split-mode .comment-editor,
                .comment-child .comment-editor-group.split-mode #comment-preview {
                    _width: 232px;
                }


                @media \0screen {

                    .comment-editor-group.split-mode .comment-editor {
                        float: left;
                        width: 304px;
                    }

                    .comment-editor-group.split-mode #comment-preview {
                        float: left;
                        width: 304px;
                        padding: 0;
                    }

                    .comment-editor-group.split-mode #comment-preview .preview-container {
                        padding: 4px;
                    }
                }

                #comment-wysiwyg img::after {
                    content: '\u200B';
                }

                #comment-wysiwyg img.image,
                .respond #comment-preview img.image {
                    max-height: 100px;
                    max-width: 200px;
                }

                .respond #respond-similies-panel {
                    padding: 0 10px 10px;
                    *padding-top: 5px;
                    display: none;
                    background: #fff;
                }

                .respond .respond-footer {
                    *zoom: 1;
                    border-top: 1px dotted #ddd;
                    height: 32px;
                    display: flex;
                }


                .respond .respond-footer #editor-mode,
                .respond .respond-footer #respond-similies,
                .respond .respond-footer #respond-image {
                    *float: left;
                    /* IE 6/7 */
                    float: left \9;
                    /* IE 8/9 */
                }

                .respond .btn-primary {
                    color: #fff;
                    background-color: #0093F0;
                    border: 0px;
                    padding: 3px 8px;
                    height: 24px;
                    transition: background-color .25s ease;
                    box-sizing: border-box;
                }

                .respond .btn-primary:hover {
                    background-color: #0081c2;
                }

                .respond .btn-primary:active {
                    background-color: #006699;
                }

                .respond .btn-primary:focus {
                    background-color: #0081c2;
                }

                .respond .btn-primary:disabled {
                    background-color: #0093F0;
                    cursor: not-allowed;
                }

                .respond .btn-primary:disabled:hover {
                    background-color: #0093F0;
                }

                .respond .btn-secondary {
                    color: #0093F0;
                    background-color: #fff;
                    border: 1px solid #0093F0;
                    padding: 3px 8px;
                    height: 24px;
                    *line-height: 16px;
                    transition: background-color .25s ease;
                }

                .respond .btn-secondary:hover {
                    color: #fff;
                    background-color: #0081c2;
                }

                .respond .btn-secondary:active {
                    color: #fff;
                    background-color: #006699;
                }

                .respond-footer .btn {
                    margin: 5px;
                    cursor: pointer;
                }

                .respond #respond-similies {
                    margin-left: 10px;
                    *float: left;
                }

                .respond #editor-mode {
                    margin: 5px;
                    display: flex;
                    align-items: center;
                }

                .respond #respond-submit {
                    float: right;
                    margin-left: auto;
                    margin-right: 10px;
                }

                .comments-count {
                    padding: 10px;
                    border-bottom: 1px dotted #ddd;
                    font-weight: bold;
                }

                .comment-list {
                    background: #fff;
                }

                .comment-parent {
                    border-bottom: 1px solid #ddd;
                }

                .comment-body {
                    position: relative;
                    zoom: 1;
                    margin: 0 5px 0 50px;
                    padding: 5px 0;
                }

                .comment-author {
                    position: relative;
                }

                .comment-child .comment-body {
                    margin: 0;
                    padding-bottom: 0;
                }

                .comment-body .comment-author,
                .comment-body .comment-meta {
                    display: inline-block;
                    *display: inline;
                }

                .comment-body .comment-author a {
                    font-weight: bold;
                    font-size: 16px;
                }

                .comment-body .comment-meta a {
                    color: #333;
                    font-size: 14px;
                }

                .comment-body .comment-author span {
                    position: absolute;
                    left: -40px;
                    top: 9px;
                }

                .comment-body .comment-reply {
                    position: absolute;
                    top: 5px;
                    right: 5px;
                }

                .comment-body .comment-content img {
                    max-width: 280px;
                    border: 1px solid #ddd;
                    padding: 4px;
                    background: #fff;
                    -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
                    -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
                    box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
                }

                .comment-body .comment-content img.smiley {
                    vertical-align: -3px;
                    margin-right: 2px;
                    border: 0;
                    padding: 0;
                    background: transparent;
                    -webkit-box-shadow: unset;
                    -moz-box-shadow: unset;
                    box-shadow: unset;

                }
            </style>
        </div>
        <div class="comment-list-wrapper">
        <?php else: ?>
            <div class="msg-error"><?php _e("评论已关闭"); ?></div>
        <?php endif; ?>
        <?php if ($comments->have()): ?>
            <div class="comments-count">
                <?php $this->commentsNum(_t('当前暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?>
            </div>
            <div id="comments-box" class="comments-box">
                <?php $comments->listComments(); ?>
                <?php $comments->pageNav(); ?>
            </div>
        <?php endif; ?>
        </div>
</div>