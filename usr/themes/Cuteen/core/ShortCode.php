<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/9/22 [ 短代码 ]
// +----------------------------------------------------------------------
require_once 'ShortCodeCore.php';
// 友情链接
function shortcode_link($atts, $content = ''): string
{
    $args = shortcode_atts(array(
        'href' => '//',
        'img' => '//',
        'target' => '_blank',
        'title' => ''
    ), $atts);
    return '<div class="col-md-4 col-sm-6 position-relative">
<a class="friends-card stretched-link" href="' . $args['href'] . '" target="' . $args['target'] . '" title="' . $args['title'] . '"></a>
<div class="friends-ctx">
<img class="friends-img lazy" data-src="' . $args['img'] . '">
<div class="ms-2">
<div class="fw-bold fs-6 line-clamp-1 mb-2">' . $content . '</div>
<div class="friends-text text-xs line-clamp-2">' . $args['title'] . '</div></div></div></div>';
}

add_shortcode('link', 'shortcode_link');

function shortcode_friends($atts, $content = '')
{
    $args = shortcode_atts(array(
        'random' => 'true'
    ), $atts);
    if (!preg_match_all("/\[(link)\b(.*?)(?:(\/))?\](?:(.+?)\[\/link\])/s", $content, $matches, PREG_SET_ORDER)) {
        return do_shortcode($content);
    } else {
        if ($args['random'] === 'true') {
            shuffle($matches);
        }
        $out = '<div class="row mb-4 g-3">';
        foreach ($matches as $key => $val) {
            $out .= do_shortcode($val[0]);
        }
        $out .= '</div>';
        return $out;
    }
}

add_shortcode('friends', 'shortcode_friends');

//画廊
function shortcode_pic($atts, $content = ''): string
{
    return '<div class="cuteen_photos">' . $content . '</div>';
}

add_shortcode('photos', 'shortcode_pic');

//特殊文字
function shortcode_ggl($atts, $content = ''): string
{
    return '<span class="blur-text">' . $content . '</span>';
}

add_shortcode('BlurText', 'shortcode_ggl');
function shortcode_hm($atts, $content = ''): string
{
    return '<span class="dark-text">' . $content . '</span>';
}

add_shortcode('DarkBText', 'shortcode_hm');
function shortcode_chwz($atts, $content = ''): string
{
    return '<span class="rainbow-text">' . $content . '</span>';
}

add_shortcode('RainBowText', 'shortcode_chwz');

//进度条
function shortcode_progress($atts, $content = ''): string
{
    $args = shortcode_atts(array(
        'value' => '',
        'color' => '',
    ), $atts);
    return '<div class="progress my-3">
  <div class="progress-bar progress-bar-striped progress-bar-animated ' . $args['color'] . '" style="background-color:' . $args['color'] . ';width: ' . $args['value'] . '%" aria-valuenow="' . $args['value'] . '" aria-valuemin="0" aria-valuemax="100">' . $content . '</div>
</div>';
}

add_shortcode('progress', 'shortcode_progress');

//折叠面板
function shortcode_acc($atts, $content = '')
{
    $id1 = 'id1' . uniqid(rand(1, 10000));
    $args = shortcode_atts(array(
        'title' => '',
        'status' => ''
    ), $atts);
    if (empty($args['status']) || $args['status'] == 'close') {
        $app = '';
        $app1 = ' collapsed';
    } else {
        $app = ' show';
        $app1 = '';
    }
    return '<div class="acc"><button class="acc-btn' . $app1 . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $id1 . '" aria-expanded="false" aria-controls="' . $id1 . '">
   ' . $args['title'] . '
  </button>
  <div class="collapse' . $app . '" id="' . $id1 . '">
  <div class="pb-2 px-3"><p>' . $content . '</p></div></div></div>';
}

add_shortcode('acc', 'shortcode_acc');

