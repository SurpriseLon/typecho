<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/2/16 [ 首页置顶 ]
// +----------------------------------------------------------------------

$TopPost = $this->options->TopPost;
$this->widget('Widget_Post_top@CardTOP', 'CardTOP=' . $TopPost)->to($CardTOPSel);
?>
<div id="post-top" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php for ($i = 0; $CardTOPSel->next(); $i++): ?>
            <button type="button" data-bs-target="#post-top"
                    data-bs-slide-to="<?= $i ?>"<?= $i == 0 ? ' class="active" aria-current="true"' : '' ?>
                    aria-label="Slide <?= $i ?>"></button>
        <?php endfor; ?>
    </div>
    <div class="carousel-inner">
        <?php for ($i = 0; $CardTOPSel->next(); $i++): ?>
            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                <img src="<?= Context::ImageEcho($CardTOPSel) ?>" class="d-block w-100" alt="<?= $CardTOPSel->title ?>">
                <a class="carousel-caption" href="<?= $CardTOPSel->permalink ?>">
                    <h3 class="fw-bold serif-font"><?= $CardTOPSel->title ?></h3>
                    <ul class="post-title-info">
                        <li class="md:flex d-none d-md-flex">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#biaoqian2"></use>
                            </svg>
                            <span><?= $CardTOPSel->categories[0]['name'] ?></span>
                        </li>
                        <li>
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#huo"></use>
                            </svg>
                            <span><?= Func::GetViews($CardTOPSel) ?>阅读</span>
                        </li>
                        <li>
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#shijian"></use>
                            </svg>
                            <span><?= date("Y年m月d日", $CardTOPSel->date->timeStamp) ?></span>
                        </li>
                        <li>
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#pinglun1"></use>
                            </svg>
                            <span><?php $CardTOPSel->commentsNum('%d'); ?>评论</span>
                        </li>
                    </ul>
                </a>
            </div>
        <?php endfor; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#post-top" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#post-top" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
