<?php

use Typecho\Db;
use Typecho\Widget;
use Widget\ActionInterface;

/**
 * Cuteen Plugin
 *
 * @copyright  Copyright (c) 2022 Veen Zhao (http://blog.zwying.com)
 * @license    GNU General Public License 2.0
 *
 */

class Cuteen_Action extends Widget implements ActionInterface
{
    private $db;

    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->db = Db::get();
        $this->options = $this->widget('Widget_Options');
        $this->user = $this->widget('Widget_User');
    }

    public function action()
    {
        $this->body = json_decode(file_get_contents('php://input'), true);
        switch ($this->body['type']) {
            case 'getAvatar':
                $this->get_qq_info();
                break;
            case 'likes':
                $this->vote_content();
                break;
            default:
                $this->response->throwJson("非法请求！抓起来( •̀ ω •́ )y");
                break;
        }
    }

    private function vote_content()
    {
        header("Content-type:application/json");
        $cid = $this->body['cid'];
        if ($cid) {
            try {
                $row = $this->db->fetchRow($this->db->select('likes')->from('table.contents')->where('cid = ?', $cid));
                $this->db->query($this->db->update('table.contents')->rows(array('likes' => (int)$row['likes'] + 1))->where('cid = ?', $cid));
                $this->response->throwJson("success");
                echo $row;
            } catch (Exception $ex) {
                echo $ex->getCode();
            }
        } else {
            echo "error";
        }
    }

    private function get_qq_info()
    {
        header('Content-Type: text/html;charset=utf-8');
        $QQ = $this->body['qq'];
        if (trim(empty($QQ))) {
            $result = "请输入qq号！";
        } else {
            $urlPre = 'https://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=';
            $data = file_get_contents($urlPre . $QQ);
            $data = iconv("GBK", "UTF-8", $data);
            $pattern = '/portraitCallBack\((.*)\)/is';
            preg_match($pattern, $data, $tmp);
            $tmp = $tmp[1];
            $arr =json_decode($tmp, true)["$QQ"];
            $result = array('name' =>$arr[6], 'qq_avatar' => self::AuthorAvatar($QQ . '@qq.com'));
        }
        $this->response->setStatus(200);
        $this->response->throwJson(array("data" => $result));
    }
    /**
     * @param $email
     * @return string
     * 邮箱转头像
     */
    private function AuthorAvatar($email): string
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
}

