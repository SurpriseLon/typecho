<?php
// +----------------------------------------------------------------------
// | Cuteen 5.x [ 给时光以生命，给岁月以文明 ]
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/8/20 [ 导航栏 ]
// +----------------------------------------------------------------------
$this->widget('Widget_Contents_Page_List')->to($pages);
$this->widget('Widget_Metas_Category_List')->to($category);
?>

<nav class="navbar navbar-expand-md fixed-top px-2 px-md-5 has-img" id="navPC">
    <div class="container-fluid">
        <ul class="navbar-nav d-md-none">
            <li class="nav-item navbar-icon">
                <svg class="icon icon-20 " aria-hidden="true" data-bs-toggle="offcanvas"
                     data-bs-target="#offcanvasNavbar">
                    <use xlink:href="#menu"></use>
                </svg>
            </li>
        </ul>

        <a class="navbar-brand m-0 me-md-3" href="<?= $this->options->siteUrl ?>">
            <?php if ($this->options->LogoUrl): ?>
                <img id="light-logo" class="navbar-logo" src="<?= Context::EchoLogo()[0] ?>"
                     alt="<?= $this->options->title ?>">
                <img id="dark-logo" class="navbar-logo d-none" src="<?= Context::EchoLogo()[1] ?>"
                     alt="<?= $this->options->title ?>">
            <?php else: ?>
                <div class="logo-text serif-font">
                    <?= $this->options->title ?>
                </div>
            <?php endif; ?>
        </a>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
             aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <?php if ($this->options->SideAvatar): ?>
                    <img src="<?= $this->options->SideAvatar ?>" alt="avatar" width="32" height="32"
                         class="rounded-circle flex-shrink-0">
                <?php else: ?>
                    <img src="<?= Context::AuthorAvatar(Func::GetAdminEmail()) ?>" alt="avatar" width="32" height="32"
                         class="rounded-circle flex-shrink-0">
                <?php endif; ?>
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?= $this->options->title ?></h5>
                <svg class='icon icon-20' aria-hidden='true' data-bs-dismiss="offcanvas" >
                    <use xlink:href='#x'></use>
                </svg>
            </div>
            <div class="offcanvas-body">
                <?php if ($this->options->Signature): ?>
                    <p class="d-md-none"><?= $this->options->Signature ?></p>
                <?php endif; ?>

                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    <?php if ($this->options->CustomMenu) {
                        $source = array();
                        $source = '[' . $this->options->CustomMenu . ']';
                        $source = json_decode($source, true);
                        foreach ($source as $key) {
                            if (empty($key['children'])) {
                                echo Context::MenuTag($key['url'], $key['name']);
                            } else {
                                echo Context::CustomerDropdownMenuTag($this, $key);
                            }
                        }
                    } else {
                        if ($this->options->LabelOrder == 'P-C') {
                            Context::PageEcho($this, $pages, false);
                            Context::CategoryEcho($this, $category, false);
                        } else {
                            Context::CategoryEcho($this, $category, false);
                            Context::PageEcho($this, $pages, false);
                        }
                    }
                    ?>

                </ul>
            </div>

        </div>
        <ul class="navbar-nav">
            <li class="navbar-icon" data-bs-toggle="modal" data-bs-target="#searchModal">
                <svg class="icon icon-20" aria-hidden="true">
                    <use xlink:href="#search"></use>
                </svg>
            </li>
            <?php if ($this->options->MusicList || $this->options->MusicListUrl): ?>
                <li id="musicApp" class="navbar-icon position-relative d-none d-md-inline-flex">
                    <svg id="musicSvg" class="icon icon-20" aria-hidden="true">
                        <use xlink:href="#music"></use>
                    </svg>
                    <div id="musicPop"></div>
                </li>
            <?php endif; ?>
            <li class="navbar-icon d-none d-md-inline-flex" onclick="Cuteen.DarkModeToggle();" data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                title="昼夜切换">
                <svg class="icon icon-20 darkMode" aria-hidden="true">
                    <use xlink:href="#moon"></use>
                </svg>
            </li>
        </ul>
    </div>
</nav>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" target="_blank">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">搜点什么</h5>
                <svg class='icon icon-20' aria-hidden='true' data-bs-dismiss="modal" >
                    <use xlink:href='#x'></use>
                </svg>
            </div>
            <div class="modal-body">
                <input value="<?php echo $this->is('search') ? $this->archiveTitle(' &raquo; ', '', '') : '' ?>"
                       autocomplete="off" class="form-control" name="s" type="text" placeholder="请输入搜索关键词……"
                       required/>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">点击搜索</button>
            </div>
        </form>
    </div>
</div>
