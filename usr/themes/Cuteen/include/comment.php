<?php
// +----------------------------------------------------------------------
// | Author: Veen Zhao <zwying0814@gmail.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2022 https://blog.zwying.com All rights reserved.
// +----------------------------------------------------------------------
// | [ 评论 ]
// +----------------------------------------------------------------------

function threadedComments($comments, $options)
{
    $commentLevelClass = $comments->levels > 0 ? 'comment-child' : 'comment-parent';  //评论层数大于0为子级，否则是父级
    ?>
    <div id="<?php $comments->theId(); ?>" class="<?= $commentLevelClass ?>">
        <div class="d-flex comment-item">
            <img class="avatar flex-shrink-0" src="<?= Context::AuthorAvatar($comments->mail) ?>" alt="头像">
            <div class="flex-grow-1 ms-2 content">
                <div class="text-xs d-flex justify-content-between align-items-center">
                    <div class="left-info">
                        <span class="name"><?= Context::CommentAuthor($comments) ?></span><br class="d-sm-none"/>
                        <span><?= Func::TimeAgoWords($comments->date->timeStamp, time()) ?></span>
                    </div>
                    <span class="comment-reply cp-<?php $comments->theId(); ?> comment-reply-link"><?php $comments->reply('回复'); ?></span>
                    <span id="cancel-comment-reply"
                          class="cancel-comment-reply cl-<?php $comments->theId(); ?> comment-reply-link"
                          style="display:none"><?php $comments->cancelReply('取消'); ?></span>
                </div>
                <div class="comment-text rounded-1">
                    <?= Context::CtxFilter($comments) ?>
                </div>
            </div>
        </div>
        <?php if ($comments->children) : ?>
            <div class="comment-quote">
                <?php $comments->threadedComments($options); ?>
            </div>
        <?php endif ?>
    </div>
<?php }

$this->comments()->to($comments); ?>

<section id="comments" class="card my-4 py-4 px-md-4 px-3">
    <div class="mb-4 d-flex align-items-center px-2 px-md-0">
        <svg class="icon icon-20 me-1" aria-hidden="true">
            <use xlink:href="#pinglun1"></use>
        </svg>
        评论区
    </div>
    <div class="comment-input-warp" id="<?php $this->respondId(); ?>">
        <form class="row g-3" id="comment-form" method="post" data-action="<?php $this->commentUrl() ?>">
            <?php if ($this->user->hasLogin()) : ?>
                <div class="p-2 px-3 font-weight-bold">使用 <?php $this->user->screenName(); ?> 发表评论：</div>
            <?php else : ?>
                <div class="col-md-6 d-inline-flex align-items-center">
                    <img id="comment-author-avatar" width="32" height="32"
                         src="<?= __CUTEEN_STATIC__ . '/img/avatar.svg'; ?>" class="rounded-circle me-2 border border-2"
                         alt="头像">
                    <input id="comment-qq" type="text" class="form-control" placeholder="填写QQ获取邮箱与昵称"
                           aria-label="QQ">
                </div>
                <div class="col-md-6">
                    <input id="author" name="author" type="text" class="form-control" placeholder="昵称"
                           aria-label="昵称" value="<?php $this->remember('author'); ?>" required>
                </div>
                <div class="col-md-6">
                    <input id="mail" name="mail" type="text" class="form-control" placeholder="邮箱" aria-label="邮箱"
                           value="<?php $this->remember('mail'); ?>" <?= $this->options->commentsRequireMail ? 'required' : '' ?>>
                </div>
                <div class="col-md-6">
                    <input id="url" name="url" type="text" class="form-control" placeholder="http(s)://主页"
                           aria-label="主页"
                           value="<?php $this->remember('url'); ?>" <?= $this->options->commentsRequireURL ? 'required' : '' ?>>
                </div>
            <?php endif; ?>
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
    <div id="post-comment-list" class="my-4">
        <?php $comments->listComments(); ?>
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
    </div>

</section>


<script type="text/javascript">
    (function () {
        window.TypechoComment = {
            dom: function (id) {
                return document.getElementById(id)
            },
            pom: function (id) {
                return document.getElementsByClassName(id)[0]
            },
            iom: function (id, dis) {
                var alist = document.getElementsByClassName(id);
                if (alist) {
                    for (var idx = 0; idx < alist.length; idx++) {
                        var mya = alist[idx];
                        mya.style.display = dis
                    }
                }
            },
            create: function (tag, attr) {
                var el = document.createElement(tag);
                for (var key in attr) {
                    el.setAttribute(key, attr[key])
                }
                return el
            },
            reply: function (cid, coid) {
                var comment = this.dom(cid),
                    response = this.dom("<?php echo $this->respondId(); ?>"),
                    input = this.dom("comment-parent"),
                    form = "form" === response.tagName ? response : response.getElementsByTagName("form")[0],
                    textarea = response.getElementsByTagName("textarea")[0];
                if (null == input) {
                    input = this.create("input", {
                        "type": "hidden",
                        "name": "parent",
                        "id": "comment-parent"
                    });
                    form.appendChild(input)
                }
                input.setAttribute("value", coid);
                if (null == this.dom("comment-form-place-holder")) {
                    var holder = this.create("div", {
                        "id": "comment-form-place-holder"
                    });
                    response.parentNode.insertBefore(holder, response)
                }
                comment.children[0].insertAdjacentElement('afterend', response);
                this.iom("comment-reply", "");
                this.pom("cp-" + cid).style.display = "none";
                this.iom("cancel-comment-reply", "none");
                this.pom("cl-" + cid).style.display = "";
                if (null != textarea && "text" === textarea.name) textarea.focus()
                return false
            },
            cancelReply: function () {
                var response = this.dom("<?php echo $this->respondId(); ?>"),
                    holder = this.dom("comment-form-place-holder"),
                    input = this.dom("comment-parent");
                if (null != input) input.parentNode.removeChild(input)
                if (null == holder) return true
                this.iom("comment-reply", "");
                this.iom("cancel-comment-reply", "none");
                holder.parentNode.insertBefore(response, holder);
                return false
            }
        }
    })();

</script>


