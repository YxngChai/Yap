<?php
/** @var array $user 
* @var bool $isOwnProfile 
* @var string $userPicture */

$pageTitle = 'Yap - '. htmlspecialchars((string) $user['username']);
$pageScript = 'post.js';
$pageCss = 'profile.css';
if($isOwnProfile){
    $imagesScript = 'images.js';
}

?>


<?php require __DIR__ . '/partials/header.php'; ?>

<?php 
$likeIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path  d="M442.9 144C415.6 144 389.9 157.1 373.9 179.2L339.5 226.8C335 233 327.8 236.7 320.1 236.7C312.4 236.7 305.2 233 300.7 226.8L266.3 179.2C250.3 157.1 224.6 144 197.3 144C150.3 144 112.2 182.1 112.2 229.1C112.2 279 144.2 327.5 180.3 371.4C221.4 421.4 271.7 465.4 306.2 491.7C309.4 494.1 314.1 495.9 320.2 495.9C326.3 495.9 331 494.1 334.2 491.7C368.7 465.4 419 421.3 460.1 371.4C496.3 327.5 528.2 279 528.2 229.1C528.2 182.1 490.1 144 443.1 144zM335 151.1C360 116.5 400.2 96 442.9 96C516.4 96 576 155.6 576 229.1C576 297.7 533.1 358 496.9 401.9C452.8 455.5 399.6 502 363.1 529.8C350.8 539.2 335.6 543.9 320 543.9C304.4 543.9 289.2 539.2 276.9 529.8C240.4 502 187.2 455.5 143.1 402C106.9 358.1 64 297.7 64 229.1C64 155.6 123.6 96 197.1 96C239.8 96 280 116.5 305 151.1L320 171.8L335 151.1z"/></svg>'; 
$likedIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path class="post__like-icon" d="M305 151.1L320 171.8L335 151.1C360 116.5 400.2 96 442.9 96C516.4 96 576 155.6 576 229.1L576 231.7C576 343.9 436.1 474.2 363.1 529.9C350.7 539.3 335.5 544 320 544C304.5 544 289.2 539.4 276.9 529.9C203.9 474.2 64 343.9 64 231.7L64 229.1C64 155.6 123.6 96 197.1 96C239.8 96 280 116.5 305 151.1z"/></svg>';
$commentIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M267.7 576.9C267.7 576.9 267.7 576.9 267.7 576.9L229.9 603.6C222.6 608.8 213 609.4 205 605.3C197 601.2 192 593 192 584L192 512L160 512C107 512 64 469 64 416L64 192C64 139 107 96 160 96L480 96C533 96 576 139 576 192L576 416C576 469 533 512 480 512L359.6 512L267.7 576.9zM332 472.8C340.1 467.1 349.8 464 359.7 464L480 464C506.5 464 528 442.5 528 416L528 192C528 165.5 506.5 144 480 144L160 144C133.5 144 112 165.5 112 192L112 416C112 442.5 133.5 464 160 464L216 464C226.4 464 235.3 470.6 238.6 479.9C239.5 482.4 240 485.1 240 488L240 537.7C272.7 514.6 303.3 493 331.9 472.8z"/></svg>';
?>

<main>
<div class="profile">
    <section  class="user-header">
        <div class="user-header__images">
            <div class="user-header__wallpaper-container">
                <img class="user-header__wallpaper" src="/yap/public/assets/images/anzellans.jpg">
            </div>
            <div class="user-header__profile-container">
                <img class="user-header__profile" src="<?= $userPicture ?>">
            </div>
        </div>
        <div class="user-header__infos">
            <h1 class="user-header__username"><?= htmlspecialchars((string) $user['username'])?></h1>
            <h2 class="user-header__names"><?= htmlspecialchars((string) $user['name'])?> <?= htmlspecialchars((string) $user['surname'])?></h2>
            <?php if($isOwnProfile): ?>
                <button class="profile__action-btn" popovertarget="profile__actions">...</button>
                <div id="profile__actions" class="profile__actions-popover" popover>
                        <ul>
                            <li><button type="button" data-dialog="updatePicture" class="profile__action">Change profile picture</button></li>
                            <li><button type="button" data-dialog="updateCover" class="profile__action">Change cover image</button></li>
                            <li><a href="/yap/public/settings/" type="button" class="profile__action">Settings</a></li>
                        </ul>
                </div>
                <dialog id="updatePicture" class="user-photo-dialog">
                    <form method="dialog">
                            <button value="cancel" class="dialog__close-btn">X</button>
                        </form>
                            <form action="/yap/public/" method="POST" enctype="multipart/form-data">
                            <label for="profile-picture" class="user-photo-dialog__title">Change Profile Picture</label>
                            <div class="user-photo-dialog__form">
                                <input type="hidden" name="action" value="upload_image">
                                <input type="hidden" name="image_type" value="profile_image">
                                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                                <input
                                    type="file"
                                    name="file"
                                    id="profile-picture-input"
                                    class="user-photo-dialog__file-input"
                                    accept="image/jpeg,image/png,image/webp">
                                <label for="profile-picture-input" class="user-photo-dialog__drop-zone">
                                    <span class="user-photo-dialog__drop-icon">+</span>
                                    <span class="user-photo-dialog__drop-title">Upload a profile picture</span>
                                    <span class="user-photo-dialog__drop-text">Browse, take a picture or drag & drop</span>
                                </label>
                            </div>
                            <div class="user-photo-dialog__container">
                                <span class="user-photo-dialog__rules">JPEG/JPG, PNG, and WebP accepted, 5MB max.</span>
                                <!-- insert error messages here -->
                                <button type="submit" class="user-photo-dialog__save-btn">Save</button>
                            </div>
                        </form>
                    </dialog>
                <?php endif; ?>
        </div>
    </section>

    <section class="feed">
        <?php if($isOwnProfile): ?>
            <?php require_once __DIR__ . '/partials/postForm.php'; ?>
        <?php endif; ?>
        <?php if(!empty($posts)): ?>
            <?php foreach($posts as $post): ?>
                <?php require __DIR__ . '/partials/post.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </section>
</div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>

