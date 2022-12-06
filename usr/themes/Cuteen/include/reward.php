<?php
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | [ 打赏 ]
// +----------------------------------------------------------------------
?>
<div class="modal fade" id="rewardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title serif-font fw-bold" id="exampleModalLabel">赞赏支持,更有情怀</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php if ($this->options->Alipay) : ?>
                            <button class="nav-link active d-inline-flex" id="nav-alipay-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-alipay" type="button" role="tab" aria-controls="nav-alipay"
                                    aria-selected="true">
                                <svg class="icon icon-30" aria-hidden="true">
                                    <use xlink:href="#zhifubao"></use>
                                </svg>
                                支付宝
                            </button>
                        <?php endif; ?>
                        <?php if ($this->options->WeChatPay) : ?>
                            <button class="nav-link d-inline-flex" id="nav-wechat-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-wechat" type="button" role="tab" aria-controls="nav-wechat"
                                    aria-selected="false">
                                <svg class="icon icon-30 me-1" aria-hidden="true">
                                    <use xlink:href="#weixinzhifu"></use>
                                </svg>
                                微信
                            </button>
                        <?php endif; ?>
                        <?php if ($this->options->QQPay) : ?>
                            <button class="nav-link d-inline-flex" id="nav-qq-tab" data-bs-toggle="tab" data-bs-target="#nav-qq"
                                    type="button" role="tab" aria-controls="nav-qq" aria-selected="false">
                                <svg class="icon icon-30 me-1" aria-hidden="true">
                                    <use xlink:href="#QQ"></use>
                                </svg>
                                QQ
                            </button>
                        <?php endif; ?>
                    </div>
                </nav>
                <div class="tab-content text-center mt-2" id="reward-tab-content">
                    <?php if ($this->options->Alipay) : ?>
                        <div class="tab-pane fade show active" id="nav-alipay" role="tabpanel"
                             aria-labelledby="nav-alipay-tab" tabindex="0">
                            <img src="<?php $this->options->Alipay() ?>" alt="alipay"></div>
                    <?php endif; ?>
                    <?php if ($this->options->WeChatPay) : ?>
                        <div class="tab-pane fade" id="nav-wechat" role="tabpanel" aria-labelledby="nav-wechat-tab"
                             tabindex="0"><img src="<?php $this->options->WeChatPay() ?>"></div>
                    <?php endif; ?>
                    <?php if ($this->options->QQPay) : ?>
                        <div class="tab-pane fade" id="nav-qq" role="tabpanel" aria-labelledby="nav-qq-tab"
                             tabindex="0"><img src="<?php $this->options->QQPay() ?>"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
