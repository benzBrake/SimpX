<?php
function themeConfig($form)
{
    // 增加数据库字段
    $db = Typecho_Db::get();
    $_prefix = $db->getPrefix();
    try {
        if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')->page(1, 1)))) {
            $db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `views` INT DEFAULT 0;');
        }
        if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')->page(1, 1)))) {
            $db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `agree` INT DEFAULT 0;');
        }
    } catch (Exception $e) {
    }

    echo('<style>body{font-family:Microsoft Yahei,微软雅黑;}</style><div style="font-size:14px;border-left:5px solid #0093f0;padding-left:8px;"><h2>SimpX</h2>&nbsp;Theme&nbsp;版本：1.5&nbsp;&nbsp;<strong>主题设置页</strong>&nbsp;&nbsp;<a href="http://doufu.ru/typecho-theme-simpx.html" title="检查更新">检查更新</a></div>');
    $topNotice = new Typecho_Widget_Helper_Form_Element_Text('topNotice', NULL, NULL, _t('顶部公告'), _t('这里可以输入一段文字显示顶部公告。（留空为不显示）'));
    $form->addInput($topNotice);
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock',
        array('ShowSearchBox' => _t('显示搜索工具'),
            'ShowRecentPosts' => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowTagCloud' => _t('显示标签云'),
            'ShowCategory' => _t('显示分类'),
            'ShowArchive' => _t('显示归档'),
            'ShowOther' => _t('显示其它杂项'),
            'ShowBlogroll' => _t('显示友情链接'),
            'ShowQRCode' => _t('显示二维码')),
        array('ShowRecentPosts', 'ShowRecentComments', 'ShowTagCloud', 'ShowCategory', 'ShowArchive', 'ShowQRCode',), _t('边栏选项'));
    $form->addInput($sidebarBlock->multiMode());
}

/**
 * 主题必须类
 */
class X extends Typecho_Widget
{
    private $activated;
    private $themeInfo;
    private $db;
    private static $_instance = NULL;
    private $smiliesRegex;

    /**
     * 构造函数
     */
    public function __construct($request, $response, $params = null)
    {
        parent::__construct($request, $response, $params);
        $this->db = Typecho_Db::get();
        $this->activated = Typecho_Plugin::export()['activated'];
        $this->thomeInfo = Typecho_Plugin::parseInfo(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'index.php');
        $this->initSmiliesRegex();
    }

    private function initSmiliesRegex()
    {
        $smiliesRegex = array(
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
            ':???:' => 'icon_confused.gif',
            ':cool:' => 'icon_cool.gif',
            ':lol:' => 'icon_lol.gif',
            ':mad:' => 'icon_mad.gif',
            ':twisted:' => 'icon_twisted.gif',
            ':roll:' => 'icon_rolleyes.gif',
            ':wink:' => 'icon_wink.gif',
            ':idea:' => 'icon_idea.gif',
            ':arrow:' => 'icon_arrow.gif',
            ':neutral:' => 'icon_neutral.gif',
            ':cry:' => 'icon_cry.gif',
            ':mrgreen:' => 'icon_mrgreen.gif',
            '8-)' => 'icon_cool.gif',
            '8-O' => 'icon_eek.gif',
            ':-(' => 'icon_sad.gif',
            ':-)' => 'icon_smile.gif',
            ':-?' => 'icon_confused.gif',
            ':-D' => 'icon_biggrin.gif',
            ':-P' => 'icon_razz.gif',
            ':-o' => 'icon_surprised.gif',
            ':-x' => 'icon_mad.gif',
            ':-|' => 'icon_neutral.gif',
            ';-)' => 'icon_wink.gif',
            '8)' => 'icon_cool.gif',
            '8O' => 'icon_eek.gif',
            ':(' => 'icon_sad.gif',
            ':)' => 'icon_smile.gif',
            ':?' => 'icon_confused.gif',
            ':D' => 'icon_biggrin.gif',
            ':P' => 'icon_razz.gif',
            ':o' => 'icon_surprised.gif',
            ':x' => 'icon_mad.gif',
            ':|' => 'icon_neutral.gif',
            ';)' => 'icon_wink.gif',
        );
        foreach ($smiliesRegex as $key => $img) {
            $smiley = preg_quote($key, '#');
            $imgUrl = Typecho_Common::url("assets/img/Smilies/$img", Helper::options()->themeUrl);
            $regex = "#(?s)<pre[^<]*>.*?<\/pre>(*SKIP)(*F)|$smiley#ism";
            $this->smiliesRegex[$key] = ['regex' => $regex, 'replacement', 'replacement' => "<img src=\"$imgUrl\" />"];
        }
    }

