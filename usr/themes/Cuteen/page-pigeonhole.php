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
 * 文章归档
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
?>
<script src="<?= __CUTEEN_STATIC__ . '/js/echarts.min.js'; ?>"></script>
<div class="row justify-content-center <?= ($this->options->SidebarRorL == 'R-L') ? 'flex-row-reverse' : '' ?>">
    <?php Context::SidebarEcho($this) ?>
    <div class="my-4 col-lg-9">
        <section class="container pigeonhole card py-4">
            <div class="d-inline-flex serif-font fw-bold pl-5 mb-4 align-items-center">
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#jihebiaoshi01"></use>
                </svg>
                <span class="fs-4">总览</span>
            </div>
            <div class="row px-md-4 g-3">
                <div class="col-md-4">
                    <div class="card-counter text-bg-primary border-primary border border-2">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#wenzhang"></use>
                        </svg>
                        <div class="d-flex flex-column justify-content-between">
                            <div class="count-numbers serif-font fw-bold"><?= Func::GetPostNum() ?></div>
                            <div class="count-name">文章总计</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-counter text-bg-warning border-warning border border-2">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#tag"></use>
                        </svg>
                        <div class="d-flex flex-column justify-content-between">
                            <div class="count-numbers serif-font fw-bold"><?= Func::GetTagNum() ?></div>
                            <div class="count-name">标签总计</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-counter text-bg-success border-success border border-2">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#tanlun"></use>
                        </svg>
                        <div class="d-flex flex-column justify-content-between">
                            <div class="count-numbers serif-font fw-bold"><?= Func::GetCommentsNum() ?></div>
                            <div class="count-name">评论总计</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-inline-flex serif-font fw-bold pl-5 py-3 my-4 align-items-center">
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#jihebiaoshi16"></use>
                </svg>
                <span class="fs-4">统计图</span>
            </div>
            <div class="row px-md-4 g-3">
                <div class="col-md-6">
                    <div id="echarts_pie"></div>
                </div>
                <div class="col-md-6">
                    <div id="echarts_line"></div>
                </div>
            </div>

            <div class="d-inline-flex serif-font fw-bold pl-5 pt-3 my-4 align-items-center">
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#jihebiaoshi18"></use>
                </svg>
                <span class="fs-4">文章列表</span>
            </div>

            <div class="accordion px-md-4" id="postAccordion">
                <?php $archives = Func::GetArchives($this);
                foreach ($archives as $year => $month) : ?>
                <div class="accordion-item my-3">
                    <h2 class="accordion-header" id="flush-<?= $year; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse-<?= $year; ?>" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                            <div class="d-flex align-items-center">
                                <span class="fw-bold fs-5 me-3"><?= $year; ?> 年</span>
                                <div class="d-none d-md-flex align-items-center">
                                    <svg class="item-icon icon me-1" aria-hidden="true">
                                        <use xlink:href="#pen1"></use>
                                    </svg>
                                    <span class="fw-bold fs-5"><?= Func::GetYearPost($year)[0] ?></span>&nbsp;篇&nbsp;
                                    <svg class="item-icon icon me-1 ms-2" aria-hidden="true">
                                        <use xlink:href="#file"></use>
                                    </svg>
                                    <span class="fw-bold fs-5"><?= Func::GetYearPost($year)[1] ?></span>&nbsp;字
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="flush-collapse-<?= $year; ?>" class="accordion-collapse collapse" aria-labelledby="flush-<?= $year; ?>"
                         data-bs-parent="#postAccordion">
                        <div class="accordion-body ms-md-3">
                            <ul class="timeline">
                                <?php foreach ($month as $time => $title) : ?>
                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold"><?= $time ?></h5>
                                    <p class="text-muted">
                                        <?php foreach ($title as $created => $post) : ?>
                                            <a class="ms-md-3 d-block my-3" href="<?php echo $post['permalink']; ?>"><?php echo date('m-d  ', $created); ?><?php echo $post['title']; ?></a>
                                        <?php endforeach; ?>
                                    </p>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </section>
    </div>
</div>
<script>
    function EchartsInit() {
        const pie = echarts.init(document.getElementById('echarts_pie'), null, {renderer: 'svg'});
        const line = echarts.init(document.getElementById('echarts_line'), null, {renderer: 'svg'});
        let lineOption = {
            title: {text: '标签统计', top: 2, x: 'center'},
            grid: {position: 'center'},
            tooltip: {trigger: 'axis', axisPointer: {type: 'shadow'}},
            xAxis: [{type: 'category', data: <?=json_encode(Func::Top10Tags($this)[0])?>,}],
            yAxis: [{type: 'value', max: <?= @max(Func::Top10Tags($this)[1]) + 2?>}],
            series: [
                {
                    type: 'bar', data: <?=json_encode(Func::Top10Tags($this)[1])?>, itemStyle: {color: '#45B5C6'},
                    markPoint: {
                        symbolSize: 45,
                        data: [{type: 'max', itemStyle: {color: '#28A745'}, name: '最多'},
                            {type: 'min', itemStyle: {color: '#EF4444'}, name: '最少'}]
                    },
                    markLine: {itemStyle: {color: '#6610F2'}, data: [{type: 'average', name: '平均值'}]}
                }
            ]
        };
        let pieOption = {
            title: {text: '分类统计', top: 2, x: 'center'},
            grid: {position: 'center'},
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: 'Access From',
                    type: 'pie',
                    radius: '50%',
                    data: <?=json_encode(Func::Top10TagsSort($this))?>,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        line.setOption(lineOption);
        pie.setOption(pieOption);
    }

    window.onload = function () {
        EchartsInit();
    }
</script>
<?php $this->need('include/footer.php'); ?>
