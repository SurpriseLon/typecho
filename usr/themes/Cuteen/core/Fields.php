<?php
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/9/20
// +----------------------------------------------------------------------

function themeFields(Typecho\Widget\Helper\Layout $layout)
{
    $excerpt = new Typecho\Widget\Helper\Form\Element\Textarea('excerpt', null, null, '文章摘要', '输入自定义摘要。留空自动从文章截取。');
    $layout->addItem($excerpt);
    $imgst = new Typecho\Widget\Helper\Form\Element\Text('imgst', NULL, NULL, _t('文章缩略图'), _t('在这里填入一个图片URL地址, 以在文章列表加上一张图片'));
    $layout->addItem($imgst);
    $catalog = new Typecho\Widget\Helper\Form\Element\Radio(
        'catalog',
        array(
            true => _t('启用'),
            false => _t('关闭')
        ),
        false,
        _t('文章目录'),
        _t('默认关闭，启用则会在文章内显示“文章目录”（自动匹配H1~H6标签）')
    );
    short_code_set();
    $layout->addItem($catalog);
}