    /**
     * 检查插件是否启用
     * @param String $pluginName
     * @return boolean
     */
    public function isPluginEnabled($pluginName)
    {
        return array_key_exists($pluginName, $this->activated);
    }

    /**
     * 获取主题版本
     * @return mixed
     */
    public function themeVersion()
    {
        return $this->themeInfo['version'];
    }

    /**
     * 抛出 JSON
     * @param $json
     * @return void
     */
    public function throwJson($json)
    {
        $this->response->throwJson($json);
    }


    /**
     * 输出正常信息
     * @param array $data
     * @param $msg
     */
    public function throwMsg($data = [], $msg = NULL)
    {
        $base = ['status' => 200];
        if ($msg) $base['msg'] = $msg;
        if (count($data)) $base['data'] = $data;
        $this->throwJson($base);
    }

    /**
     * 输出错误信息
     * @param $msg
     * @param int $code
     */
    public function throwErr($msg = NULL, $code = 500)
    {
        $base = ['status' => $code];
        if ($msg) $base['msg'] = $msg;
        $this->throwJson($base);
    }

    /**
     * 评论内容处理
     *
     * @access public
     * @param string $content 评论内容
     * @return string
     */
    public static function commentsEx(string $content, $archive, $lastResult)
    {
        $content = empty($lastResult) ? $content : $lastResult;

        $options = Helper::options();
        //允许图片标签
        $options->commentsHTMLTagAllowed .= '<img src="" alt="" style=""/>';
        return self::parseSmilies($content);
    }

    /**
     * 评论发表内容过滤
     * @param $comment
     * @param $archive
     * @param $lastResult
     * @return void
     */
    public static function commentPostFilter($comment, $archive, $lastResult) {
        $comment = empty($lastResult) ? $comment : $lastResult;
        $sum= $_POST['sum'];
        switch($sum){
            case intval($_POST['num1']) + intval($_POST['num2']):
                break;
            case null:
                throw new Typecho_Widget_Exception(_t('对不起: 请输入验证码。<a href="javascript:history.back(-1)">返回上一页</a>','评论失败'));
                break;
            default:
                throw new Typecho_Widget_Exception(_t('对不起: 验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
        }
        return $comment;
    }

    /**
     * 整理表情数据
     *
     * @access private
     * @param string $content 正文内容
     * @return array
     */
    private static function parseSmilies(string $content)
    {
        foreach (X::alloc()->smiliesRegex as $item) {
            $content = preg_replace($item['regex'], $item['replacement'], $content);
        }
        return $content;
    }
}

$baseDir = Helper::options()->themeFile('SimpX', '');
require_once $baseDir . '/libs/XCore.php';
Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = ['X', 'commentsEx'];
Typecho_Plugin::factory('Widget_Feedback')->comment = ['X', 'commentPostFilter'];
/**
 * @param $archive
 * @return void
 */
function themeInit($archive)
{
    $archive->setThemeDir(XCore::themeFile('templates') . DIRECTORY_SEPARATOR);

    $request = $archive->request;
    $response = $archive->response;
    $notice = X::alloc()->widget('Widget_Notice');
    $db = Typecho_Db::get();
    /**
     * 增加二维码接口
     * @see Widget_Archive#is
     */
    if ($archive->is('index')) {
        /** 二维码接口 */
        if ($request->is('qrcode')) {
            require_once 'libs/external/qrcode.php';
            $text = $request->get('text');
            if (empty($text)) {
                $text = Helper::options()->siteUrl;
            }
            QRcode::png($text, false, 'L', 10, 2);
        }
    }
}

//算术验证评论
function spam_protection_math()
{
    $num1 = rand(1, 49);
    $num2 = rand(1, 49);
    echo "<label style=\"line-height:30px;\" for=\"math\"><code>$num1</code>+<code>$num2</code> = </label>\n";
    echo "<input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"25\" tabindex=\"4\" style=\"width:130px;float:right;\" placeholder=\"计算结果：\">\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}
