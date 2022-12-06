<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/9/18 [ 分类、搜索页 ]
// +----------------------------------------------------------------------
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
?>
<div class="row justify-content-center <?= ($this->options->SidebarRorL == 'R-L') ? 'flex-row-reverse' : '' ?>">
    <?php Context::SidebarEcho($this) ?>
    <section class="mt-4 col-lg-9">
        <div id="article-list">
            <?php while ($this->next()): ?>
                <?= Context::IndexList($this) ?>
            <?php endwhile; ?>
        </div>
        <?php $this->need('include/pagination.php'); ?>
    </section>
</div>
<?php $this->need('include/footer.php'); ?>
