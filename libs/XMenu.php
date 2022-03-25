<?php


class XMenu
{

    /**
     * 显示菜单，依赖 TeMenu 插件
     *
     * @param string $slug
     * @return void
     */
    public static function show($slug)
    {
        if (X::alloc()->isPluginEnabled('TeMenu')) {
            $navigation = json_decode(Typecho_Widget::widget('Widget_Options')->plugin('TeMenu')->navigation, true);
            if (!array_key_exists($slug, $navigation)) {
                return;
            }
            $menu = $navigation[$slug]['menu'];
            $html = self::callback($menu, 'current=current-menu-item&caret=' . XMenu::moreIcon());
            _e($html);
        } elseif (X::alloc()->isPluginEnabled('NavMenu')) {
            Typecho_Widget::widget('NavMenu_List')->navMenu('header', 'wrapTag=&current=current-menu-item&caret=' . XMenu::moreIcon());
        } else {
            /** @var Widget_Contents_Page_List $pages */
            Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages);
            $archive = Typecho_Widget::widget('Widget_Archive');
            while ($pages->next()) { ?>
                <li class="menu-item<?php if ($archive->is('page', $pages->slug)) : ?> current-menu-item<?php endif; ?>">
                    <a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                </li>
            <?php }
        }
    }

    /**
     * 生成菜单，依赖 TeMenu 插件
     *
     * @access public
     * @param Array $menu
     * @param null $options
     * @return String
     */
    protected static function callback(array $menu, $options = null)
    {
        $options = Typecho_Config::factory($options);
        $options->setDefault(
            array(
                'current' => 'current',
                'caret' => '+'
            )
        );
        $html = '';
        $archive = Typecho_Widget::widget('Widget_Archive');
        foreach ($menu as $v) {
            $v = self::getItem($v, $archive, $options);
            $v['icon'] = isset($v['icon']) ? '<i class="' . $v['icon'] . '"></i>' : '';
            $v['current'] && $v['current'] = ' ' . $options->current;
            $html .= '<li class="menu-item' . $v['current'] . (isset($v['children']) ? ' menu-has-children' : '') . '">';
            $html .= str_replace(
                array('{url}', '{name}', '{current}', '{icon}', '{caret}', '{target}'),
                array($v['url'], $v['name'], $v['current'], $v['icon'], $v['caret'], $v['target']),
                '<a href="{url}" {target}>{icon} {name} {caret}</a>'
            );
            if (isset($v['children'])) {
                $html .= '<ul class="sub-menu">';
                $html .= self::callback($v['children']);
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        return $html;
    }

    /**
     * 显示移动菜单，依赖 TeMenu 插件
     *
     * @param string $slug
     * @return void
     * @throws Typecho_Exception
     */
    public static function showMobi($slug)
    {
        if (X::alloc()->isPluginEnabled('TeMenu')) {
            $navigation = json_decode(Typecho_Widget::widget('Widget_Options')->plugin('TeMenu')->navigation, true);
            if (!array_key_exists($slug, $navigation)) {
                return;
            }
            $menu = $navigation[$slug]['menu'];
            $html = self::mobiCallback($menu, 'current=current-menu-item&caret=' . XMenu::moreIcon());
            _e($html);
        } elseif (X::alloc()->isPluginEnabled('NavMenu')) {
            Typecho_Widget::widget('NavMenu_List')->navMenu('header', 'wrapTag=&current=current-menu-item&caret=' . XMenu::moreIcon());
        } else {
            /** @var Widget_Contents_Page_List $pages */
            Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages);
            while ($pages->next()) { ?>
                <li class="menu-item menu-item-type-taxonomy menu-item-object-page menu-item-<?php $pages->cid(); ?>">
                    <a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                </li>
            <?php }
        }
    }

    /**
     * 生成移动菜单，依赖 TeMenu 插件
     *
     * @param array $menu 菜单名称
     * @param mixed $options 菜单选项
     * @return string
     */
    protected static function mobiCallback(array $menu, $options = null)
    {
        $options = Typecho_Config::factory($options);
        $options->setDefault(
            array(
                'current' => 'current',
                'caret' => '+'
            )
        );
        $html = '';
        $archive = Typecho_Widget::widget('Widget_Archive');
        foreach ($menu as $v) {
            $v = self::getItem($v, $archive, $options);
            $v['icon'] = empty($v['icon']) ? '' : '<i class="' . $v['icon'] . '"></i>';
            $v['current'] && $v['current'] = ' ' . $options->current;
            $html .= '<li class="menu-item menu-item-type-taxonomy menu-item-object-' . $v['type'] . $v['current'] . (isset($v['children']) ? ' menu-has-children' : '') . '">';
            $html .= str_replace(
                array('{url}', '{name}', '{current}', '{icon}', '{caret}', '{target}'),
                array($v['url'], $v['name'], $v['current'], $v['icon'], $v['caret'], $v['target']),
                '<a href="{url}" {target}>{icon} {name} {caret}</a>'
            );
            if (isset($v['children'])) {
                $html .= '<ul class="sub-menu">';
                $html .= self::mobiCallback($v['children']);
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        return $html;
    }

    /**
     * 返回更多菜单图标
     * @return string
     */
    public static function moreIcon()
    {
        return XIcon::get('menu-more');
    }

    /**
     * @param $v
     * @param $archive
     * @param $options
     * @return mixed
     */
    protected static function getItem($v, $archive, $options)
    {
        if ($v['type'] == 'category') {
            $category = Typecho_Widget::widget('Widget_Metas_Category_List')->getCategory($v['id']);
            $v['url'] = $category['permalink'];
            $v['slug'] = $category['slug'];
            $v['current'] = $archive->is('category', $category['slug']);
        } elseif ($v['type'] == 'page') {
            $page = Typecho_Widget::widget('Widget_Page_Query')->getPage($v['id']);
            $v['url'] = $page['permalink'];
            $v['slug'] = $page['slug'];
            $v['current'] = $archive->is('page', $page['slug']);
        } else {
            $url = $archive->request->getRequestUrl();
            $v['url'] = $v['id'];
            $v['current'] = $url === $v['url'];
        }
        if (isset($v['children'])) {
            $v['caret'] = $options->caret;
        } else {
            $v['caret'] = '';
        }
        $v['target'] = isset($v['target']) && $v['target'] ? 'target="_blank"' : '';
        return $v;
    }
}
