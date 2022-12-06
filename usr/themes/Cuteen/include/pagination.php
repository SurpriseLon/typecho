<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/1/22 [ 翻页 ]
// +----------------------------------------------------------------------
if ($this->options->Pagination == 'number'): ?>
    <div class="All_Pagination">
        <?php $this->pageNav(
            '&laquo;',
            '&raquo;',
            1,
            '...',
            array(
                'wrapTag' => 'ul',
                'wrapClass' => 'prev',
                'itemTag' => 'li',
                'textTag' => 'a',
                'currentClass' => 'active1',
                'prevClass' => '',
                'nextClass' => ''
            )
        );
        ?>
    </div>
<?php elseif ($this->options->Pagination == 'ajax'): ?>
    <div class="d-flex justify-content-center my-5">
        <?php $this->pageLink('<button id="NextButton" onclick="Cuteen.AjaxLoadPost(this)" class="btn btn-primary col-3 mx-auto rounded-pill">点击加载更多</button>', 'next'); ?>
    </div>
<?php elseif ($this->options->Pagination == 'fall'): ?>
    <div class="d-flex justify-content-center my-5">
        <?php $this->pageLink('<button id="NextButton" class="btn btn-primary col-3 mx-auto rounded-pill"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>加载中……</button>', 'next'); ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('NextButton')
            const intersectionObserver = new IntersectionObserver((entries) => {
                if (entries[0].intersectionRatio <= 0) return;
                Cuteen.AjaxLoadPost(el)
            });
            intersectionObserver.observe(el);
        })
    </script>
<?php endif; ?>