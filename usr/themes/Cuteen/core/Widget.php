<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/1/2 [ 继承方法 ]
// +----------------------------------------------------------------------
class Cuteen_Contents_Sort extends Widget_Abstract_Contents
{
    public function execute()
    {
        $this->parameter->setDefault(array('page' => 1, 'pageSize' => 10, 'type' => 'created'));
        $offset = $this->parameter->pageSize * ($this->parameter->page - 1);
        $select = $this->select();
        $select->cleanAttribute('fields');
        $this->db->fetchAll(
            $select
                ->from('table.contents')
                ->where('table.contents.type = ?', 'post')
                ->where('table.contents.status = ?', 'publish')
                ->where('table.contents.created < ?', time())
                ->limit($this->parameter->pageSize)
                ->offset($offset)
                ->order($this->parameter->type, Typecho_Db::SORT_DESC),
            array($this, 'push')
        );
    }
}

//随机文章
class Widget_Post_rand extends Widget_Abstract_Contents
{
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
    }
    public function execute()
    {
        $select  = $this->select()->from('table.contents')
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.created <= ?', time())
            ->where('table.contents.type = ?', 'post')
            ->limit($this->parameter->pageSize)
            ->order('RAND()');
        $this->db->fetchAll($select, array($this, 'push'));
    }
}

//置顶类
class Widget_Post_top extends Widget_Abstract_Contents
{
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
    }
    public function execute()
    {
        $select  = $this->select()->from('table.contents')
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->where('table.contents.type = ?', 'post')
            ->limit($this->parameter->pageSize);

        if ($this->parameter->CardTOP) {
            $CardTOPSel = explode(",", $this->parameter->CardTOP);
            foreach ($CardTOPSel as $key){
                if (is_numeric($key)) {
                    $select->where('table.contents.cid in ?', $CardTOPSel);
                }else{
                    $select->where('table.contents.slug in ?', $CardTOPSel);
                }
            }
        }
        $this->db->fetchAll($select, array($this, 'push'));
    }
}