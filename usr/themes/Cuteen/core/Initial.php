<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/1/2 [ 初始化载入 ]
// +----------------------------------------------------------------------
use Typecho\Plugin;
use Utils\Helper;

error_reporting(0);

//判断php版本
$GLOBALS['config'] = include_once 'Config.php';
if (version_compare(PHP_VERSION, $GLOBALS['config']['PHPVersion'], '<'))
    exit('<h3><font color="red">PHP版本未满足要求！</font>当前版本：' . PHP_VERSION . ' 最低要求版本 ' . $GLOBALS['config']['PHPVersion'] . '</h3>');

//判断插件是否启动
function isPluginAvailable($name): bool
{
    $plugins = Plugin::export();
    $plugins = $plugins['activated'];
    return is_array($plugins) && array_key_exists($name, $plugins);
}

if (!isPluginAvailable('Cuteen')) {
    exit('<h3><font color="red">插件未启用！！！</font>请前往后台启用插件。如有疑问请联系QQ2013143650</h3>');
}

include_once 'ShortCode.php';
include_once 'Widget.php';
include_once 'Function.php';
include_once 'Context.php';
include_once 'Fields.php';

//主题静态资源的绝对地址
if (strlen(trim(Helper::options()->StaticCDNUrl)) > 0)
    @define('__CUTEEN_STATIC__', Helper::options()->StaticCDNUrl);
else
    @define('__CUTEEN_STATIC__', '' . Helper::options()->themeUrl . '/static');

/* 主题初始化 */
function themeInit()
{
    Helper::options()->commentsAntiSpam = false; //关闭反垃圾
    Helper::options()->commentsCheckReferer = false; //关闭检查评论来源URL与文章链接是否一致判断(否则会无法评论)
    Helper::options()->commentsPageDisplay = 'first'; //强制评论第一页
    Helper::options()->commentsOrder = 'DESC'; //将最新的评论展示在前
    /* 强制用户要求填写邮箱 */
    Helper::options()->commentsRequireMail = true;
    /* 强制用户要求无需填写url */
    Helper::options()->commentsRequireURL = false;
    /* 强制用户开启评论回复 */
    Helper::options()->commentsThreaded = true;
    /* 强制回复楼层最高999层 */
    Helper::options()->commentsMaxNestingLevels = 999;
}


