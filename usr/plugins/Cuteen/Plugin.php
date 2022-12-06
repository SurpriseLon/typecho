<?php

use Typecho\Db;
use Typecho\Plugin;
use Typecho\Plugin\PluginInterface;
use Typecho\Widget;
use Utils\Helper;
use Typecho\Widget\Helper\Form;

/**
 * <strong style="color:red;">Cuteen主题配套插件</strong>
 *
 * @package Cuteen
 * @author Veen Zhao
 * @version 1.5
 * @update: 2022/09/27
 * @link https://blog.zwying.com
 */
class Cuteen_Plugin implements PluginInterface
{
    public static function activate()
    {
        Helper::addAction('cuteen', 'Cuteen_Action');
        try {
            $db = Db::get();
            $prefix = $db->getPrefix();
            if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents'))))
                $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `likes` INT(10) DEFAULT 0;');
            if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')->page(1, 1)))) {
                $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT DEFAULT 0;');
            }
        } catch (Db\Exception $e) {
        }


        Plugin::factory('Widget_Archive')->beforeRender = array('Cuteen_Plugin', 'viewsCounter');
        //后台编辑器底部集成
        Plugin::factory('admin/write-post.php')->richEditor = array('Cuteen_Plugin', 'EditFooter');
        Plugin::factory('admin/write-page.php')->richEditor = array('Cuteen_Plugin', 'EditFooter');
        //加密文章显示标题
        Plugin::factory('Widget_Abstract_Contents')->filter = array('Cuteen_Plugin', 'HiddenTitleShow');

    }

    // 访问计数
    public static function viewsCounter()
    {
        if (Widget::widget('Widget_Archive')->is('single')) {
            $db = Db::get();
            $cid = Widget::widget('Widget_Archive')->cid;
            $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
            $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
        }
    }

    public static function EditFooter()
    {
        ?>
        <script src="<?php Helper::options()->pluginUrl() ?>Cuteen/js/parse.js"></script>
        <script src="<?php Helper::options()->pluginUrl() ?>Cuteen/js/prism.js"></script>
        <script>
            window.CuteenConfig = {
                emojiAPI: '<?php Helper::options()->pluginUrl() ?>Cuteen/json/emoji.json',
                expressionAPI: '<?php Helper::options()->pluginUrl() ?>Cuteen/json/expression.json',
                characterAPI: '<?php Helper::options()->pluginUrl() ?>Cuteen/json/character.json',
                themeURL: '<?php Helper::options()->themeUrl(); ?>',
            }
        </script>
        <script src="<?php Helper::options()->pluginUrl() ?>Cuteen/js/editor.bundle.js"></script>
        <link rel="stylesheet" href="<?php Helper::options()->pluginUrl() ?>Cuteen/css/editor.css"/>
        <link rel="stylesheet" href="<?php Helper::options()->pluginUrl() ?>Cuteen/css/prism-light.css"/>
        <link rel="stylesheet" href="<?php Helper::options()->pluginUrl() ?>Cuteen/css/style.css"/>
        <link rel="stylesheet" href="<?php Helper::options()->pluginUrl() ?>Cuteen/css/typeset.css"/>
        <?php self::TagsEcho(); ?>
        <?php
    }

    // 后台编辑器添加标签选择器
    public static function TagsEcho()
    {
        ?>
        <script> $(document).ready(function () {
                $('#tags').after('<div class="tagshelper"><ul>' +
                    '<?php
                        Widget::widget('Widget\Metas\Tag\Cloud')->to($tags);
                        $i = 0;
                        while ($tags->next()) {
                            echo "<a id=\"$i\" onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'" . $tags->name . "\', tags: \'" . $tags->name . "\'});\">", $tags->name, "</a>";
                            $i++;
                            if ($tags->name) echo "  ";
                        }
                        ?>' + '</ul></div>');
            });</script>
        <?php
    }

    // 修复加密文章无法评论、403、不显示标题
    public static function HiddenTitleShow($v, $obj)
    {
        $v['titleShow'] = false;
        if ($v['hidden']) {
            $v['hidden'] = false;
            $v['titleShow'] = true;
        }
        return $v;
    }


    // 禁用插件方法,如果禁用失败,直接抛出异常
    public static function deactivate()
    {
        Helper::removeAction('cuteen');
    }


    // 获取插件配置面板
    public static function config(Form $form)
    {
    }

    // 个人用户的配置面板
    public static function personalConfig(Form $form)
    {
    }
}


