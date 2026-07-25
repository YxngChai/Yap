<?php
/** @var array $user */
/** @var bool $isOwnProfile */

$pageTitle = 'Yap - '. htmlspecialchars((string) $user['username']);
$pageScript = 'post.js';
$pageCss = 'profile.css';

?>


<?php require __DIR__ . '/header.php'; ?>

<?php 
$likeIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path class="post__like-icon" d="M442.9 144C415.6 144 389.9 157.1 373.9 179.2L339.5 226.8C335 233 327.8 236.7 320.1 236.7C312.4 236.7 305.2 233 300.7 226.8L266.3 179.2C250.3 157.1 224.6 144 197.3 144C150.3 144 112.2 182.1 112.2 229.1C112.2 279 144.2 327.5 180.3 371.4C221.4 421.4 271.7 465.4 306.2 491.7C309.4 494.1 314.1 495.9 320.2 495.9C326.3 495.9 331 494.1 334.2 491.7C368.7 465.4 419 421.3 460.1 371.4C496.3 327.5 528.2 279 528.2 229.1C528.2 182.1 490.1 144 443.1 144zM335 151.1C360 116.5 400.2 96 442.9 96C516.4 96 576 155.6 576 229.1C576 297.7 533.1 358 496.9 401.9C452.8 455.5 399.6 502 363.1 529.8C350.8 539.2 335.6 543.9 320 543.9C304.4 543.9 289.2 539.2 276.9 529.8C240.4 502 187.2 455.5 143.1 402C106.9 358.1 64 297.7 64 229.1C64 155.6 123.6 96 197.1 96C239.8 96 280 116.5 305 151.1L320 171.8L335 151.1z"/></svg>'; 
$commentIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path class="post__comment-icon" d="M267.7 576.9C267.7 576.9 267.7 576.9 267.7 576.9L229.9 603.6C222.6 608.8 213 609.4 205 605.3C197 601.2 192 593 192 584L192 512L160 512C107 512 64 469 64 416L64 192C64 139 107 96 160 96L480 96C533 96 576 139 576 192L576 416C576 469 533 512 480 512L359.6 512L267.7 576.9zM332 472.8C340.1 467.1 349.8 464 359.7 464L480 464C506.5 464 528 442.5 528 416L528 192C528 165.5 506.5 144 480 144L160 144C133.5 144 112 165.5 112 192L112 416C112 442.5 133.5 464 160 464L216 464C226.4 464 235.3 470.6 238.6 479.9C239.5 482.4 240 485.1 240 488L240 537.7C272.7 514.6 303.3 493 331.9 472.8z"/></svg>';
?>

<main>
<div class="profile">
    <section  class="user-header">
        <div class="user-header__images">
            <div class="user-header__wallpaper-container">
                <img class="user-header__wallpaper" src="/yap/public/assets/images/anzellans.jpg">
            </div>
            <div class="user-header__profile-container">
                <img class="user-header__profile" src="/yap/public/assets/images/babyyoda-profile.jpg">
            </div>
        </div>
        <div class="user-header__infos">
            <h1 class="user-header__username"><?= htmlspecialchars((string) $user['username'])?></h1>
            <h2 class="user-header__names"><?= htmlspecialchars((string) $user['name'])?> <?= htmlspecialchars((string) $user['surname'])?></h2>
        </div>
    </section>
    <section class="feed">
        <?php if($isOwnProfile): ?>
        <section class="post__create">
            <form action="/yap/public/" method="POST" class="post__form" >
                <textarea class="post__form-textarea" name="post_content" type="textarea" minlength="1" maxlength="2000" placeholder="Write something"><?=$_SESSION['old_post_content']  ?? ''   ?></textarea>
                <input type="hidden" name="action" value="create_post">
                <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(csrfToken()) ?>">
                <?php if (!empty($_SESSION['errors'])): ?>
                    <div class="errors">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p class="post__error"><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>
                <button class="post__form-btn" type="submit" disabled>Post</button>
            </form>
        </section>
        <?php endif; ?>
        <?php if(!empty($posts)): ?>

        <?php foreach($posts as $post): ?>
        <article class="post">
            <header class="post__header">
            <a href="/yap/public/user/<?= htmlspecialchars((string) $post["username"]) ?>"><h2 class="post__username"><?= $post["username"] ?></h2></a><br>
            <time class="post__time"><?= $post["created_at"] ?></time>
             <?php if (isset($_SESSION['user']) && $post['username'] === $_SESSION['user']['username']): ?>
                <button class="post__btn" style="anchor-name: --actions-<?= $post['id'] ?>;" popovertarget="post__actions_<?= $post['id']?>">...</button>
                <div id="post__actions_<?= $post['id']?>" class="post__actions-popover"  style="position-anchor: --actions-<?= $post['id'] ?>;" popover>
                    <ul>
                        <li><button data-dialog="updateDialog-<?= $post['id'] ?>" class="post__action post__action-update">Edit</button></li>
                        <li><button data-dialog="deleteDialog-<?= $post['id'] ?>" class="post__action post__action-delete">Delete</button></li>

                    </ul>
                </div>
                                <dialog id="updateDialog-<?= $post['id']?>">
                    <form method="dialog">
                        <button value="cancel">X</button>
                    </form>
                    <form action="/yap/public/" method="POST" class="post__form" >
                        <label class="post__form-title">Update Post</label>
                        <textarea class="post__form-textarea" name="post_content" type="textarea" minlength="1" maxlength="2000" placeholder="Write something"><?= $post["content"] ?></textarea>
                        <input type="hidden" name="action" value="update_post">
                        <input type="hidden" value="<?= htmlspecialchars($post['id']) ?>" name="postId">
                        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                        <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars(csrfToken()) ?>">
                        <?php if (!empty($_SESSION['errors'])): ?>
                            <div class="errors">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <p class="post__error"><?= htmlspecialchars($error) ?></p>
                                <?php endforeach; ?>
                            </div>
                            <?php unset($_SESSION['errors']); ?>
                        <?php endif; ?>
                        <button class="post__form-btn" type="submit">Post</button>
                    </form>
                </dialog>

                <dialog id="deleteDialog-<?= $post['id'] ?>">
                    <p>Are you sure you want to delete this post?</p>
                    <form method="dialog">
                        <button value="cancel">Cancel</button>
                    </form>
                    <form action="/yap/public/" method="POST">
                        <input type="hidden" value="<?= htmlspecialchars($post['id']) ?>" name="postId">
                        <input type="hidden" name="action" value="delete_post">
                                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                        <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars(csrfToken()) ?>">
                        <button type="submit" value="confirm">Delete</button>
                    </form>
                </dialog>
            <?php endif; ?>
        </header>
        <p class="post__content"><?= $post["content"] ?></p>
        <footer class="post__footer">
            <button class="post__like">
                <?= $likeIcon ?>
            </button><span>12</span>
            <button class="post__comment">
                <?= $commentIcon ?>
            </button><span>3</span>
            </footer>
        </article>
        <?php endforeach; ?>
        <?php endif; ?>

    </section>
</div>
</main>

<?php require __DIR__ . '/footer.php'; ?>

