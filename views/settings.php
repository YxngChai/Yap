<?php

/**
 * @var string $profilePicture
 */

$pageTitle = 'Settings';
$pageScript = 'userSettings.js';
$pageCss = 'userSettings.css';

require_once __DIR__ . '/partials/header.php';
?>

<main class="settings">
    <header>
        <h1 class="settings__title">Settings</h1>
        <hr class="settings__separator"></hr>
    </header>
    <section>
        <form action="/yap/public/" method="POST" enctype="multipart/form-data" class="js-profile-picture-settings-form">
            <label for="picture-form__label" class="user-photo-dialog__title">Change Profile Picture</label>
            <div class="picture-form">
                <input type="hidden" name="action" value="upload_image">
                <input type="hidden" name="image_type" value="profile_image">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                
                <label for="profile-picture-input" class="picture-form__image-container">
                    <img class="picture-form__image" src="<?= $profilePicture ?>">
                    <!-- insert camera device image over the picture -->
                </label>
                <input
                    type="file"
                    name="file"
                    id="profile-picture-input"
                    class="user-photo-dialog__file-input"
                    accept="image/jpeg,image/png,image/webp">
            </div>
            <div class="picture-form__container">
                <span class="picture-form__rules">JPEG/JPG, PNG, and WebP accepted. 5MB max.</span>
                <button type="submit" class="picture-form__save-btn">Save</button>
            </div>
            <div class="picture-form__errors js-picture-form-error-container">
            </div>
        </form>
    </section>
</main>




<?php 
require_once __DIR__ . '/partials/footer.php';
?>