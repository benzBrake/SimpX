<?php


class SUtils
{
    private static $_instance = null;
    private $_sidebarStatus = null;
    private $_pluginStatus = array(); // 缓存插件状态

    private function __construct() {} // 禁止直接实例化

    /**
     * 获取单例实例
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 获取侧边栏状态（带缓存）
     */
    public function getSidebarStatus()
    {
        if ($this->_sidebarStatus === null) {
            $this->_sidebarStatus = $this->_computeSidebarStatus();
        }
        return $this->_sidebarStatus;
    }

    /**
     * 检查插件是否启用（带缓存）
     * 
     * @param string $name 插件名称
     * @return bool 是否启用
     */
    public function isPluginEnabled($name)
    {
        if (!isset($this->_pluginStatus[$name])) {
            $plugins = Typecho_Plugin::export();
            $this->_pluginStatus[$name] = isset($plugins['activated'][$name]);
        }
        return $this->_pluginStatus[$name];
    }

    /**
     * 计算侧边栏状态（原始逻辑）
     */
    private function _computeSidebarStatus()
    {
        $options = Helper::options();

        $hasLeftSidebar = isset($options->leftSidebarModules) &&
            is_array($options->leftSidebarModules) &&
            !empty($options->leftSidebarModules);

        $hasRightSidebar = isset($options->rightSidebarModules) &&
            is_array($options->rightSidebarModules) &&
            !empty($options->rightSidebarModules);

        if ($hasLeftSidebar && $hasRightSidebar) {
            $wrapperClass = 'with-both-sidebars';
        } elseif ($hasLeftSidebar) {
            $wrapperClass = 'with-left-sidebar';
        } elseif ($hasRightSidebar) {
            $wrapperClass = 'with-right-sidebar';
        } else {
            $wrapperClass = 'no-sidebar';
        }

        return Typecho_Config::factory(array(
            'showLeftSidebar' => $hasLeftSidebar,
            'showRightSidebar' => $hasRightSidebar,
            'wrapperClass' => $wrapperClass
        ));
    }
}

/**
 * 检查插件是否启用
 * 
 * @param string $name 插件名称
 * @return bool 是否启用
 */
function isPluginEnabled($name)
{
    return SUtils::getInstance()->isPluginEnabled($name);
}
/**
 * 获取侧边栏状态
 */
function getSiderbarStatus()
{
    return SUtils::getInstance()->getSidebarStatus();
}

function themeFields($layout)
{
    if ($_SERVER['SCRIPT_NAME'] == "/admin/write-post.php") {
        $copyright = new Typecho_Widget_Helper_Form_Element_Textarea('copyright', NULL, NULL, _t('文章来源'), _t('填入链接，一行一个（留空为不显示）'));
        $copyright->input->setAttribute('style', 'width: 100%');
        $layout->addItem($copyright);
        echo '
<style id="copyright-editor-style">
.copyright-editor{
    border:1px solid #ddd;
    padding:8px;
    margin-top:6px;
    background:#f9f9f9;
    position: relative;
}
.copyright-editor-label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}
#copyright-add {
    position: absolute;
    top: 8px;
    right: 8px;
}
.copyright-item {
    margin-bottom:6px;
    cursor:move;
    padding:4px;
    border:1px solid #ccc;
    background:#f9f9f9;
    list-style: none;
}
.copyright-item input{
    width:40%;
    margin-right:6px;
    float:left;
}
.copyright-item .delete-btn{
    float:left;
    cursor:pointer;
    background-color: #ffd9d1;
}
.clear{clear:both;}
</style>

<div class="copyright-editor" id="copyright-editor" style="display: none">
    <label class="copyright-editor-label"><i class="i-caret-right"></i>版权所有</label>
    <button type="button" id="copyright-add" class="btn btn-xs primary">添加文章来源</button>
    <div id="copyright-list"></div>
</div>

