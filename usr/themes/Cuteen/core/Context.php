<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2021/12/28 [ 内容类 ]
// +----------------------------------------------------------------------
use Typecho\Widget;
use Widget\Archive;
use Utils\Helper;
use Typecho\Common;

class Context extends Archive
{
    /**
     * @return false|string[]
     * 输出logo
     */
    public static function EchoLogo()
    {
        $tmp = Helper::options()->LogoUrl;
        return explode("\n", $tmp);
    }

    /**
     * @return string
     * favicon输出,默认为站点根目录
     */
    public static function EchoFavicon(): string
    {
        $icon = Helper::options()->Favicon;
        if ($icon) {
            $res = '<link rel="icon" type="image/png" href="' . $icon . '">';
            $res .= '<link rel="apple-touch-icon-precomposed" href="' . $icon . '">';
        } else {
            $res = '<link rel="icon" type="image/png" href="' . Helper::options()->siteUrl . 'favicon.ico">';
            $res .= '<link rel="apple-touch-icon-precomposed" href="' . Helper::options()->siteUrl . 'favicon.ico">';
        }
        return $res;
    }

    /**
     * @param $s
     * @param $name
     * @return bool
     * 当前活动菜单
     */
    public static function MenuActive($s, $name): bool
    {
        if ($s->is('category', $name) || $s->is('page', $name))
            return true;
        else
            return false;
    }

    /**
     * @param $url
     * @param $name
     * @return string
     * 返回菜单标签
     */
    public static function MenuTag($url, $name): string
    {
        return '<li class="nav-item"><a class="nav-link text-nowrap" href="' . $url . '">' . $name . '</a></li>';
    }

    /**
     * @param $s
     * @param $key
     * @return string
     * 用户自定义二级菜单html结构
     */
    public static function CustomerDropdownMenuTag($s, $key): string
    {
        $str = '<li class="nav-item dropdown">';
        $str .= '<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $key['name'] . '</a>';
        $str .= '<ul class="dropdown-menu">';
        foreach ($key['children'] as $child) {
            if (self::MenuActive($s, $child['name'])) $class = ' active';
            $str .= ' <li><a class="dropdown-item' . $class . '" href="' . $child['url'] . '">' . $child['name'] . '</a></li>';
        }
        $str .= '</ul></li>';
        return $str;
    }

    /**
     * @param $s
     * @param $category
     * @param $children
     * @return string
     * 二级菜单html结构
     */
    public static function DropdownMenuTag($s, $category, $children): string
    {
        $str = '<li class="nav-item dropdown">';
        $str .= '<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $category->name . '</a>';
        $str .= '<ul class="dropdown-menu">';
        foreach ($children as $mid) {
            $child = $category->getCategory($mid);
            if (self::MenuActive($s, $child['slug']))
                $class = ' active';
            $str .= ' <li><a class="dropdown-item' . $class . '" href="' . $child['permalink'] . '">' . $child['name'] . '</a></li>';
        }
        $str .= '</ul></li>';
        return $str;
    }

    /**
     * @param $email
     * @return string
     * 邮箱转头像
     */
    public static function AuthorAvatar($email): string
    {
        $b = str_replace('@qq.com', '', $email);
        if (stristr($email, '@qq.com') && is_numeric($b) && strlen($b) < 11 && strlen($b) > 4) {
            $nk = 'https://s.p.qq.com/pub/get_face?img_type=3&uin=' . $b;
            $c = get_headers($nk, true);
            $d = $c['Location'];
            $q = json_encode($d);
            $k = explode("&k=", $q)[1];
            return 'https://q.qlogo.cn/g?b=qq&k=' . $k . '&s=100';
        } else {
            $address = strtolower(trim($email));
            $hash = md5($address);
            return 'https://cravatar.cn/avatar/' . $hash;
        }
    }

