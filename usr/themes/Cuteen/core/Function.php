<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2021/12/28 [ 功能类 ]
// +----------------------------------------------------------------------
use Typecho\Db;
use Typecho\Widget;
use Utils\Helper;

class Func
{
    /**
     * @return mixed|string
     * 获取管理员邮箱
     */
    public static function GetAdminEmail()
    {
        try {
            $db = Db::get();
            return $db->fetchRow($db->select('mail')->from('table.users')->where('group = ?', 'administrator'))['mail'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $item
     * @return string
     * 查询文章浏览量
     */
    public static function GetViews($item): string
    {
        $db = Db::get();
        $result = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $item->cid))['views'];
        return self::ReadNumberConvert($result);
    }

    /**
     * @param string $object_name
     * @param $array
     * @return string
     * php、js握手
     */
    public static function LocalizeScript(string $object_name, $array): string
    {
        $script = "<div id='LocalizeScript'><script type='text/javascript'>";
        $script .= "var $object_name = " . json_encode($array) . ';';
        $script .= "</script></div>";
        return $script;
    }

    /**
     * @param $content
     * @return array|string|string[]|null
     * 解析文章内图片
     */
    public static function ParseImage($content)
    {
        $reg = '/<img(?!.*data-no-lightbox)(.*?)src="(.*?)"(.*?)>/s';
        $rp = '<a  data-fslightbox data-type="image" data-id="lightbox" href="${2}"><img${1} class="lazy" data-src="${2}" ${3}></a>';
        return preg_replace($reg, $rp, $content);
    }

    /**
     * @param $from
     * @param $now
     * @return array|false|string|string[]
     * 词义化时间
     */
    public static function TimeAgoWords($from, $now)
    {
        $between = $now - $from;
        /** 如果是一天 */
        if ($between >= 0 && $between < 86400 && date('d', $from) == date('d', $now)) {
            /** 如果是一小时 */
            if ($between < 3600) {
                /** 如果是一分钟 */
                if ($between < 60) {
                    if (0 == $between) {
                        return _t('刚刚');
                    } else {
                        return str_replace('%d', $between, _n('刚刚', '%d秒前', $between));
                    }
                }
                $min = floor($between / 60);
                return str_replace('%d', $min, _n('1分钟前', '%d分钟前', $min));
            }
            $hour = floor($between / 3600);
            return str_replace('%d', $hour, _n('1小时前', '%d小时前', $hour));
        }
        /** 如果是昨天 */
        if ($between > 0 && $between < 172800
            && (date('z', $from) + 1 == date('z', $now)                             // 在同一年的情况
                || date('z', $from) + 1 == date('L') + 365 + date('z', $now))) {    // 跨年的情况
            return _t('昨天 %s', date('H:i', $from));
        }
        /** 如果是一个星期以内 */
        if ($between > 0 && $between < 604800) {
            $day = floor($between / 86400);
            return str_replace('%d', $day, _n('1天前', '%d天前', $day));
        }
        /** 如果是一个星期以上 */
        if ($between > 0 && $between < 2592000) {
            $week = floor($between / 648000);
            return str_replace('%d', $week, _n('1周前', '%d周前', $week));
        }
        if (date('Y', $from) == date('Y', $now)) {
            return date(_t('Y年n月j日 H:i'), $from);
        }
        return date(_t('Y年m月d日 H:i'), $from);
    }

    //已发布文章数量
    public static function GetPostNum()
    {
        $db = Db::get();
        return $db->fetchObject($db->select(array('COUNT(cid)' => 'num'))
            ->from('table.contents')
            ->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish'))->num;
    }

    //评论总数量，排除自己评论
    public static function GetCommentsNum()
    {
        $db = Db::get();
        return $db->fetchObject($db->select(array('COUNT(authorId)' => 'num'))
            ->from('table.comments')
            ->where('table.comments.authorId = ?', 0)->where('table.comments.type=?', 'comment'))->num;
    }

    //标签数量
    public static function GetTagNum()
    {
        $db = Db::get();
        return $db->fetchObject($db->select(array('COUNT(mid)' => 'num'))
            ->from('table.metas')
            ->where('table.metas.type = ?', 'tag'))->num;
    }

    //归档文章列表输出
    public static function GetArchives($widget): array
    {
        $db = Db::get();
        $rows = $db->fetchAll($db->select()
            ->from('table.contents')
            ->order('table.contents.created', Db::SORT_DESC)
            ->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish'));
        $stat = array();
        foreach ($rows as $row) {
            $row = $widget->filter($row);
            $arr = array(
                'title' => $row['title'],
                'permalink' => $row['permalink']
            );
            $stat[date('Y', $row['created'])][date('m月', $row['created'])][$row['created']] = $arr;
        }
        return $stat;
    }

    //输出每年的文章数
    public static function GetYearPost($year): array
    {
        $db = Db::get();
        $tmp = strtotime($year . '-01-01 00:00:00');
        $tmp_next = strtotime($year + 1 . '-01-01 00:00:00');
        $rows = $db->fetchAll($db->select()
            ->from('table.contents')
            ->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.created >= ?', $tmp)
            ->where('table.contents.created <= ?', $tmp_next)
        );
        $words = 0;
        foreach ($rows as $key) {
            $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $key['text']);
            $words += mb_strlen($text, 'UTF-8');
        }
        return array(count($rows), self::ReadNumberConvert($words));
    }

    //获取前10标签统计
    public static function Top10Tags($ctx): array
    {
        $name = array();
        $count = array();
        $tags = null;
        $ctx->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 10))->to($tags);
        while ($tags->next()) {
            $name[] = $tags->name;
            $count[] = $tags->count;
        }
        return array($name, $count);
    }

