<?php
/**
 * @var array{
 *     id:int,
 *     username:string,
 *     content:string,
 *     created_at:string,
 *     like_count:int,
 *     liked:bool,
 *     
 * } $post
 * @var array<int, array> $comments
 * @var string $postRedirect
 */

require __DIR__ . "/../../src/helpers/icons.php";

$date = new DateTime($post["created_at"]);
$now = new DateTime();

$diff = $now->diff($date);

$formatedDate = $date->format('M j \a\t H:i');
if ($diff ->days > 0) {
    $formatedDate = $date->format('M j \a\t H:i');       
} elseif ($diff->h > 0) {
    $formatedDate = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
} elseif ($diff->i > 0) {
    $formatedDate = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
} else {
    $formatedDate = "just now";
}

?>

<article class="post">
        <header class="post__header">
            <img src="<?= $post['profile_picture'] ?  '/yap/public/assets/uploads/'. $post['profile_picture'] : '/yap/public/assets/images/profile_anonymous_mini.jpeg' ?>" alt="Profile picture" class="post__profile-picture">
            <div>
            <a href="/yap/public/user/<?= htmlspecialchars((string) $post["username"]) ?>"><h2 class="post__username"><?= $post["username"] ?></h2></a><br>
            <a href="/yap/public/p/<?= htmlspecialchars((string) $post['id']) ?>"><time class="post__time"><?= $formatedDate ?></time></a>
            </div>
            <?php if (isset($_SESSION['user']) && $post['username'] === $_SESSION['user']['username']): ?>
                <button class="post__btn" style="anchor-name: --actions-<?= $post['id'] ?>;" popovertarget="post__actions_<?= $post['id']?>">...</button>
                <div id="post__actions_<?= $post['id']?>" class="post__actions-popover"  style="position-anchor: --actions-<?= $post['id'] ?>;" popover>
                    <ul>
                        <li><button type="button" data-dialog="updateDialog-<?= $post['id'] ?>" class="post__action post__action-update">Edit</button></li>
                        <li><button type="button" data-dialog="deleteDialog-<?= $post['id'] ?>" class="post__action post__action-delete">Delete</button></li>

                    </ul>
                </div>

                <dialog id="updateDialog-<?= $post['id']?>" class="dialog__edit">
                    <form method="dialog">
                        <button value="cancel" class="dialog__close-btn">X</button>
                    </form>
                    <form action="/yap/public/" method="POST" class="post__form js-update-post-form js-post-form" >
                        <label class="post__form-title">Update Post</label>
                        <textarea class="post__form-textarea js-post-textarea" name="post_content" type="textarea" minlength="1" maxlength="2000" placeholder="Write something"><?= $post["content"] ?></textarea>
                        <input type="hidden" name="action" value="update_post">
                        <input type="hidden" value="<?= htmlspecialchars($post['id']) ?>" name="postId">
                        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                        <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars(csrfToken()) ?>">
                        <p class="post__error js-edit-post-error"></p>
                        <button class="post__form-btn js-post-btn" type="submit">Save</button>
                    </form>
                </dialog>

                <dialog id="deleteDialog-<?= $post['id'] ?>">
                    <p>Are you sure you want to delete this post?</p>
                    <div class="dialog__options">
                    <form method="dialog" class="dialog__option dialog__option--cancel">
                        <button value="cancel" class="dialog__action">Cancel</button>
                    </form>
                    <form action="/yap/public/" method="POST" class="dialog__option dialog__option--delete">
                        <input type="hidden" value="<?= htmlspecialchars($post['id']) ?>" name="postId">
                        <input type="hidden" name="action" value="delete_post">
                        <input type="hidden" name="redirect" value="<?=  str_starts_with($_SERVER['REQUEST_URI'], '/yap/public/p/') ? '/yap/public/' : htmlspecialchars($postRedirect) ?>">
                        <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars(csrfToken()) ?>">
                        <button type="submit" value="confirm" class="dialog__action">Delete</button>
                    </form>
                    </div>
                </dialog>
            <?php endif; ?>
        </header>
        <p class="post__content" id="post-content-<?= $post['id'] ?>" ><?= $post["content"] ?></p>
        <footer class="post__footer">
            <form action="/yap/public/" method="POST" class="js-like-post-form">
                <input type="hidden" value="<?= htmlspecialchars($post['id']) ?>" name="postId">
                <input type="hidden" name="action" value="like_post">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(csrfToken()) ?>">
                <button class="post__like" type="submit">
                <?= $post["liked"] ? $likedIcon : $likeIcon ?>
                </button>
            </form>
            <span><?= $post['like_count']  ?></span>
            <button class="post__comment">
                <a href="/yap/public/p/<?= htmlspecialchars((string) $post['id']) ?>"><?= $commentIcon ?></a>
            </button>
            <span><?= $post['comment_count'] > 0 ? $post['comment_count'] : '' ?></span>
        </footer>
        <?php if ($commentExpand):?>
            <?php foreach($comments as $comment): ?>
                <?php require __DIR__ . '/comment.php'; ?>
            <?php endforeach; ?>
            <?php require __DIR__ . "/commentForm.php"; ?>
        <?php endif; ?>
    </article>