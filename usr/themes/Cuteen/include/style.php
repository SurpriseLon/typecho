<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/2/4 [ 相关样式 ]
// +----------------------------------------------------------------------
?>
<style data-custom-style>
    <?php if ($this->options->CustomStyle) : $this->options->CustomStyle(); ?><?php endif; ?>
    <?php if ($this->options->CustomFonts) : ?>
    @font-face {
        font-family: 'CustomFonts';
        src: url('<?= $this->options->CustomFonts?>');
    }

    <?php endif; ?>
    <?php if ($this->options->PostImgCenter) : ?>
    #post-box a[data-fslightbox] {
        width: 100%;
    }

    #post-box a[data-fslightbox] img {
        margin: 0 auto;
    }

    <?php endif; ?>
    <?php if ($this->options->MourningMode) : ?>
    html {
        filter: grayscale(100%);
        -webkit-filter: grayscale(100%);
    }

    <?php endif; ?>

    <?php if ($this->options->HeaderTransition =='white') : ?>
    .hero::after {
        content: '';
        width: 100%;
        height: 10%;
        position: absolute;
        bottom: 0;
        left: 0;
        background: linear-gradient(to top, #fff, transparent);
    }

    .dark .hero::after {
        background: linear-gradient(to top, #0F172A, transparent);
    }

    <?php endif; ?>

    <?php if ($this->options->GlobalFont) : ?>
    body {
        font-family: 'CustomFonts', MiSans, Microsoft YaHei, sans-serif;
    }

    <?php endif; ?>
</style>