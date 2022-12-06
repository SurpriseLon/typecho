<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/08/26 [ 网页脚部 ]
// +----------------------------------------------------------------------
?>

</main>

<footer id="footer" class="bg-white p-4 text-center">
    <p class="small">
        &copy; <?php echo date('Y'); ?>
        <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
    </p>
    <p class="small">
        <?php if ($this->options->ICP) : ?>
            <svg class='icon icon-20' aria-hidden='true'>
                <use xlink:href='#ICP'></use>
            </svg>
            <a href="https://beian.miit.gov.cn/#/Integrated/index" target="_blank"> <?php $this->options->ICP() ?></a>
        <?php endif; ?>
        <?php if ($this->options->Policemen) : ?>
    <span class="vr d-none d-sm-inline-block"></span><br class="d-block d-sm-none"/>
            <a target="_blank"
               href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?= preg_replace('/[^\d]*/', '', $this->options->Policemen) ?>"><?php $this->options->Policemen() ?></a>
        <?php endif; ?>
    </p>
    <!-- 此处版权可以修改或删除，建议保留，谢谢 -->
    <p class="small"> Powered by <a href="http://typecho.org" target="_blank">Typecho</a> ※ Theme is <a
                href="https://blog.zwying.com" target="_blank">Cuteen</a></p>
</footer>

<?php $this->need('include/tool.php');
$this->footer(); ?>
</body>
</html>