<?php
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/2/21 [ 404 ]
// +----------------------------------------------------------------------
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
?>
<div class="my-5 d-flex justify-content-center">
    <img src="<?= __CUTEEN_STATIC__ . '/img/404.svg'; ?>" class="img404" alt="404">
</div>
<?php $this->need('include/footer.php'); ?>