    /**
     * @param $s
     * @param $pages
     * @return void
     * 输出页面
     */
    public static function PageEcho($s, $pages)
    {
        if (Helper::options()->MergePages) {
            $str = '<li class="nav-item dropdown">';
            $str .= '<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . Helper::options()->MergePages . '</a>';
            $str .= '<ul class="dropdown-menu">';
            foreach ($pages->stack as $child) {
                if (self::MenuActive($s, $child['slug']))
                    $class = ' active';
                $str .= ' <li><a class="dropdown-item' . $class . '" href="' . $child['permalink'] . '">' . $child['title'] . '</a></li>';
            }
            $str .= '</ul></li>';
            echo $str;
        } else {
            foreach ($pages->stack as $item) {
                echo Context::MenuTag($item['permalink'], $item['title']);
            }
        }

    }

    /**
     * @param $s
     * @param $category
     * @return void
     * 输出分类
     */
    public static function CategoryEcho($s, $category)
    {
        while ($category->next()) {
            if ($category->levels === 0) {
                $children = $category->getAllChildren($category->mid);
                if (empty($children)) {
                    echo self::MenuTag($category->permalink, $category->name);
                } else {
                    echo self::DropdownMenuTag($s, $category, $children);
                }
            }
        }
    }

    /**
     * @param $limit
     * @param $ctx
     * @return mixed|string
     * 文章摘要输出
     */
    public static function ArticleExcerpt($limit, $ctx)
    {
        if ($ctx->password) {
            $abstract = "加密文章，请前往内页查看详情";
        } else {
            if ($ctx->fields->excerpt) {
                $abstract = $ctx->fields->excerpt;
            } else {
                $content = self::ExceptShortCodeContent($ctx->excerpt);
                $abstract = Common::subStr(strip_tags($content), 0, $limit, "...");;
                if (strpos($abstract, '[hide') !== false) {
                    $abstract = preg_replace('/[hide[^]]*]([\s\S]*?)[\/hide]/', '隐藏内容，请前往内页查看详情', $abstract);
                }
            }
        }
        if ($abstract === '') $abstract = "暂无简介";
        return $abstract;
    }

    //短代码排除
    private static function ExceptShortCodeContent($content)
    {
        $v = array(
            'BlurText', 'DarkBText', 'RainBowText', 'photos', 'hide', 'tabs', 'card', 'button', 'quote', 'acc',
            'progress', 'video', 'audio', 'link', 'friends', 'BiliVideo', 'event'
        );

        foreach ($v as $l) {
            if (strpos($content, '[' . $l) !== false) {
                $pattern = get_shortcode_regex(array($l));
                $content = preg_replace("/$pattern/", '', $content);
            }
        }
        $content = preg_replace('/\$\$[\s\S]*\$\$/sm', '', $content);
        return $content;
    }

    //侧边栏渲染
    public static function SidebarEcho($var): bool
    {
        if (Helper::options()->Sidebar) {
            if (in_array('ExternalPage', Helper::options()->SidebarPosition)) {
                if ($var->is('index') || $var->is('archive'))
                    $var->need('include/sidebar.php');
            }
            if (in_array('InternalPage', Helper::options()->SidebarPosition)) {
                if ($var->is('page') || $var->is('post'))
                    $var->need('include/sidebar.php');
            }
        }
        return false;
    }

    /**
     * @param $ctx
     * @return array|string|string[]|null
     * 文章内容增强
     */
    public static function CtxFilter($ctx)
    {
        return Func::ParseEmoji(Func::ParseImage(Func::ParseShortCode(Func::Hide($ctx))));
    }

    //完备标题输出
    public static function EchoTitle(Archive $archive): string
    {
        if ($archive->is('index') && Helper::options()->SiteSubtitle) {
            return Helper::options()->title . ' - ' . Helper::options()->SiteSubtitle;
        } else {
            $archive->archiveTitle(array(
                'category' => '分类 %s 下的文章',
                'search' => '包含关键字 %s 的文章',
                'tag' => '标签 %s 下的文章',
                'author' => '%s 发布的文章'
            ), '', ' - ');
            return Helper::options()->title;
        }
    }

    //顶部大图输出
    public static function HeroImage($ctx): string
    {
        if ($ctx->is('post') || $ctx->is('page')) {
            $img = self::ImageEcho($ctx);
        } else {
            if (Helper::options()->IndexTopImgUrl) {
                $img = Helper::options()->IndexTopImgUrl;
            } else {
                if (Helper::options()->RandImg) {
                    $text = Helper::options()->RandImg;
                    $img_arr = explode("\n", $text);
                    $rand_num = rand(1, count($img_arr));
                    $img = $img_arr[$rand_num - 1];
                } else {
                    $img = __CUTEEN_STATIC__ . '/img/default-list-bg.jpg';
                }
            }
        }
        return trim($img);
    }

