<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 虾米皮皮乐主题框架核心函数
 * Class XCore
 */
class XCore
{
    /**
     * 从 Widget_Options 对象获取 Typecho 选项值（文本型）
     * @param string $key 选项 Key
     * @param mixed $default 默认值
     * @param string $method 测空值方法
     * @return string
     */
    public static function configStr($key, $default = '', $method = 'empty')
    {
        $value = Helper::options()->$key;
        if ($method === 'empty') {
            return empty($value) ? $default : $value;
        } else {
            return call_user_func($method, $value) ? $default : $value;
        }

    }

    /**
     * 从 Widget_Options 对象获取 Typecho 选项值（数组型）
     * @param string $key 选项 Key
     * @param array $default 默认值
     * @return array
     */
    public static function configArray($key, array $default = [])
    {
        $value = Helper::options()->$key;
        return is_array($value) ? $value : $default;
    }

    /**
     * 直接查库获取获取数组选项
     * @param string $key 关键字
     * @param array $default 默认值
     * @return array
     * @throws Typecho_Db_Exception
     */
    public static function queryArrayConfigFromDB($key, array $default = [])
    {
        $db = Typecho_DB::get();
        $select = $db->select('value')->from('table.options')->where('table.options.name = ? and table.options.user = 0', $key);
        $result = $db->fetchRow($select);
        if (count($result)) {
            return unserialize($result['value']);
        }
        return $default;
    }

    /**
     * 保存数组选项
     * @param string $key
     * @param array $config
     * @return mixed
     * @throws Typecho_Db_Exception
     */
    public static function saveArrayConfig($key, array $config)
    {
        $db = Typecho_DB::get();
        $select = $db->select('value')->from('table.options')->where('table.options.name = ? and table.options.user = 0', $key);
        $result = $db->fetchRow($select);
        if (count($result)) {
            $update = $db->update('table.options')->rows(array('value' => serialize($config)))->where('table.options.name = ? and table.options.user = 0', $key);
            return $db->query($update);
        }
        $insert = $db->insert('table.options')->rows(array('name' => $key, 'user' => 0, 'value' => serialize($config)));
        return $db->query($insert);
    }

    /**
     * 数字按模板输出
     */
    public static function parseNum()
    {
        $args = func_get_args();
        if (count($args) === 0) {
            throw new InvalidArgumentException("At least one argument!");
        }

        $value = array_shift($args);

        if (!$args) {
            $args[] = '%d';
        }

        $num = intval($value);

        return sprintf(array_key_exists($num, $args) ? $args[$num] : array_pop($args), $num);
    }

    /**
     * 一行一个文本框转数组
     *
     * @param string $textarea 文本框内容
     * @return array
     */
    public static function textareaToArr($textarea)
    {
        $str = str_replace(array("\r\n", "\r", "\n"), "\n", $textarea);
        if ($str == "") {
            return null;
        }

        return explode("\n", $str);
    }

    /**
     * 获取主题文件实际路径
     * @param string $file 文件相对路径，默认为空
     * @return string
     */
    public static function themeFile($file = '')
    {
        return Helper::options()->themeFile('SimpX', $file);
    }

    /**
     * 获取 admin 路径
     * @param string $uri 补充路径
     * @return string
     */
    public static function adminUrl($uri)
    {
        return Typecho_Common::url($uri, Helper::options()->adminUrl);
    }


    /**
     * 获取主题目录下资源链接
     * @param string $uri 目录内路径
     * @return string
     */
    public static function themeUrl($uri)
    {
        return Helper::options()->themeUrl($uri, 'SimpX');
    }

    /**
     * 获取 Favicon 地址
     * @return string
     */
    public static function getFavicon()
    {
        return XCore::configStr("XFavicon", XCore::themeUrl('assets/img/favicon.ico'));
    }

