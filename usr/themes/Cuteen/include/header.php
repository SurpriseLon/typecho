<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <?php $this->header('commentReply=&'); ?>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php if ($this->options->DNSPreParse) : $this->options->DNSPreParse(); ?><?php endif; ?>
    <?= Context::EchoFavicon() ?>
    <title><?= Context::EchoTitle($this) ?></title>

    <?php if (!$this->options->CustomFonts && $this->options->GlobalFont) : ?>
        <link href="https://font.sec.miui.com/font/css?family=MiSans:400,700:Chinese_Simplify,Chinese_Traditional,Latin,Numeric&display=swap"
              rel="stylesheet" media="print" onload="this.media='all'">
        <link href="https://font.sec.miui.com/font/css?family=Source_Han_Serif:400,600:Chinese_Simplify,Chinese_Traditional,Latin,Numeric&display=swap"
              rel="stylesheet" media="print" onload="this.media='all'">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= __CUTEEN_STATIC__ . '/css/vendor.min.css'; ?>">
    <?php if ($this->options->CodeHighLightStyle == 'dark') : ?>
        <link title="dark-prism" rel="stylesheet" href="<?= __CUTEEN_STATIC__ . '/css/prism.css'; ?>">
    <?php else: ?>
        <link title="light-prism" rel="stylesheet" href="<?= __CUTEEN_STATIC__ . '/css/prism-light.css'; ?>">
    <?php endif; ?>
    <?= Func::LocalizeScript('CuteenConfig', array(
        'theme_version' => $GLOBALS['config']['ThemeVersion'],
        'index' => $this->options->index,
        'api' => $this->options->index . '/cuteen/api',
        'page_size' => $this->parameter->pageSize,
        'category_mid' => $this->is('category') ? $this->categories[0]['mid'] : 'null',
        'search_words' => $this->is('search') ? $this->keywords : 'null',
        'post_cid' => $this->is('single') ? $this->cid : 'null',
        'static_cdn_url' => __CUTEEN_STATIC__,
        'is_login' => $this->user->hasLogin(),
        'load_article_mode' => $this->options->Pagination,
        'theme_url' => $this->options->themeUrl,
        'music_id' => Func::ParseMusic($this->options->MusicListUrl)['id'],
        'music_media' =>Func::ParseMusic($this->options->MusicListUrl)['media'],
        'TopIndexArray' => Context::TopIndexArray()
    )) ?>
    <?php if ($this->options->CustomHeader) : $this->options->CustomHeader(); ?><?php endif; ?>
</head>
<script src="//at.alicdn.com/t/c/font_3601434_qsg10muka5i.js"></script>
<?php $this->need('include/style.php'); ?>
<body>
<?php $this->need('include/navbar.php');$this->need('include/hero.php'); ?>

<main id="wrap" class="container">



