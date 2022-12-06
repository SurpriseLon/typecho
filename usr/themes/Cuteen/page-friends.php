<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/1/15 [ 归档页 ]
// +----------------------------------------------------------------------
/**
 * 朋友圈
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
?>
<div class="row justify-content-center <?= ($this->options->SidebarRorL == 'R-L') ? 'flex-row-reverse' : '' ?>">
    <?php Context::SidebarEcho($this) ?>
    <div class="my-4 col-lg-9">
        <section class="container friends card p-4 typography">
        <?= Context::CtxFilter($this) ?>
        </section>
    </div>
</div>
<?php $this->need('include/footer.php'); ?>
