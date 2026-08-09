<?php /** @var array $comment */ ?>

<div class="comment">
    <div class="comment__photo-container">
        <img class="comment__photo" src="" alt="">
    </div>
    <div class="comment__content">
        <div class="comment__details">
        <h2 class="comment__username">
            <?= $comment['username'] ?>
        </h2><span class="time"><?= $comment['created_at'] ?></span>
        </div>
        <p class="comment__content"><?= $comment['content'] ?></p>
    </div>
    <button class="post__actions" style="anchor-name: --actions-<?= $comment['id'] ?>;" popovertarget="post__actions_<?= $comment['id']?>">...</button>
</div>