    //获取前10分类统计
    public static function Top10TagsSort($ctx): array
    {
        $name = array();
        $arr = array();
        $sort = null;

        $ctx->widget('Widget_Metas_Category_List', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true))->to($sort);
        while ($sort->next()) {
            $name[] = [$sort->name, $sort->count, $sort->levels];
        }
        foreach ($name as $item) {
            if ($item[2] == 0) {
                $arr[] = array('value' => $item[1], 'name' => $item[0]);
            }
        }
        return $arr;
    }

    //解析短代码
    public static function ParseShortCode($content)
    {
        return do_shortcode($content);
    }

    //解析表情
    static public function ParseEmoji($content)
    {
        $content = preg_replace_callback(
            '/\:\:\(\s*(狗头|呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血)\s*\)/is',
            array('Func', 'ParsePaoPao'),
            $content
        );
        $content = preg_replace_callback(
            '/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
            array('Func', 'ParseAru'),
            $content
        );
        return $content;
    }

    //泡泡表情回调函数
    private static function ParsePaoPao($match): string
    {
        return '<img class="emoji h-8 w-auto inline-block mx-1" src="' . __CUTEEN_STATIC__ . '/img/emoji/paopao/' . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }

    //阿鲁表情回调函数
    private static function ParseAru($match): string
    {
        return '<img class="emoji" src="' . __CUTEEN_STATIC__ . '/img/emoji/aru/' . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }

    //回复可见功能
    public static function Hide($ctx)
    {
        $db = Db::get();
        $sql = $db->select()->from('table.comments')
            ->where('cid = ?', $ctx->cid)
            ->where('mail = ?', $ctx->remember('mail', true))
            ->where('status = ?', 'approved')
            ->limit(1);
        $result = $db->fetchAll($sql);
        if ($ctx->widget('Widget_User')->hasLogin() || $result) {
            $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", "<div class='hide-text'>$1</div>", $ctx->content);
        } else {
            $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="reply2view">此处内容需要评论<a onclick="document.getElementById(`comments`).scrollIntoView({behavior: `smooth`});">回复</a>后方可阅读</div>', $ctx->content);
        }
        return $content;
    }

    //输出最受欢迎文章 todo：待完善
    public static function theMostViewed($limit = 10, $before = '<br/> - ( 访问: ', $after = ' 次 ) ')
    {
        $db = Db::get();
        $options = Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 10;
        $posts = $db->fetchAll($db->select()->from('table.contents')
            ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
            ->order('views', Db::SORT_DESC)
            ->limit($limit)
        );

        if ($posts) {
            foreach ($posts as $post) {
                $result = Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_views = number_format($result['views']);
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
                echo "<li><a href='$permalink' title='$post_title'>$post_title</a><span style='font-siz

e:70%'>$before $post_views $after</span></li>\n";
            }

        } else {
            echo "<li>N/A</li>\n";
        }
    }

    //文章字数输出，去除字符，只统计中文
    public static function GetWordCount($cid)
    {
        $db = Db::get();
        $rs = $db->fetchRow($db->select('table.contents.text')->from('table.contents')->where('table.contents.cid=?', $cid)->order('table.contents.cid', Db::SORT_ASC)->limit(1));
        $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']);
        return mb_strlen($text, 'UTF-8');
    }

    /** 阅读数友好化 */
    public static function ReadNumberConvert($num)
    {
        if ($num >= 100000) {
            $num = round($num / 10000) . 'w';
        } else if ($num >= 10000) {
            $num = round($num / 10000, 1) . 'w';
        } else if ($num >= 1000) {
            $num = round($num / 1000, 1) . 'k';
        }
        return $num;
    }

    //下一篇
    public static function theNext($widget, $default = NULL)
    {
        $db = Db::get();
        $sql = $db->select()->from('table.contents')
            ->where('table.contents.created > ?', $widget->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $widget->type)
            ->where('table.contents.password IS NULL')
            ->order('table.contents.created', Db::SORT_ASC)
            ->limit(1);
        $content = $db->fetchRow($sql);
        if ($content) {
            return $widget->filter($content);
        } else {
            return $default;
        }
    }

    //上一篇
    public static function thePrev($widget, $default = NULL)
    {
        $db = Db::get();
        $sql = $db->select()->from('table.contents')
            ->where('table.contents.created < ?', $widget->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $widget->type)
            ->where('table.contents.password IS NULL')
            ->order('table.contents.created', Db::SORT_DESC)
            ->limit(1);
        $content = $db->fetchRow($sql);
        if ($content) {
            return $widget->filter($content);
        } else {
            return $default;
        }
    }

    // 读出点赞数量
    public static function LikesNumber($cid)
    {
        $db = Db::get();
        $row = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid));
        if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents')))) {
            return 0;
        } else {
            return $row['likes'];
        }
    }

    //解析歌单url
    public static function ParseMusic($url): array
    {
        if (Helper::options()->MusicList) {
            return array('media' => null, 'id' => null, 'type' => null);
        }
        $media = null;
        $id = null;
        $type = null;
        if (empty($url)) {
            return array('media' => 'media', 'id' => 'id', 'type' => 'type');
        }
        if (strpos($url, '163.com') !== false) {
            $media = 'netease';
            if (preg_match('/playlist\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'playlist');
            elseif (preg_match('/toplist\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'playlist');
            elseif (preg_match('/album\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'album');
            elseif (preg_match('/song\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'song');
            elseif (preg_match('/artist\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'artist');
        } elseif (strpos($url, 'qq.com') !== false) {
            $media = 'tencent';
            if (preg_match('/playlist\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'playlist');
            elseif (preg_match('/album\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'album');
            elseif (preg_match('/song\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'song');
            elseif (preg_match('/singer\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'artist');
        }
        return array('media' => $media, 'id' => $id, 'type' => $type);
    }
}