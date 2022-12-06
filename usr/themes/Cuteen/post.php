<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/1/4 [ 文章内页 ]
// +----------------------------------------------------------------------
use Typecho\Widget;

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
$prev = Func::thePrev($this);
$next = Func::theNext($this);
?>
    <div class="row justify-content-center <?= ($this->options->SidebarRorL == 'R-L') ? 'flex-row-reverse' : '' ?>">
        <?php Context::SidebarEcho($this) ?>
        <div class="mt-4 col-lg-9">
            <section class="card">
                <div class="d-flex text-xs mx-4 py-4 border-bottom">
                    <span class="item flex items-center">
                        <svg class="icon me-1" aria-hidden="true"><use xlink:href="#home"></use></svg>
                        <a href="<?php $this->options->siteUrl(); ?>" title="首页">首页</a>
                    </span>
                    <span class="mx-2">/</span>
                    <?php if (sizeof($this->categories) > 0) : ?>
                        <span class="item">
                            <a href="<?php echo $this->categories[0]['permalink']; ?>"
                               title="<?php echo $this->categories[0]['name']; ?>"><?php echo $this->categories[0]['name']; ?></a>
                        </span>
                        <span class="mx-2">/</span>
                    <?php endif; ?>
                    <span class="item">正文</span>
                </div>
                <div id="post-box" class="my-4 px-3 px-md-4 h-100">
                    <?php if ($this->hidden || $this->titleShow) : ?>
                        <form class="row g-3"
                              action="<?= Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>"
                              method="post">
                            <p class="fs-4 fw-bold">此篇文章已被<font color="red">加密</font>，请输入密码后查看</p>
                            <div class="col-auto">
                                <label for="inputPassword" class="visually-hidden">密码</label>
                                <input type="password" name="protectPassword" class="form-control" id="inputPassword"
                                       placeholder="Password">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">确认提交</button>
                            </div>
                            <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>"/>
                        </form>
                    <?php else : ?>
                        <article class="typography" id="post">
                            <?= Context::CtxFilter($this) ?>
                        </article>

                        <div class="d-flex pt-4 mt-5 align-items-center border-top">
                            <svg class="icon icon-20 me-1" aria-hidden="true">
                                <use xlink:href="#biaoqian1"></use>
                            </svg>
                            <div class="d-flex flex-wrap align-items-center text-xs space-x-2 space-y-2" id="tag">
                                <?php $this->tags('', true, '<span>无标签</span>'); ?>
                            </div>
                        </div>

                        <?php if ($this->options->Copyright) : ?>
                            <div class="copyright text-xs">
                                <?php if (in_array('author', $this->options->CopyrightConfiguration)) : ?>
                                    <div class="d-flex align-items-center">
                                        <svg class="icon me-1" aria-hidden="true">
                                            <use xlink:href="#profile"></use>
                                        </svg>
                                        <div class="copyright-text">版权属于：<?php $this->author() ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if (in_array('provenance', $this->options->CopyrightConfiguration)) : ?>
                                    <div class="d-flex align-items-center">
                                        <svg class="icon me-1" aria-hidden="true">
                                            <use xlink:href="#loaction"></use>
                                        </svg>
                                        <div class="copyright-text">本文链接：<?php $this->permalink() ?></div>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex align-items-center">
                                    <svg class="icon me-1" aria-hidden="true">
                                        <use xlink:href="#diamond"></use>
                                    </svg>
                                    <?php if (!$this->options->CopyrightText) : ?>
                                        <div class="copyright-text">作品采用 <a class="text-decoration-none"
                                                                                target="_blank"
                                                                                href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh-Hans">
                                                知识共享署名-非商业性使用-相同方式共享 4.0 国际许可协议 </a>进行许可
                                        </div>
                                    <?php else : ?>
                                        <div class="copyright-text"><?php $this->options->CopyrightText() ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="text-center d-flex justify-content-center my-5">
                            <?php if ($this->options->UpLikes) : ?>
                                <div class='like-button me-2' onclick="Cuteen.PostLike()">
      <span class='like-icon'>
        <div class='heart-animation-1'></div>
        <div class='heart-animation-2'></div>
      </span>赞 <span id="likeNumber" class="serif-font ms-1"><?= Func::LikesNumber($this->cid) ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->options->Reward) : ?>
                                <div class="reward-button ms-2" data-bs-toggle="modal" data-bs-target="#rewardModal">
                                    <svg class="icon icon-20 me-1" aria-hidden="true">
                                        <use xlink:href="#jinbi"></use>
                                    </svg>
                                    <span>打赏</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row m-0">
                            <div class="col-6 post-link-box rounded-start">
                                <a class="prev-card-img serif-font" href="<?= $prev['permalink'] ?>"
                                   style="background-image: url(<?= Context::ImageEchoByCid($prev['cid']) ?>);">
                                    <?php if ($prev): ?>
                                        <span class="line-clamp-2"><?= $prev['title'] ?></span>
                                    <?php else: ?>
                                        <span>已经没有了</span>
                                    <?php endif; ?>
                                    <div class="text-xs post-link-text">« 上一篇</div>
                                </a>
                            </div>

                            <div class="col-6 post-link-box rounded-end">
                                <a class="next-card-img serif-font" href="<?= $next['permalink'] ?>"
                                   style="background-image: url(<?= Context::ImageEchoByCid($next['cid']) ?>);">
                                    <?php if ($next): ?>
                                        <span class="line-clamp-2"><?= $next['title'] ?></span>
                                    <?php else: ?>
                                        <span>已经没有了</span>
                                    <?php endif; ?>
                                    <div class="text-xs post-link-text">下一篇 »</div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <?php if ($this->allow('comment')) : ?>
                <?php $this->need('include/comment.php'); ?>
            <?php endif; ?>


        </div>
    </div>

<?php if ($this->options->Reward) $this->need('include/reward.php');
$this->need('include/footer.php'); ?>