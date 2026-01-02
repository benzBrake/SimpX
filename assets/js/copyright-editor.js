(function () {

    // 1. 全局检查：如果已经加载过，直接退出整个脚本
    if (window.CopyrightEditorLoaded) {
        return;
    }
    // 标记为已加载（注意：这里只是防止脚本初始化逻辑重复，为了防止 domReady 重复触发，我们需要在内部再加一把锁）
    window.CopyrightEditorLoaded = true;

    if (!window.JSON) {
        window.JSON = {
            parse: function (jsonString) {
                return eval('(' + jsonString + ')');
            },
            stringify: function (obj) {
                // 简化版的 stringify，适用于基本对象
                if (typeof obj !== 'object' || obj === null) {
                    return String(obj);
                }

                var pairs = [];
                for (var key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        var value = obj[key];
                        var type = typeof value;
                        if (type === 'string') {
                            value = '"' + value.replace(/"/g, '\\"') + '"';
                        } else if (type === 'object' && value !== null) {
                            value = JSON.stringify(value);
                        }
                        pairs.push('"' + key + '":' + value);
                    }
                }
                return '{' + pairs.join(',') + '}';
            }
        };
    }
    // 安全的 JSON 解析函数
    function safeJsonParse (jsonString, defaultValue) {
        defaultValue = defaultValue || [];

        if (!jsonString || jsonString.trim() === '') {
            return defaultValue;
        }

        try {
            return window.JSON.parse(jsonString);
        } catch (e) {
            console && console.error("JSON解析错误:", e);
            return defaultValue;
        }
    }

    function domReady (callback) {
        // 定义一个标志位，确保 callback 在这个 domReady 调用中只执行一次
        var isExecuted = false;
        var oneTimeCallback = function () {
            if (isExecuted) return;
            isExecuted = true;
            callback();
        };

        // 如果DOM已经加载完成，直接执行回调
        if (document.readyState === "complete" || document.readyState === "interactive") {
            // 使用 setTimeout 确保它是异步执行的（通常更安全），或者直接执行
            // 为了防止当前执行栈阻塞导致重复，这里加一层微任务或直接调用均可，关键是 isExecuted 锁
            oneTimeCallback();
            return;
        }

        // 对于现代浏览器
        if (document.addEventListener) {
            document.addEventListener("DOMContentLoaded", function () {
                oneTimeCallback();
                // 执行后移除监听器，虽然 oneTimeCallback 有锁，但移除是个好习惯
                // 注意：这里使用 arguments.callee.caller 或者具名函数来移除，
                // 但为了简洁，依靠 oneTimeCallback 内部的 isExecuted 锁已经足够安全
            });
            return;
        }

        // 针对 IE 的逻辑 (保持你原有的逻辑，但替换 callback 为 oneTimeCallback)
        if (document.attachEvent) {
            document.attachEvent("onreadystatechange", function () {
                if (document.readyState === "complete" || document.readyState === "interactive") {
                    document.detachEvent("onreadystatechange", arguments.callee);
                    oneTimeCallback();
                }
            });

            try {
                // IE doScroll hack
                var top = document.documentElement.doScroll("left");
                oneTimeCallback();
            } catch (e) {
                var intervalId = setInterval(function () {
                    try {
                        var top = document.documentElement.doScroll("left");
                        clearInterval(intervalId);
                        oneTimeCallback();
                    } catch (e) { }
                }, 50);
            }
        }

        // 保底方案
        if (window.addEventListener) {
            window.addEventListener("load", oneTimeCallback);
        } else if (window.attachEvent) {
            window.attachEvent("onload", oneTimeCallback);
        }
    }

    domReady(function () {
        // 2. 双重保险：在回调内部再次检查（防止极其极端的竞态条件）
        if (window.CopyrightEditorExecuted) {
            return;
        }
        window.CopyrightEditorExecuted = true;

        var script_url = $('#copyright-editor-script').attr('dragsortsrc');

        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = script_url;

        // 设置加载完成后的回调
        script.onload = script.onreadystatechange = function () {
            if (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete') {
                initCopyrightEditor();

                script.onload = script.onreadystatechange = null;
            }
        };

        $('body').get(0).appendChild(script);
    });

    function initCopyrightEditor () {
        /**
         * 删除页面中重复的元素
         * ...
         */
        function removeDuplicateElements (id) {
            // ... (保持原样) ...
            var elements = [];
            var allElements = document.all || document.getElementsByTagName('*');
            for (var i = 0; i < allElements.length; i++) {
                if (allElements[i].id === id) {
                    elements.push(allElements[i]);
                }
            }
            if (elements.length > 1) {
                for (var j = 1; j < elements.length; j++) {
                    var parent = elements[j].parentNode;
                    if (parent) {
                        parent.removeChild(elements[j]);
                    }
                }
            }
        }

        removeDuplicateElements('copyright-editor-style');
        removeDuplicateElements('copyright-editor');
        var sc = $('#copyright-editor-script').attr('src');
        removeDuplicateElements('copyright-editor-script');

        var copyright_editor = $('#copyright-editor');
        copyright_editor.slideDown(500);

        var textarea = $('[name="fields[copyright]"]');
        var value = [];
        if (textarea.length > 0) {
            value = safeJsonParse(textarea.val(), []);
            if (value.length === 0) {
                textarea.parents('tr').remove();
            }
        }



        for (var i = 0; i < value.length; i++) {
            var info = value[i];

            // 创建条目 li
            var li = $('<li class="copyright-item"></li>');

            // input 内容
            var content = '\
<input type="text" class="item-title" placeholder="标题" style="width:25%;margin-right:6px;" value="' + (info.title || '') + '">\
<input type="text" class="item-url" placeholder="链接" style="width:35%;margin-right:6px;" value="' + (info.url || '') + '">\
<input type="text" class="item-author" placeholder="作者" style="width:20%;margin-right:6px;" value="' + (info.author || '') + '">\
<button class="delete-btn btn secondary">删除</button>\
<div style="clear:both"></div>';

            li.html(content);

            // 添加到列表
            $('#copyright-list').append(li);

            // 删除按钮
            li.find('.delete-btn').click((function (l) {
                return function () {
                    l.remove();
                    syncAllItemsToTextarea();
                }
            })(li));

            // 输入框内容改变时同步
            li.find('input').on('blur input', syncAllItemsToTextarea);
        }


        $('#copyright-add').click(function () {
            // 新建条目对象（空值）
            var info = { title: '', url: '', author: '' };

            // 创建条目 li
            var li = $('<li class="copyright-item"></li>');

            // input 内容
            var content = '\
<input type="text" class="item-title" placeholder="标题" style="width:25%;margin-right:6px;">\
<input type="text" class="item-url" placeholder="链接" style="width:35%;margin-right:6px;">\
<input type="text" class="item-author" placeholder="作者" style="width:20%;margin-right:6px;">\
<button class="delete-btn btn secondary">删除</button>\
<div style="clear:both"></div>';

            li.html(content);

            // 添加到列表
            $('#copyright-list').append(li);


            // 删除按钮
            li.find('.delete-btn').click(function () {
                li.remove();
                syncAllItemsToTextarea();
            });

            // 输入框内容改变时同步
            li.find('input').on('blur', syncAllItemsToTextarea);
            li.find('input').on('input', syncAllItemsToTextarea);

            // 同步一次
            syncAllItemsToTextarea();
        });

        makeListDraggable($('#copyright-list'));

        function syncAllItemsToTextarea () {
            var data = [];
            var hasError = false; // 标记是否有错误 URL

            $('#copyright-list li').each(function () {
                var $li = $(this);
                var title = $li.find('.item-title').val().trim();
                var url = $li.find('.item-url').val().trim();
                var author = $li.find('.item-author').val().trim();

                // 校验 URL
                if (url && !/^https?:\/\//i.test(url)) {
                    $li.find('.item-url').css('background-color', '#fdd'); // 红色背景提示
                } else {
                    $li.find('.item-url').css('background', ''); // 恢复正常背景
                }

                if (title || url || author) {
                    data.push({ title: title, url: url, author: author });
                }
            });


            saveJsonStringToTextarea(JSON.stringify(data));

        }


        function saveJsonStringToTextarea (value) {
            value = value.trim();
            var textarea = $('[name="fields[copyright]"]');
            if (value === '' || value === '[]') {
                textarea.parents('tr').remove();
            } else if (textarea.length === 0) {
                var tr = $(`<tr style="hidden">
    <td>
        <label class="typecho-label" for="copyright-0-9999">文章来源</label>
    </td>
    <td colspan="3">
        <div>
            <textarea id="copyright-0-9999" name="fields[copyright]" style="width: 100%" tc-textcontent="true" data-tc-id="0.4758610624173001"></textarea>
            <p class="description">填入链接，一行一个（留空为不显示）</p>
        </div>
    </td>
</tr>`);
                tr.appendTo($('.typecho-list-table tbody'));
                textarea = tr.find('textarea');
                textarea.val(value);
            } else {
                textarea.val(value);
            }
        }

        function makeListDraggable (list) {
            $(list).dragsort({
                dragSelector: 'li',
                dragBetween: false,
                dragEnd: syncAllItemsToTextarea
            });
        }
    }
})();
