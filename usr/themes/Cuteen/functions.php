<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
use Typecho\Widget\Helper\Form\Element\Radio;
use Typecho\Widget\Helper\Form\Element\Text;
use Typecho\Widget\Helper\Form\Element\Checkbox;
use Typecho\Widget\Helper\Form\Element\Textarea;
require_once 'core/Initial.php';
function themeConfig($form)
{
?>
<link rel="stylesheet" href="<?= __CUTEEN_STATIC__ . '/css/admin.css'; ?>">
<script src="<?= __CUTEEN_STATIC__ . '/js/admin.js'; ?>"></script>
<div class="logo">Cuteen <?= $GLOBALS['config']['ThemeVersion'] ?>
    <?php require_once 'include/backup.php' ?>
</div>
<div class="flex cuteen">
    <div>
        <div class="aside">
            <ul class="tabs">
                <li class="item" data-name="notice">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    最新公告
                </li>
                <li class="item" data-name="global">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    全局设置
                </li>
                <li class="item" data-name="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    导航菜单
                </li>
                <li class="item" data-name="index">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    首页设置
                </li>
                <li class="item" data-name="style">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                    </svg>
                    相关风格
                </li>
                <li class="item" data-name="post">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    文章内页
                </li>
                <li class="item" data-name="side">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                    旁侧边栏
                </li>
                <li class="item" data-name="enhancement">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                    增强设置
                </li>
            </ul>
        </div>
    </div>
    <div class="notice">加载公告中………………</div>
    <?php

    $TopPost = new Text(
        'TopPost', NULL, NULL,
        _t('文章置顶轮播'),
        _t('填入需要置顶的文章cid或slug（根据自定义链接而定），请以半角逗号分割，加密文章不会显示'));
    $TopPost->setAttribute('class', 'ctx index');
    $form->addInput($TopPost);

    $IndexTopImgUrl = new Text(
        'IndexTopImgUrl', NULL, NULL,
        _t('<div style="color:#8b4513">主页顶部大图</div>'),
        _t('请填写图片链接，为了保证美观与用户体验，请选择长方形图片'));
    $IndexTopImgUrl->setAttribute('class', 'ctx index');
    $form->addInput($IndexTopImgUrl);

    $IndexBigTitle = new Text(
        'IndexBigTitle', NULL, NULL,
        _t('<div style="color:#8b4513">首页顶部大标题</div>'),
        _t('3~6字最佳，请勿太长，留空则显示站点标题'));
    $IndexBigTitle->setAttribute('class', 'ctx index');
    $form->addInput($IndexBigTitle);

    $IndexSubtitle = new Text(
        'IndexSubtitle', NULL, NULL,
        _t('<div style="color:#8b4513">首页顶部小标题</div>'),
        _t('10~15字最佳，留空则显示站点描述'));
    $IndexSubtitle->setAttribute('class', 'ctx index');
    $form->addInput($IndexSubtitle);

    $IndexTopImgHeight = new Text(
        'IndexTopImgHeight', NULL, NULL,
        _t('顶部背景图高度'),
        _t('自定义顶图高度，开启顶部大图、且为PC端时，此项有效。填写请带单位，例如：700px'));
    $IndexTopImgHeight->setAttribute('class', 'ctx index');
    $form->addInput($IndexTopImgHeight);

    $PostImgCenter = new Checkbox('PostImgCenter',
        array('PostImgCenter' => '开启文章图片自动居中功能'),
        null,
        '文章图片居中',
        '说明：开启后文章页所有图片（除表情外）均会居中布局'
    );
    $PostImgCenter->setAttribute('class', 'ctx post');
    $form->addInput($PostImgCenter->multiMode());

    $UpLikes = new Checkbox('UpLikes',
        array('UpLikes' => '开启文章可点赞'),
        null,
        '文章点赞功能',
        '说明：开启后将在文章内页（文章结束后）添加点赞按钮');
    $UpLikes->setAttribute('class', 'ctx post');
    $form->addInput($UpLikes->multiMode());

    $Reward = new Checkbox('Reward',
        array('Reward' => '开启文章打赏功能'),
        null,
        '文章打赏',
        '说明：开启后将在文章内页（文章结束后）添加打赏按钮<br />
        注意：开启后按需配置以下<font style="color:#20bf6b">绿色</font>选项'
    );
    $Reward->setAttribute('class', 'ctx post');
    $form->addInput($Reward->multiMode());

    $Alipay = new Text('Alipay',
        NULL,
        NULL,
        _t('<div style="color:#20bf6b">&nbsp;&nbsp;- 支付宝收款码</div>'),
        _t('请填写图片链接，为了保证美观与用户体验，请保证图片宽高比一致，不填则不显示'));
    $Alipay->setAttribute('class', 'ctx post');
    $form->addInput($Alipay);

    $WeChatPay = new Text('WeChatPay',
        NULL,
        NULL,
        _t('<div style="color:#20bf6b">&nbsp;&nbsp;- 微信收款码</div>'),
        _t('请填写图片链接，为了保证美观与用户体验，请保证图片宽高比一致，不填则不显示'));
    $WeChatPay->setAttribute('class', 'ctx post');
    $form->addInput($WeChatPay);

    $QQPay = new Text('QQPay',
        NULL,
        NULL,
        _t('<div style="color:#20bf6b">&nbsp;&nbsp;- QQ收款码</div>'),
        _t('请填写图片链接，为了保证美观与用户体验，请保证图片宽高比一致，不填则不显示'));
    $QQPay->setAttribute('class', 'ctx post');
    $form->addInput($QQPay);

    $Copyright = new Checkbox('Copyright',
        array('Copyright' => '开启文章版权声明'),
        null,
        '文章版权',
        '说明：开启后将在文章内页（文章结束后）添加版权声明<br />
        注意：开启后请按需配置以下<font color="purple">紫色</font>选项'
    );
    $Copyright->setAttribute('class', 'ctx post');
    $form->addInput($Copyright->multiMode());

    $CopyrightConfiguration = new Checkbox('CopyrightConfiguration',
        array('author' => '显示作者名称', 'provenance' => '显示出处链接'),
        null,
        '<div style="color:purple">&nbsp;&nbsp;- 版权配置</div>',
        '说明：选择是否显示作者名称与出处链接<font color="red">（开启后必选其一）</font>');
    $CopyrightConfiguration->setAttribute('class', 'ctx post');
    $form->addInput($CopyrightConfiguration);

    $CopyrightText = new Text('CopyrightText',
        NULL,
        NULL,
        '<div style="color:purple">&nbsp;&nbsp;- 声明文字自定义</div>',
        '说明：本处可以自定义声明文字，默认声明文字将会被覆盖，不填则显示默认文字');
    $CopyrightText->setAttribute('class', 'ctx post');
    $form->addInput($CopyrightText);

    $RandImg = new Textarea('RandImg',
        null, "https://tvax1.sinaimg.cn/large/0084aYsLly1ge7bcjv1u1j31hc0u00y8.jpg\nhttps://tvax3.sinaimg.cn/large/0084aYsLly1ge7bcxq2vuj30qo0f0q4v.jpg\nhttps://tvax1.sinaimg.cn/large/0084aYsLly1ge7bep7icyj30zk0jzdlu.jpg\nhttps://tva4.sinaimg.cn/large/0084aYsLly1ge7bf74jd0j31hc11pdui.jpg\nhttps://tva2.sinaimg.cn/large/0084aYsLly1ge7bfredg6j31hc0u0tgb.jpg\nhttps://tva3.sinaimg.cn/large/0084aYsLly1ge7bgcg3vfj31hc0u0dp4.jpg\nhttps://tva4.sinaimg.cn/large/0084aYsLly1ge7bivvvswj31hc0u078j.jpg\nhttps://tvax4.sinaimg.cn/large/0084aYsLly1ge7bli2jzdj31z418gjwd.jpg",
        '自定义随机缩略图',
        '请输入完整图片链接，一行一个');
    $RandImg->setAttribute('class', 'ctx post');
    $form->addInput($RandImg);

    $CodeHighLightStyle = new Radio(
        'CodeHighLightStyle',
        array('dark' => '暗色（默认）', 'light' => '亮色'),
        'dark',
        '代码高亮风格',
        '说明：默认为代码高亮为传统暗色模式风格，支持常见的3多种语言高亮代码'
    );
    $CodeHighLightStyle->setAttribute('class', 'ctx style');
    $form->addInput($CodeHighLightStyle->multiMode());

    $MourningMode = new Checkbox(
        'MourningMode',
        array('MourningMode' => '开启后，网站将由灰色滤镜覆盖'),
        null,
        '哀悼模式');
    $MourningMode->setAttribute('class', 'ctx style');
    $form->addInput($MourningMode->multiMode());

    $HeaderTransition = new Radio(
        'HeaderTransition',
        array('default' => '无效果（默认）', 'white' => '白边', 'wave' => '波浪'),
        'default',
        '顶部大图风格',
        '说明：默认为无效果，选择其余两项后顶部大图将会有一个白边/波浪过渡效果,此效果将应用于所有含顶部图的页面'
    );
    $HeaderTransition->setAttribute('class', 'ctx style');
    $form->addInput($HeaderTransition->multiMode());

    $Pagination = new Radio(
        'Pagination',
        array('number' => '传统数字（默认）', 'ajax' => 'Ajax加载更多', 'fall' => 'Ajax无限加载'),
        'number',
        '首页文章列表加载方式',
        '说明：默认为传统数字风格，手动点击翻页；Ajax加载更多（推荐）点击后直接加载到当前列表下方；Ajax无限加载无需手动点击，滚动到一定位置直接加载'
    );
    $Pagination->setAttribute('class', 'ctx index');
    $form->addInput($Pagination->multiMode());

    $Headroom = new Checkbox(
        'Headroom',
        array('Headroom' => '是否启用导航栏下滑消失，上滑出现效果'),
        null,
        '导航栏下滑消失');
    $Headroom->setAttribute('class', 'ctx menu');
    $form->addInput($Headroom->multiMode());

    $LabelOrder = new Radio(
        'LabelOrder',
        array('C-P' => '分类在页面前（默认）', 'P-C' => '页面在分类前'),
        'C-P',
        '分类与独立页面顺序',
        '说明：默认为独立页面在后，分类在前，如仍然不能满足要求，请使用“自定义设置-自定义导航栏”'
    );
    $LabelOrder->setAttribute('class', 'ctx menu');
    $form->addInput($LabelOrder->multiMode());

    $MergePages = new Text(
        'MergePages', NULL, NULL,
        '合并页面名称',
        '说明：导航栏所有页面合并成二级菜单后显示的名称，填写后即表示开启页面合并，若不合并请留空');
    $MergePages->setAttribute('class', 'ctx menu');
    $form->addInput($MergePages);

    $key = new Text(
        'key', NULL, NULL,
        '<font color="red">站点授权码</font>',
        '必填，购买时的授权码，务必牢记');
    $key->setAttribute('class', 'ctx global');
    $form->addInput($key);

    $SiteSubtitle = new Text(
        'SiteSubtitle', NULL, NULL,
        '站点副标题',
        '输入站点副标题，将显示在首页标题后，不填则不显示');
    $SiteSubtitle->setAttribute('class', 'ctx global');
    $form->addInput($SiteSubtitle);

    $Favicon = new Textarea(
        'Favicon', NULL, NULL,
        '网站 Favicon 设置',
        '说明：用于设置网站 Favicon 图标，不填则默认网站根目录下 Favicon 图标（不是主题目录）<br />
         格式：图片 URL地址 或 Base64 地址 （图片格式建议采用 SVG ，放大不失真）'
    );
    $Favicon->setAttribute('class', 'ctx global');
    $form->addInput($Favicon);

    $LogoUrl = new Textarea(
        'LogoUrl', NULL, NULL,
        '网站 LOGO 设置',
        '说明：在这里填入一个图片 URL 地址, 可在导航栏加上一个 LOGO，不填则默认显示站点名称（“设置-基本-站点名称”）<br />
        格式：图片 URL地址 或 Base64 地址 （图片格式建议采用 SVG ，放大不失真）<br />
        其他：夜间模式 LOGO 请<font color="red">换行</font>写在下方（第一行为普通模式下 LOGO ，第二行为夜间模式 LOGO）');
    $LogoUrl->setAttribute('class', 'ctx global');
    $form->addInput($LogoUrl);

    $GlobalFont = new Checkbox(
        'GlobalFont',
        array('GlobalFont' => '是否启用全局字体渲染优化'),
        null,
        '全局字体设置',
        '说明：开启后部分字体渲染为思源宋体，全局字体渲染为MiSans。均为按需加载方式，能在不影响速度的情况下对网站字体显示进一步提升');
    $GlobalFont->setAttribute('class', 'ctx global');
    $form->addInput($GlobalFont->multiMode());

    $ICP = new Text(
        'ICP', NULL, NULL,
        'ICP备案号',
        '说明：请输入工信部ICP备案号（国外主机用户请忽略）');
    $form->addInput($ICP);
    $ICP->setAttribute('class', 'ctx global');

    $Policemen = new Text(
        'Policemen', NULL, NULL,
        '公安备案号',
        '说明：请输入公安备案号，未备案请忽略此项');
    $form->addInput($Policemen);
    $Policemen->setAttribute('class', 'ctx global');

    $Sidebar = new Checkbox(
        'Sidebar',
        array('Sidebar' => '是否启用PC端全局侧边栏'),
        null, '侧边栏',
        '说明：是否开启全站侧边栏，侧边栏默认居左，可通过下方自定义');
    $Sidebar->setAttribute('class', 'ctx side');
    $form->addInput($Sidebar->multiMode());

    $SidebarPosition = new Checkbox('SidebarPosition', array(
        'ExternalPage' => '首页、分类页、搜索页',
        'InternalPage' => '文章内页、自定义页'
    ), array('ExternalPage', 'InternalPage'), '侧边栏显示位置',
        '说明：选择侧边栏显示页面<font color="red">（开启后必选）</font>');
    $SidebarPosition->setAttribute('class', 'ctx side');
    $form->addInput($SidebarPosition);

    $SidebarRorL = new Radio(
        'SidebarRorL',
        array('L-R' => '侧边栏居左（默认）', 'R-L' => '侧边栏居右'),
        'L-R',
        '全局侧边栏居左或居右',
        '说明：默认为侧边栏居左，可选择居右'
    );
    $SidebarRorL->setAttribute('class', 'ctx side');
    $form->addInput($SidebarRorL->multiMode());

    $SidebarBackgroundImg = new Text(
        'SidebarBackgroundImg', NULL, NULL,
        '侧边栏背景图',
        '说明：用于设置侧边栏头像后方背景<br />
        格式：图片 URL地址（图片格式建议采用 SVG ，放大不失真）');
    $SidebarBackgroundImg->setAttribute('class', 'ctx side');
    $form->addInput($SidebarBackgroundImg);

    $SideAvatar = new Textarea(
        'SideAvatar', NULL, NULL,
        '侧边栏上方头像',
        '说明：用于设置侧边栏头像，不填则默认采用站点邮箱对应的图片<br />
        格式：图片 URL地址 或 Base64 地址 （图片格式建议采用 SVG ，放大不失真）');
    $SideAvatar->setAttribute('class', 'ctx side');
    $form->addInput($SideAvatar);

    $Signature = new Text(
        'Signature', NULL, NULL,
        '侧边栏个性签名',
        '说明：用于设置侧边栏头像下方个性签名，一个好的签名可以让网站更吸引人');
    $Signature->setAttribute('class', 'ctx side');
    $form->addInput($Signature);

    $Smooth = new Checkbox(
        'Smooth',
        array('Smooth' => '是否启用平滑滚动'),
        null, '平滑滚动',
        '说明：开启后比较直观的改变就是整个网站滚动会舒服很多，在一定程度上会提高用户体验<br />
        注意：在低版本Edge浏览器、国产非Chrome内核浏览器，可能会出现卡顿，反而降低用户体验，请酌情开启');
    $Smooth->setAttribute('class', 'ctx enhancement');
    $form->addInput($Smooth->multiMode());

    $Pjax = new Checkbox(
        'Pjax',
        array('Pjax' => '是否启用Pjax无刷新'),
        null, 'Pjax无刷新',
        '说明：开启后比较直观的改变就是整个网站变成单页应用，在一定程度上会提高用户体验，且已经加载过的静态资源不会再重复加载，站点的响应速度会有进一步的改善<br />
        注意：可能会<font color="red">导致部分第三方插件失效</font>，请自行添加回调函数');
    $Pjax->setAttribute('class', 'ctx enhancement');
    $form->addInput($Pjax->multiMode());

    $MathJax = new Checkbox(
        'MathJax',
        array('MathJax' => '是否启用LaTeX公式渲染'),
        null, '公式渲染',
        '说明：开启后在文章页内引入MathJax，渲染LaTeX公式<br />
        注意：只支持LaTeX公式，可能会导致页面渲染速度下降（大小约1MB），酌情开启');
    $MathJax->setAttribute('class', 'ctx enhancement');
    $form->addInput($MathJax->multiMode());

    $StaticCDNUrl = new Text(
        'StaticCDNUrl', NULL, NULL,
        '自定义静态加速CDN',
        '你需要把/static/目录上传到你的cdn服务器上，该框填入相应的路径地址，主题就会引用你搭建的cdn上面的资源，而不再引用当前服务器上的资源');
    $StaticCDNUrl->setAttribute('class', 'ctx enhancement');
    $form->addInput($StaticCDNUrl);

    $CustomMenu = new Textarea(
        'CustomMenu', NULL, NULL,
        '自定义导航栏',
        '说明：此部分可自定义整个导航栏，<font color="red">优先级最高</font>，所有内容均可自定义，包括 URL 和名称，使用默认显示方式请留空<br />
        格式：采用 json 格式书写，具体请参考使用文档，内有详细说明<br />
        其他：注意逗号位置，最后一行无需书写逗号，请勿注释');
    $CustomMenu->setAttribute('class', 'ctx menu');
    $form->addInput($CustomMenu);

    $MusicListUrl = new Text(
        'MusicListUrl', NULL, NULL,
        '歌单链接',
        '说明：填写此部分代表开启歌单功能，不填则不开启，目前支持网易云歌单与QQ歌单，直接填写歌单链接即可<br />
        注意：切勿使用客户端分享出的链接，须从浏览器对应网站直接复制');
    $MusicListUrl->setAttribute('class', 'ctx enhancement');
    $form->addInput($MusicListUrl);

    $MusicList = new Textarea(
        'MusicList', NULL, NULL,
        '自定义歌单',
        '说明：此空优先级最高，所有内容均为自定义，包括歌曲 URL 直链、名称、专辑图片等<br />
        格式：采用 json 格式书写，具体请参考<a href="https://www.yuque.com/veenzhao/cuteen5/cbbbyi">使用文档</a>，内有详细说明<br />
        其他：注意逗号位置，最后一行无需书写逗号，请勿注释');
    $MusicList->setAttribute('class', 'ctx enhancement');
    $form->addInput($MusicList);

    $CustomHeader = new Textarea(
        'CustomHeader',
        NULL, NULL,
        '头部自定义内容',
        '说明：位于顶部标签head内，适合放置一些 &lt;link&gt; 标签链接引用或其他自定义内容');
    $CustomHeader->setAttribute('class', 'ctx enhancement');
    $form->addInput($CustomHeader);

    $CustomStyle = new Textarea(
        'CustomStyle',
        NULL, NULL,
        '自定义CSS样式',
        '说明：已包含&lt;style&gt;标签，请直接书写CSS样式即可');
    $CustomStyle->setAttribute('class', 'ctx enhancement');
    $form->addInput($CustomStyle);

    $CustomFooter = new Textarea(
        'CustomFooter',
        NULL, NULL,
        '底部自定义内容',
        '说明：位于底部，&lt;footer&gt; 之后 &lt;body&gt; 之前，适合放置一些 &lt;script&gt; 脚本js或自定义内容，如网站统计代码等<br />
        注意：如果您开启了Pjax，暂时只支持百度统计、Google统计，其余统计代码可能会不准确；没开请忽略');
    $CustomFooter->setAttribute('class', 'ctx enhancement');
    $form->addInput($CustomFooter);

    $PjaxCallback = new Textarea(
        'PjaxCallback',
        NULL, NULL,
        'Pjax回调函数',
        '说明：在这里可以书写PJAX回调函数内容。如果您不知道这项如何使用请忽略');
    $PjaxCallback->setAttribute('class', 'ctx enhancement');
    $form->addInput($PjaxCallback);

    $DNSPreParse = new Textarea(
        'DNSPreParse',
        NULL, NULL,
        '自定义DNS预解析',
        '说明：请填写完整标签内容，只输入网址无效<br>
         填写举例：&lt;link rel="dns-prefetch" href="//fonts.googleapis.com"&gt;');
    $DNSPreParse->setAttribute('class', 'ctx enhancement');
    $form->addInput($DNSPreParse);

    $CustomFonts = new Text(
        'CustomFonts',
        NULL, NULL,
        '自定义全局字体',
        '说明：请填写引入字体Url<br>
         注意：中文字体体积庞大，自定义字体会导致网页加载与渲染过慢（取决于字体文件大小），不建议使用');
    $CustomFonts->setAttribute('class', 'ctx enhancement');
    $form->addInput($CustomFonts);

    $Eruda = new Checkbox(
        'Eruda',
        array('Eruda' => '是否启用移动端高级调试'),
        null, '移动端高级调试',
        '说明：开启后引入Eruda调试插件<br />
        注意：除非网站爆炸，自己玩傻了，不找我都解决不了问题了，开启后联系我，不然别开');
    $Eruda->setAttribute('class', 'ctx enhancement');
    $form->addInput($Eruda->multiMode());
    }
    ?>