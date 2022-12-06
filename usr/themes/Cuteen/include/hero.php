<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/2/11 [ 标题、大图 - hero ]
// +----------------------------------------------------------------------
?>
<div id="hero-box" class="hero" style="background-image: url('<?= Context::HeroImage($this) ?>');<?= Context::ImgHeight() ?>">
    <?php if ($this->is('index')) : ?>
        <h3 class="big-title serif-font"><?= $this->options->IndexBigTitle ?: $this->options->title; ?></h3>
        <div class="sub-title">
            <?= $this->options->IndexSubtitle ?: $this->options->description; ?>
        </div>
    <?php elseif ($this->is('archive')): ?>
        <?php if ($this->is('search')) : ?>
            <h3 class="post-title serif-font">搜索到 <?= $this->getTotal(); ?>
                篇与 <?= $this->keywords; ?> 相关的结果</h3>
        <?php elseif ($this->themeFile == '404.php') : ?>
            <h3 class="post-title serif-font">404 - 页面不存在</h3>
        <?php else : ?>
            <h3 class="post-title serif-font"> <?= $this->keywords; ?> •
                共<?= $this->getTotal(); ?>篇</h3>
        <?php endif; ?>
    <?php else: ?>
        <h3 class="post-title serif-font"><?= $this->title ?></h3>
    <?php endif; ?>
    <?php if ($this->is('post')) : ?>
        <ul class="post-title-info serif-font">
            <?php if (sizeof($this->categories) > 0) : ?>
                <li class="md:flex d-none d-md-flex">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#biaoqian2"></use>
                    </svg>
                    <span><?php echo $this->categories[0]['name']; ?></span>
                </li>
            <?php endif; ?>
            <li>
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#huo"></use>
                </svg>
                <span><?= Func::GetViews($this) ?>阅读</span>
            </li>
            <li>
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#shijian"></use>
                </svg>
                <span><?php $this->date('Y年m月d日'); ?></span>
            </li>
            <li>
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#pinglun1"></use>
                </svg>
                <span><?php $this->commentsNum('%d'); ?>评论</span>
            </li>
        </ul>
    <?php endif; ?>
    <?php if ($this->options->HeaderTransition == 'wave') : ?>
        <section class="main-hero-waves-area waves-area">
            <svg class="waves-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave"
                          d="M -160 44 c 30 0 58 -18 88 -18 s 58 18 88 18 s 58 -18 88 -18 s 58 18 88 18 v 44 h -352 Z"></path>
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0"></use>
                    <use xlink:href="#gentle-wave" x="48" y="3"></use>
                    <use xlink:href="#gentle-wave" x="48" y="5"></use>
                    <use xlink:href="#gentle-wave" x="48" y="7"></use>
                </g>
            </svg>
        </section>
    <?php endif; ?>
</div>
