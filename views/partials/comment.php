<?php /** @var array $comment */ ?>

<?php 

$date = new DateTime($comment['created_at']);
$now = new DateTime();

$diff = $now->diff($date);

if ($diff ->days > 0) {
    $formatedDate = $diff-> days . ' day' . ($diff->days > 1 ? 's' : '') . ' ago';        
} elseif ($diff->h > 0) {
    $formatedDate = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
} else {
    $formatedDate = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
}

?>

<div class="comment">
    <div class="comment__photo-container">
        <a href="/yap/public/user/<?= $comment['username'] ?>">
            <img class="comment__photo" src="/yap/public/assets/images/profile_anonymous_mini.jpeg" alt="">
        </a>
    </div>
    <div class="comment__content">
        <div class="comment__details">
        <a href="/yap/public/user/<?= $comment['username'] ?>">
            <h2 class="comment__username">
                <?= $comment['username'] ?>
            </h2>
        </a>
        <time class="comment__time"><?= $formatedDate ?></time>
        </div>
        <p class="comment__content"><?= $comment['content'] ?></p>
    </div>

    <?php if($comment['user_id'] === $_SESSION['user']['id']):  ?>
        <div class="post__actions-container">
            <button class="post__actions" style="anchor-name: --actions-<?= $comment['id'] ?>;" popovertarget="post__actions_<?= $comment['id']?>">...</button>
        </div>
    <?php endif; ?>
</div>
