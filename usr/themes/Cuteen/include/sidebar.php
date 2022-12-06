<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/1/24 [ 侧边栏 ]
// +----------------------------------------------------------------------

if ($this->options->Sidebar): ?>
<section class="mt-4 col-lg-3">
    <div class="h-100 d-none d-lg-block">
        <section class="sidebar-author card">
            <div class="sidebar-banner"
                 style="background-image: url('<?= $this->options->SidebarBackgroundImg ?: __CUTEEN_STATIC__ . '/img/center-bg.svg' ?>')"></div>
            <div class="text-center">
                <?php if ($this->options->SideAvatar): ?>
                    <img class="sidebar-avatar" src="<?= $this->options->SideAvatar ?>" alt="avatar">
                <?php else: ?>
                    <img class="sidebar-avatar" src="<?= Context::AuthorAvatar(Func::GetAdminEmail()) ?>" alt="avatar">
                <?php endif; ?>
            </div>
            <h2 class="fw-bold serif-font mt-5 fs-4 text-center"><?php $this->author() ?></h2>
            <?php if ($this->options->Signature): ?>
                <span class="sidebar-sign"><?= $this->options->Signature ?></span>
            <?php endif; ?>
            <div class="border-top">
                <table class="text-center my-2 w-100 serif-font">
                    <tr class="fs-6 w-100">
                        <th>文章</th>
                        <th>评论</th>
                        <th>标签</th>
                    </tr>
                    <tr>
                        <td><?= Func::GetPostNum() ?></td>
                        <td><?= Func::GetCommentsNum() ?></td>
                        <td><?= Func::GetTagNum() ?></td>
                    </tr>
                </table>
            </div>
        </section>
        <section class="sidebar-comment-box card mt-4">
            <div class="px-4 py-2 my-2 d-flex align-items-center border-bottom">
                <svg class="icon icon-20 me-1" aria-hidden="true">
                    <use xlink:href="#forhelp"></use>
                </svg>
                <span>最新回复</span>
            </div>
            <?php $com = null;
            $this->widget('Widget_Comments_Recent', 'ignoreAuthor=false&pageSize=5')->to($com); ?>
            <div>
                <?php while ($com->next()) : ?>
                        <div class="px-3 my-2 text-xs">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <img class="sidebar-comment-avatar"
                                         src="<?= Context::AuthorAvatar($com->mail) ?>"
                                         alt="<?php $com->author(false) ?>">
                                    <?php $com->author(false) ?>
                                </div>
                                <time class="d-flex align-items-center">
                                    <?= $com->date(' Y 年 m 月 d 日'); ?>
                                </time>
                            </div>
                            <a href="<?php $com->permalink() ?>" class="p-2 card sidebar-comment">
                                <div class="line-clamp-2">
                                    <?php
                                    $str = preg_replace("/<p.*?>|<\/p>/is", "", Context::CtxFilter($com));
                                    $str = htmlspecialchars_decode($str);
                                    echo preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $str);
                                    ?>
                                </div>
                            </a>
                        </div>
                <?php endwhile; ?>
            </div>
        </section>
        <section class="sidebar-rand-box card mt-4">
            <div class="px-4 py-2 my-2 d-flex align-items-center border-bottom">
                <svg class="icon icon-20 me-1" aria-hidden="true">
                    <use xlink:href="#eyeshield"></use>
                </svg>
                <span>随便看看</span>
            </div>
            <?php $rand = null;
            $this->widget('Widget_Post_rand@rand', 'pageSize=3')->to($rand); ?>
            <?php while ($rand->next()) : ?>
                <div class="px-3 pb-3">
                    <div class="sidebar-rand-item">
                        <a class="sidebar-rand-img" href="<?php $rand->permalink() ?>"
                           style="background-image: url(<?= Context::ImageEcho($rand) ?>);">
                        </a>
                        <div class="sidebar-rand-info">
                            <a href="<?php $rand->permalink() ?>">
                                <div class="sidebar-rand-date"><?php $rand->date(' Y 年 m 月 d 日'); ?></div>
                                <div class="sidebar-rand-title line-clamp-1"><?php $rand->title(); ?></div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>
    </div>
</section>
<?php endif; ?>
