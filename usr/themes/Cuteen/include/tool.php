<?php
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | File Create Time: 2022/9/18 [ 一些设置 ]
// +----------------------------------------------------------------------
?>
    <div id="tool" class="d-grid gap-1">
        <?php if (($this->is('post') || $this->is('page')) && $this->fields->catalog) : ?>
            <div id="tocbot-btn" class="right-btn-icon p-2 position-relative" data-bs-toggle="offcanvas"
                 data-bs-target="#tocbot-box"
                 aria-controls="tocbot-box">
                <svg class="icon icon-20" aria-hidden="true">
                    <use xlink:href="#list"></use>
                </svg>
            </div>
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="tocbot-box"
                 aria-labelledby="tocbot-box-lable">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title serif-font" id="tocbot-box-lable">文章目录</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" id="toc-box">

                </div>
            </div>
            <script src="<?= __CUTEEN_STATIC__ . '/js/progress-catalog.js'; ?>"></script>
            <script>
                if (document.getElementById('tocbot-btn')) {
                    document.addEventListener('DOMContentLoaded', () => {
                        TOC({
                            contentEl: "post",
                            catalogEl: "toc-box"
                        })
                    });
                    document.addEventListener('pjax:complete', () => {
                        TOC({
                            contentEl: "post",
                            catalogEl: "toc-box"
                        })
                    })
                }
            </script>
        <?php endif; ?>
        <div onclick="Cuteen.DarkModeToggle();" class="right-btn-icon p-2 d-block d-sm-none">
            <svg class="icon icon-20 darkMode" aria-hidden="true">
                <use xlink:href="#moon"></use>
            </svg>
        </div>
        <div class="right-btn-icon p-2" onclick="window.scroll({top: 0, left: 0, behavior: 'smooth'});">
            <svg class="icon icon-20" aria-hidden="true">
                <use xlink:href="#arrow-up-circle"></use>
            </svg>
        </div>
    </div>
    <!--Headroom-->
<?php if ($this->options->Headroom) : ?>
    <script src="<?= __CUTEEN_STATIC__ . '/js/headroom.min.js'; ?>"></script>
    <script>
        function headroom_fun() {
            const element = document.getElementById("navPC");
            const headroom = new Headroom(element, {
                offset: 150,
            });
            headroom.init();
        }

        headroom_fun();
    </script>
<?php endif; ?>
    <!--MathJax-->
<?php if ($this->options->MathJax) : ?>
    <script async id="MathJax-script" src="<?= __CUTEEN_STATIC__ . '/js/mathjax/tex-chtml.js'; ?>"></script>
    <script>
        MathJax = {
            options: {renderActions: {addMenu: [0, "", ""]}},
            tex: {inlineMath: [["$", "$"], ["\\(", "\\)"]]},
            svg: {fontCache: "global"}
        }
    </script>
<?php endif; ?>

<?php if ($this->options->Pjax) : ?>
    <script src="<?= __CUTEEN_STATIC__ . '/js/pjax.min.js'; ?>"></script>
    <script src="<?= __CUTEEN_STATIC__ . '/js/topbar.min.js'; ?>"></script>
    <script>
        const pjax = new Pjax({
            selectors: [
                'main', 'title', '#LocalizeScript', '#tool', '#hero-box'
            ],
        });
        document.addEventListener('pjax:send', () => {
            NProgress.set(0.6);
        });
        document.addEventListener('pjax:complete', () => {
            NProgress.done();
            if (document.getElementById('echarts_pie')) EchartsInit();
            refreshFsLightbox();
            <?php if ($this->options->MathJax) : ?>
            MathJax.typeset();
            <?php endif; ?>
            <?php if ($this->options->Headroom) : ?>
            headroom_fun();
            <?php endif; ?>
            if (typeof Prism !== 'undefined') Prism.highlightAll(true, null);
            Cuteen.PjaxLoad()
            <?php if ($this->options->PjaxCallback) : $this->options->PjaxCallback(); ?><?php endif; ?>
        });
    </script>
<?php endif; ?>
<?php if ($this->options->MusicList || $this->options->MusicListUrl) : ?>
    <script src="<?= __CUTEEN_STATIC__ . '/js/player.js'; ?>"></script>
    <?php if ($this->options->MusicListUrl && !$this->options->MusicList): ?>
        <script>
            const player = new Player({
                autoplay: false, listshow: false, mode: 'listloop',
                music: {type: 'cloud', source: CuteenConfig.music_id, media: CuteenConfig.music_media,}
            });
        </script>
    <?php elseif ($this->options->MusicList): ?>
        <script>
            const player = new Player({
                autoplay: false, listshow: false, mode: 'listloop',
                music: {type: 'file', source: <?php echo '[' . $this->options->MusicList . ']' ?>}
            });
        </script>
    <?php endif; ?>

<?php endif; ?>
    <script src="<?= __CUTEEN_STATIC__ . '/js/message.js'; ?>"></script>
    <script src="<?= __CUTEEN_STATIC__ . '/js/OwO.js'; ?>"></script>
    <script src="<?= __CUTEEN_STATIC__ . '/js/lazyload.min.js'; ?>"></script>
    <script src="<?= __CUTEEN_STATIC__ . '/js/fslightbox.js'; ?>"></script>
    <script src="<?= $this->options->themeUrl . '/include/prism.js'; ?>"></script>
    <script src="<?= __CUTEEN_STATIC__ . '/js/main.js'; ?>"></script>
    <script src="<?= __CUTEEN_STATIC__ . '/js/bootstrap.bundle.min.js'; ?>"></script>
<?php if ($this->options->Smooth) : ?>
    <script src="<?= __CUTEEN_STATIC__ . '/js/smooth.min.js'; ?>"></script>
<?php endif; ?>
<?php if ($this->options->CustomFooter) : $this->options->CustomFooter(); ?><?php endif; ?>
<?php if ($this->options->Eruda) : ?>
    <script src="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/eruda/2.4.1/eruda.min.js"
            type="application/javascript"></script>
    <script>eruda.init();</script>
<?php endif; ?>