<script id="copyright-editor-script" src="' . Helper::options()->themeUrl('assets/js/copyright-editor.js', 'SimpX') . '" dragsortsrc="' . Helper::options()->themeUrl('assets/js/jquery.dragsort.min.js', 'SimpX') . '"></script>';
    }
}
function themeConfig($form)
{
    echo ('<style>body{font-family:Microsoft Yahei,微软雅黑;}</style><div style="font-size:14px;border-left:5px solid #0093f0;padding-left:8px;"><h2>SimpX</h2>&nbsp;Theme&nbsp;版本：1.5&nbsp;&nbsp;<strong>主题设置页</strong>&nbsp;&nbsp;<a href="http://doufu.ru/typecho-theme-simpx.html" title="检查更新">检查更新</a></div>');
    $topNotice = new Typecho_Widget_Helper_Form_Element_Text('topNotice', NULL, NULL, _t('顶部公告'), _t('这里可以输入一段文字显示顶部公告。（留空为不显示）'));
    $form->addInput($topNotice);

    $weibo = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, NULL, _t('微博链接'), _t('这里可以输入微博链接。（留空为不显示）'));
    $form->addInput($weibo);

    $renren = new Typecho_Widget_Helper_Form_Element_Text('renren', NULL, NULL, _t('人人链接'), _t('这里可以输入人人链接。（留空为不显示）'));
    $form->addInput($renren);

    $qq = new Typecho_Widget_Helper_Form_Element_Text('qq', NULL, NULL, _t('QQ链接'), _t('这里可以输入QQ链接。（留空为不显示）'));
    $form->addInput($qq);

    $pinterest = new Typecho_Widget_Helper_Form_Element_Text('pinterest', NULL, NULL, _t('Pinterest链接'), _t('这里可以输入Pinterest链接。（留空为不显示）'));
    $form->addInput($pinterest);

    $leftSidebarModules = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'leftSidebarModules',
        array(
            'ShowCategory' => _t('显示分类'),
            'ShowArchive' => _t('显示归档'),
            'ShowBlogroll' => _t('显示友情链接'),
            'ShowQRCode' => _t('显示二维码'),
            'ShowOther' => _t('显示其它杂项'),
        ),
        array('ShowCategory', 'ShowArchive', 'ShowQRCode'),
        _t('左侧边栏选项')
    );
    $form->addInput($leftSidebarModules->multiMode());

    $rightSidebarModules = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'rightSidebarModules',
        array(
            'ShowSearchBox' => _t('显示搜索工具'),
            'ShowRecentPosts' => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowTagCloud' => _t('显示标签云'),
        ),
        array('ShowSearchBox', 'ShowRecentPosts', 'ShowRecentComments', 'ShowTagCloud'),
        _t('右侧边栏选项')
    );
    $form->addInput($rightSidebarModules->multiMode());

    $compressHtml = new Typecho_Widget_Helper_Form_Element_Radio(
        'compressHtml',
        array(
            '0' => _t('关闭'),
            '1' => _t('开启'),
        ),
        true,
        _t('HTML压缩'),
        _t('开启后，将压缩HTML代码，减少页面体积，提高加载速度。')
    );
    $form->addInput($compressHtml);
}

function themeInit($self)
{
    $options = Helper::options();
    //评论启用 markdown 语法
    $options->commentsMarkdown = true;
    //允许评论使用表情
    //允许图片标签
    $options->commentsHTMLTagAllowed .= '<img class="" src="" data-src="" alt="" style="" title="" alt=""/>';

    $request = $self->request;
    if ($self->is('index')) {
        if ($request->is('qrcode')) {
            require_once dirname(__FILE__) . '/libs/qrcode.php';
            $text = $request->filter('xss')->filter('strval')->get('text');
            if (empty($text)) {
                $text = Helper::options()->siteUrl;
            }
            QRcode::png($text, false, 'L', 10, 2);
            die();
        }
    }
}


function compressHtml($html_source)
{
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) { // JS代码，包含“//”注释的，单行代码不处理
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) { // 对含有“//”的行做处理
                    if (substr(trim($tmp), 0, 2) == '//') { // 开头是“//”的就是注释
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && ($key == 0 || $chars[$key - 1] != '\\') && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && ($key == 0 || $chars[$key - 1] != '\\') && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && isset($chars[$key + 1]) && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key); // 不是字符串内的就是注释
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c); // 清除换行符，清除制表符
        $c = preg_replace('/\\s{2,}/', ' ', $c); // 清除额外的空格
        $c = preg_replace('/>\\s</', '> <', $c); // 清除标签间的空格
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c); // 清除 CSS & JS 的注释
        $c = preg_replace('/<!--[^!]*-->/', '', $c); // 清除 HTML 的注释
        $compress .= $c;
    }
    return $compress;
}