    //列表图片输出
    public static function ImageEcho($options)
    {
        if ($options->fields->imgst) {
            return $options->fields->imgst;
        } else {
            if (Helper::options()->RandImg) {
                $text = Helper::options()->RandImg;
                $img_arr = explode("\n", $text);
                $rand_num = rand(1, count($img_arr));
                return $img_arr[$rand_num - 1];
            } else {
                return __CUTEEN_STATIC__ . "/img/default-list-bg.jpg";
            }
        }
    }

    //根据cid查询文章图片
    public static function ImageEchoByCid($cid): string
    {
        $f = Widget::widget('Widget_Archive@' . $cid, 'pageSize=1&type=post', 'cid=' . $cid);
        return self::ImageEcho($f);
    }

    //大图高度
    public static function ImgHeight(): string
    {
        if (Helper::options()->IndexTopImgHeight) {
            return 'height:' . Helper::options()->IndexTopImgHeight . ';';
        } else {
            return '';
        }
    }

    public static function IndexList($ctx): string
    {
        $img = self::ImageEcho($ctx);
        $str = '<article class="article';
        if ($ctx->sequence % 2 == 0)
            $str .= ' flex-row-reverse ';
        $str .= '">';
        $str .= '<div class="blur-img" > ';
        $str .= '<img alt = "' . $ctx->title . '" src = "' . $img . '" ></div > ';
        $str .= '<a class="d-md-block d-none article-img" href = "' . $ctx->permalink . '" > ';
        $str .= '<img class="lazy article-left-img" alt = "' . $ctx->title . '" data-src = "' . $img . '" ></a > ';
        $str .= '<div class="article-ctx" > ';
        $str .= '<div class="article-info" > ';
        $str .= '<div class="article-time d-flex align-items-center" > ';
        $str .= "<svg class='icon me-1' aria-hidden='true'><use xlink:href='#shijian'></use></svg>";
        $str .= date("Y年m月d日", $ctx->date->timeStamp) . '</div > ';
        $str .= '<div class="article-vs  d-flex align-items-center" > ';
        $str .= '<span class="article-views d-flex align-items-center" > ';
        $str .= "<svg class='icon me-1' aria-hidden='true'><use xlink:href='#huo'></use></svg>";
        $str .= Func::GetViews($ctx) . '<div class="readText me-1" > 阅读</div ></span > ';
        $str .= '<a href = "' . $ctx->categories[0]['permalink'] . '" class="article-sort d-flex align-items-center" > ';
        $str .= "<svg class='icon me-1' aria-hidden='true'><use xlink:href='#biaoqian'></use></svg>";
        $str .= $ctx->categories[0]['name'] . ' </a ></div > ';
        $str .= '</div > ';
        $str .= '<a class="article-title serif-font" href = "' . $ctx->permalink . '" > ' . $ctx->title . '</a > ';
        $str .= '<a class="article-description" href = "' . $ctx->permalink . '" > ' . Context::ArticleExcerpt(100, $ctx) . '</a ></div ></article > ';
        return $str;
    }


    public static function TopIndexArray(): string
    {
        $e = '[';
        $a = explode(",", Helper::options()->TopPost);
        for ($i = 1; $i <= count($a); $i++) {
            $i == count($a) ? $e .= $i : $e .= $i . ',';
        }
        $e .= ']';
        return $e;
    }

    public static function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL): string
    {
        $autoLink = $autoLink || Helper::options()->commentsShowUrl;
        $noFollow = $noFollow || Helper::options()->commentsUrlNofollow;
        if ($obj->url && $autoLink) {
            return '<a class="a-none" href="' . $obj->url . '"' . ($noFollow ? ' rel="external nofollow"' : NULL) . (strstr($obj->url, Helper::options()->index) == $obj->url ? NULL : ' target="_blank"') . '>' . $obj->author . '</a>';
        } else {
            return $obj->author;
        }
    }
}