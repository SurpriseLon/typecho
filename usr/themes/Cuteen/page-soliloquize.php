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
 * 闪念说说
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
function threadedComments($comments)
{ ?>
    <li class="timeline-item" id="<?php $comments->theId(); ?>">
        <span class="timeline-icon">
            <svg class='icon icon-20' aria-hidden='true'><use xlink:href='#book'></use></svg>
        </span>
        <h6 class="pt-1 text-xs">发表于 <?= Func::TimeAgoWords($comments->date->timeStamp, time()) ?></h6>
        <div class="text-black fw-bold serif-font"><?= Context::CtxFilter($comments) ?></div>
    </li>
<?php }

$this->comments()->to($comments); ?>

<div class="row justify-content-center <?= ($this->options->SidebarRorL == 'R-L') ? 'flex-row-reverse' : '' ?>">
    <?php Context::SidebarEcho($this) ?>
    <div class="mt-4 col-lg-9">
        <section class="py-5 card">
            <?php if ($this->user->hasLogin()) : ?>
                <div class="comment-input-warp mx-4 mb-5" id="<?php $this->respondId(); ?>">
                    <form class="row g-3" id="comment-form" method="post" data-action="<?php $this->commentUrl() ?>">
                            <div class="p-2 px-3 font-weight-bold"><?php $this->user->screenName(); ?>，发一条说说吧~</div>
                        <div class="col-md-12">
                    <textarea id="comment-textarea" rows="3" class="form-control" name="text" placeholder="评论内容"
                              aria-label="评论内容" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="position-relative">
                                <button id="OwO-btn" type="button" class="btn btn-link">✪ω✪</button>
                                <div id="OwO" class="OwO"></div>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="Cuteen.Comment(this)">提交评论</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            <ul class="timeline-with-icons" id="comments">
                <?php $comments->listComments(); ?>
            </ul>
            <div class="All_Pagination">
                <?php $comments->pageNav('&laquo;', '&raquo;', 1, '...', array(
                    'wrapTag' => 'ul',
                    'wrapClass' => 'prev',
                    'itemTag' => 'li',
                    'textTag' => 'a',
                    'currentClass' => 'active1',
                    'prevClass' => '',
                    'nextClass' => ''
                )); ?>
            </div>
        </section>
    </div>
</div>
<?php $this->need('include/footer.php'); ?>