    /**
     * 获取gravatar头像地址
     *
     * @param String|null $mail 邮箱地址
     * @param mixed $gravatarOptions 配置
     * @return String
     * @date 2020-04-10
     */
    public static function gravatarUrl($mail = null, $gravatarOptions = null)
    {
        $gravatarOptions = Typecho_Config::factory($gravatarOptions);
        $gravatarOptions->setDefault(array(
            'prefix' => XCore::configStr('XGravatarPrefix', 'https://secure.gravatar.com/avatar/'),
            'itemClass' => 'avatar',
            'size' => '32',
            'rating' => XCore::configStr('commentsAvatarRating'),
            'default' => 'mp',
        ));
        if (empty($mail)) {
            return XCore::themeUrl('/assets/img/default-avatar.png');
        }
        $url = $gravatarOptions->prefix;
        $url .= md5(strtolower(trim($mail)));
        $url .= '?s=' . $gravatarOptions->size;
        $url .= '&amp;r=' . $gravatarOptions->rating;
        $url .= '&amp;d=' . $gravatarOptions->default;
        return $url;
    }

    /**
     * 输出头像
     * @param string|null $mail
     * @param mixed $gravatarOptions
     */
    public static function gravatar($mail = null, $gravatarOptions = null)
    {
        $gravatarOptions = Typecho_Config::factory($gravatarOptions);
        $gravatarOptions->setDefault(array(
            'prefix' => XCore::configStr('XGravatarPrefix', 'https://secure.gravatar.com/avatar/'),
            'itemClass' => 'avatar',
            'size' => '32',
            'rating' => Helper::options()->commentsAvatarRating,
            'default' => 'mp',
        ));
        echo '<img ' . ($gravatarOptions->itemClass === '' ? '' : ' class="' . $gravatarOptions->itemClass . '" ') . 'src="' . XCore::gravatarUrl($mail, $gravatarOptions) . '" width="' . $gravatarOptions->size . 'px" height="' . $gravatarOptions->size . 'px" />';
    }

    public static function getQRCodeUrl($text = null, $forceLocal = false)
    {
        $text = empty($text) ? XCore::configStr('siteUrl') : $text;
        $baseUrl = $forceLocal || empty(XCore::configStr('XQrcodeApi')) ? Typecho_Common::url('?qrcode&text={content}', XCore::configStr('index')) : XCore::configStr('XQrcodeApi');
        return str_replace("{content}", $text, $baseUrl);
    }

    /**
     * 文章对象转文本
     * @param mixed $widget 文章对象，可以是数组
     * @param string $template 模板
     * @param false $isArray 是否为数组
     * @return string
     */
    public static function toString($widget, string $template, bool $isArray = false): string
    {
        if ($isArray) {
            return preg_replace_callback(
                "/\{([_a-z0-9]+)\}/i",
                function ($matches) use ($widget) {
                    return $widget[$matches[1]];
                },
                $template
            );
        }
        return preg_replace_callback(
            "/\{([_a-z0-9]+)\}/i",
            function ($matches) use ($widget) {
                return $widget->{$matches[1]};
            },
            $template
        );
    }

    /**
     * 检查插件是否启用
     * @param String $pluginName
     * @return boolean
     */
    public static function isPluginEnabled($pluginName)
    {
        return array_key_exists($pluginName,  Typecho_Plugin::export()['activated']);
    }


    /**
     * 获取文章摘要
     * @param Typecho_Widget|Widget_Archive|Widget_Abstract_Contents $item
     * @param int|null $length 长度
     * @param string $trim 结尾
     * @return string
     */
    public static function getAbstract($item, int $length = null, string $trim = '...'): string
    {
        $content = $item->excerpt;
        $length = $length == null ? XCore::configStr('XAbstractLength', 200) : $length;
        $abstract = Typecho_Common::subStr(strip_tags($content), 0, $length, $trim);
        if ($item->password) {
            $abstract = _t(_t("加密文章，请前往内页查看详情"));
        }
        if (empty($abstract)) $abstract = _t("暂无简介");
        return $abstract;
    }
}