// 选项卡
function shortcode_tabs($atts, $content = '')
{
    $id1 = 'id1' . uniqid(rand(1, 10000));
    $id2 = 'id2' . uniqid(rand(1, 10000));
    if (!preg_match_all("/(.?)\[(item)\b(.*?)(?:(\/))?\](?:(.+?)\[\/item\])?(.?)/s", $content, $matches)) {
        return do_shortcode($content);
    } else {
        for ($i = 0; $i < count($matches[0]); $i++) {
            $matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
        }
        $out = '<div class="tabs"><nav><div class="nav nav-tabs" id="nav-tab" role="tablist">';
        for ($l = 0; $l < count($matches[0]); $l++) {
            $l == 0 ? $d = 'true' : $d = 'false';
            $l == 0 ? $w = 'active' : $w = '';
            $out .= '<button class="nav-link ' . $w . '" id="nav-' . $id2 . $l . '-tab" data-bs-toggle="tab" data-bs-target="#nav-' . $id1 . $l . '" type="button" role="tab" aria-controls="nav-' . $id1 . $l . '" aria-selected="' . $d . '">' . $matches[3][$l]['title'] . '</button>';
        }
        $out .= '</div></nav><div class="tab-content">';
        for ($o = 0; $o < count($matches[0]); $o++) {
            $o == 0 ? $p = 'show active' : $p = '';
            $out .= '<div class="tab-pane py-2 px-3 fade ' . $p . '" id="nav-' . $id1 . $o . '" role="tabpanel" aria-labelledby="nav-' . $id2 . $o . '-tab" tabindex="0">' . autop(do_shortcode(trim($matches[5][$o]))) . '</div>';
        }
        $out .= '</div></div>';
        return $out;
    }
}

add_shortcode('tabs', 'shortcode_tabs');

//多彩信息条
function shortcode_bar($atts, $content = '')
{
    $args = shortcode_atts(array(
        'color' => '',
    ), $atts);
    return '<blockquote class="cuteen-blockquote ' . $args['color'] . '"><p class="p-3 text-bg-' . $args['color'] . '">' . $content . '</p></blockquote>';
}

add_shortcode('quote', 'shortcode_bar');


//多彩按钮
function shortcode_btn($atts, $content = '')
{
    $args = shortcode_atts(array(
        'color' => '',
        'outline' => '',
        'url' => '#',
        'target' => '_blank',
    ), $atts);
    if ($args['outline']) {
        return '<a class="btn btn-' . $args['outline'] . '-' . $args['color'] . '" href="' . $args['url'] . '" role="button" target="' . $args['target'] . '">' . $content . '</a>';
    } else {
        return '<a class="btn text-bg-' . $args['color'] . '" href="' . $args['url'] . '" role="button" target="' . $args['target'] . '">' . $content . '</a>';
    }
}

add_shortcode('button', 'shortcode_btn');

//多彩卡片
function shortcode_card($atts, $content = ''): string
{
    $bg = '';
    $text = '';
    $args = shortcode_atts(array(
        'color' => '',
        'title' => '',
    ), $atts);
    return '<div class="rounded-2 overflow-hidden">
    <div class="bg-' . $args['color'] . ' px-3 py-2 fw-bold text-white">' . $args['title'] . '</div>
    <div class="text-bg-' . $args['color'] . ' p-3">' . $content . '</div>
</div>';
}

add_shortcode('card', 'shortcode_card');

// 音频播放
function shortcode_audio($atts): string
{
    $args = shortcode_atts(array(
        'src' => '',
        'loop' => ''
    ), $atts);

    return '<audio ' . $args['loop'] . ' src="' . $args['src'] . '" preload="metadata" controls>您的浏览器不支持 audio 标签。</audio>';
}

add_shortcode('audio', 'shortcode_audio');

// 视频播放
function shortcode_video($atts): string
{
    $args = shortcode_atts(array(
        'src' => '',
        'loop' => '',
        'poster' => '',
        'width' => '100%',
        'height' => 'auto',
    ), $atts);
    return '<video ' . $args['loop'] . ' src="' . $args['src'] . '" width="' . $args['width'] . '" height="' . $args['height'] . '" preload="metadata" poster="' . $args['poster'] . '" controls>您的浏览器不支持 video 标签。</video>';
}

add_shortcode('video', 'shortcode_video');

//bili bili
function shortcode_bili($atts, $content): string
{
    return '<div class="bilibili">' . $content . '</div>';
}

add_shortcode('BiliVideo', 'shortcode_bili');

//已完成 - 未完成
function shortcode_event($atts, $content = ''): string
{
    $finish = '';
    $args = shortcode_atts(array(
        'finish' => '',
    ), $atts);
    if ($args['finish'] === 'true') {
        $finish = 'checked';
    } else {
        $finish = 'unchecked';
    }
    return '<div class="flex items-center"><img data-no-lightbox class="h-4 w-4 me-1 emoji" src="' . __CUTEEN_STATIC__ . '/img/' . $finish . '.svg" alt="' . $finish . '"><span>' . $content . '</span></div>';
}

add_shortcode('event', 'shortcode_event');



