<?php
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/2/19 [ 后台主题项备份 ]
// +----------------------------------------------------------------------

$name = 'Cuteen';
$db = Typecho_Db::get();
$sjdq = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name));
$ysj = $sjdq['value'];
if (isset($_POST['type'])) {
    if ($_POST["type"] == "备份模板") {
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'))) {
            $update = $db->update('table.options')->rows(array('value' => $ysj))->where('name = ?', 'theme:' . $name . 'bf');
            $updateRows = $db->query($update); ?>
            <script>
                let flag = confirm("备份更新成功!");
                if (flag || !flag) window.location.href = '<?php Helper::options()->adminUrl('options-theme.php');?>'
            </script>
        <?php } else {
            if ($ysj) {
                $insert = $db->insert('table.options')->rows(array('name' => 'theme:' . $name . 'bf', 'user' => '0', 'value' => $ysj));
                $insertId = $db->query($insert); ?>
                <script>
                    let flag = confirm("备份成功!");
                    if (flag || !flag) window.location.href = '<?php Helper::options()->adminUrl('options-theme.php');?>'
                </script>
            <?php }
        }
    }
    if ($_POST["type"] == "还原备份") {
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'))) {
            $sjdub = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'));
            $bsj = $sjdub['value'];
            $update = $db->update('table.options')->rows(array('value' => $bsj))->where('name = ?', 'theme:' . $name);
            $updateRows = $db->query($update); ?>
            <script>
                let flag = confirm("恢复成功！");
                if (flag || !flag) window.location.href = '<?php Helper::options()->adminUrl('options-theme.php');?>'
            </script>
        <?php } else { ?>
            <script>
                let flag = confirm("未备份过数据，无法恢复！");
                if (flag || !flag) window.location.href = '<?php Helper::options()->adminUrl('options-theme.php');?>'
            </script>
        <?php } ?>
    <?php } ?>
    <?php if ($_POST["type"] == "删除备份") {
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'))) {
            $delete = $db->delete('table.options')->where('name = ?', 'theme:' . $name . 'bf');
            $deletedRows = $db->query($delete); ?>
            <script>
                let flag = confirm("删除成功！");
                if (flag || !flag) window.location.href = '<?php Helper::options()->adminUrl('options-theme.php');?>'
            </script>
        <?php } else { ?>
            <script>
                let flag = confirm("没有备份内容，无法删除！");
                if (flag || !flag) window.location.href = '<?php Helper::options()->adminUrl('options-theme.php');?>'
            </script>
        <?php } ?>
    <?php } ?>

    <?php if ($_POST["type"] == "生成地图") {
        $doc = new \DOMDocument('1.0', 'utf-8');//引入类并且规定版本编码
        $urlset = $doc->createElement("urlset");//创建节点
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('status = ?', 'publish')
            ->where('type = ?', 'post')
            ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
            ->limit(100)
            ->order('created', Typecho_Db::SORT_DESC)
        );
        if ($result) {
            foreach ($result as $val) {
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $permalink = $val['permalink'];
                $created = date('Y-m-d', $val['created']);
                /*循环输出节点*/
                $url = $doc->createElement("url");//创建节点
                $loc = $doc->createElement("loc");//创建节点
                $lastmod = $doc->createElement("lastmod");//创建节点
                $urlset->appendChild($url);//
                $url->appendChild($loc);//将loc放到url下
                $url->appendChild($lastmod);
                $content = $doc->createTextNode($permalink);//设置标签内容
                $contime = $doc->createTextNode($created);//设置标签内容
                $loc->appendChild($content);//将标签内容赋给标签
                $lastmod->appendChild($contime);//将标签内容赋给标签
            }
        }
        $doc->appendChild($urlset);//创建顶级节点
        $doc->save("./../sitemap.xml");//保存代码
        echo '<script>
                let flag = confirm("地图已生成！");
                if (flag || !flag) window.location.href = "' . Helper::options()->adminUrl . 'options-theme.php"
            </script>';
    } ?>
<?php } ?>
<form class="backup" action="?Cuteenbf" method="post">
    <input type="submit" name="type" value="生成地图">
    <input type="submit" name="type" value="备份模板">
    <input type="submit" name="type" value="还原备份">
    <input type="submit" name="type" value="删除备份">
</form>