<?php
/**
 *
 * 永恒的星辰旋转于时间的终点，极光与银河凝滞在神明的山巅
 *
 * @package Cuteen
 * @author Veen Zhao
 * @version 5.6
 * @link https://blog.zwying.com/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('include/header.php');
?>
<div class="row justify-content-center <?= ($this->options->SidebarRorL == 'R-L') ? 'flex-row-reverse' : '' ?>">
    <?php Context::SidebarEcho($this) ?>
    <section class="mt-4 col-lg-9">
        <?php if ($this->options->TopPost): ?>
            <?php $this->need('include/top.php'); ?>
        <?php endif; ?>
        <div id="article-list">
            <?php while ($this->next()): ?>
                <?= Context::IndexList($this) ?>
            <?php endwhile; ?>
        </div>
        <?php $this->need('include/pagination.php'); ?>
    </section>
</div>
<?php $this->need('include/footer.php'); ?>

