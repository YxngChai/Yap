<?php 
/** @var array $comment */
/** @var string|null $commentRedirect */

require __DIR__ . "/../../src/helpers/icons.php";

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
    <div class="comment__contents">
        <div class="comment__details">
        <a href="/yap/public/user/<?= $comment['username'] ?>">
            <h2 class="comment__username">
                <?= $comment['username'] ?>
            </h2>
        </a>
        <time class="comment__time"><?= $formatedDate ?></time>
        </div>
        <p class="comment__content" id="comment-content-<?= $comment['id'] ?>"><?= $comment['content'] ?></p>
    </div>

    <?php if($comment['user_id'] === $_SESSION['user']['id']):  ?>
        <div class="comment__controls">
            <div class="comment__actions-container">
                <button class="comment__actions comment__btn" style="anchor-name: --actions-<?= $comment['id'] ?>;" popovertarget="comment__actions_<?= $comment['id']?>">...</button>
            </div>
            <div class="comment__like-system">
                <span><?= $comment['like_count'] < 1 ? '' : $comment['like_count']  ?></span>
                <form action="/yap/public/" method="POST" class="js-like-comment-form">
                    <input type="hidden" value="<?= htmlspecialchars($comment['id']) ?>" name="commentId">
                    <input type="hidden" name="action" value="like_comment">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(csrfToken()) ?>">
                    <button class="comment__like" type="submit">
                    <?= $comment["liked"] ? $likedIcon : $likeIcon ?>
                    </button>
                </form>
            </div>
        </div>
        <div id="comment__actions_<?= $comment['id']?>" class="comment__actions-popover"  style="position-anchor: --actions-<?= $comment['id'] ?>;" popover>
                <ul>
                    <li><button type="button" data-dialog="updateCommentDialog-<?= $comment['id'] ?>" class="comment__action comment__action-update">Edit</button></li>
                    <li><button type="button" data-dialog="deleteCommentDialog-<?= $comment['id'] ?>" class="comment__action comment__action-delete">Delete</button></li>

                </ul>
            </div>

            <dialog id="updateCommentDialog-<?= $comment['id']?>" class="dialog__edit">
                <form method="dialog">
                    <button value="cancel" class="dialog__close-btn">X</button>
                </form>
                <form action="/yap/public/" method="POST" class="comment__edit-form js-update-comment-form" >
                    <label class="comment__form-title">Update Comment</label>
                    <textarea class="comment__form-textarea" name="comment_content" type="textarea" minlength="1" maxlength="2000" placeholder="Write something"><?= $comment["content"] ?></textarea>
                    <input type="hidden" name="action" value="update_comment">
                    <input type="hidden" value="<?= htmlspecialchars($comment['id']) ?>" name="commentId">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($commentrRedirect ?? $_SERVER['REQUEST_URI'])  ?>">
                    <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(csrfToken()) ?>">
                    <?php if (!empty($_SESSION['update_errors'])): ?>
                        <div class="errors">
                            <?php foreach ($_SESSION['update_errors'] as $error): ?>
                                <p class="comment__error"><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['update_errors']); ?>
                    <?php endif; ?>
                    <button class="comment__form-btn" type="submit">Save</button>
                </form>
            </dialog>

            <dialog id="deleteCommentDialog-<?= $comment['id'] ?>">
                <p>Are you sure you want to delete this comment?</p>
                <div class="dialog__options">
                <form method="dialog" class="dialog__option dialog__option--cancel">
                    <button value="cancel" class="dialog__action">Cancel</button>
                </form>
                <form action="/yap/public/" method="POST" class="dialog__option dialog__option--delete">
                    <input type="hidden" value="<?= htmlspecialchars($comment['id']) ?>" name="commentId">
                    <input type="hidden" name="action" value="delete_comment">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($commentRedirect ?? $_SERVER['REQUEST_URI']) ?>">
                    <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(csrfToken()) ?>">
                    <button type="submit" value="confirm" class="dialog__action">Delete</button>
                </form>
                </div>
            </dialog>    
    <?php endif; ?>
</div>
