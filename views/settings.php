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
    <section >
        <form action="/yap/public/" method="POST" enctype="multipart/form-data" class="picture-form js-profile-picture-settings-form">
            <h2 class="form__title">Change Profile Picture</h2>
            <div class="picture-form__inputs">
                <input type="hidden" name="action" value="upload_image">
                <input type="hidden" name="image_type" value="profile_image">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                
                <label for="profile-picture-input" class="picture-form__image-container">
                    <img class="picture-form__image" src="<?= $profilePicture ?>">
                    <img class="picture-form__icon" src="/yap/public/assets/images/camera-icon.jpg">
                </label>
                <input
                    type="file"
                    name="file"
                    id="profile-picture-input"
                    class="picture-form__file-input"
                    accept="image/jpeg,image/png,image/webp">
            </div>
            <div class="picture-form__container">
                <span class="picture-form__rules">JPEG/JPG, PNG, and WebP accepted. 5MB max.</span>
                <button type="submit" class="form__save-btn">Save</button>
            </div>
            <div class="form__errors js-picture-form-error-container">
            </div>
        </form>
    </section>
    <hr class="settings__separator"></hr>
    <section>
        <form action="/yap/public/" method="POST" class="updateForm js-personal-details-form"> 
            <h2 class="form__title">Personal Details</h2>
            <label class="form__label">Name</label>
            <input class="form__input" type="text" name="name" minlength="2" maxlength="50" autocomplete="name" value="<?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?>" required>
            <label class="form__label">Surname</label>
            <input class="form__input" type="text" name="surname" minlength="2" maxlength="50" autocomplete="surname" value="<?= htmlspecialchars($_SESSION['user']['surname'] , ENT_QUOTES, 'UTF-8') ?>" required>
            <label class="form__labe">Birth Date</label>
            <input class="form__input" type="date" name="birth_date" max="<?= date('Y-m-d', strtotime('-16 years')) ?>" min="1900-01-01" autocomplete="birthdate"  value="<?= htmlspecialchars($_SESSION['user']['birth_date']) ?>" required >

            <input type="hidden" name="action" value="update_user">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <button type="submit" class="form__save-btn">Save</button>
        </form>
         <div class="js-details-message-container"><p></p>
            </div>
    </section>
    <hr class="settings__separator"></hr>
    <section>
        <form action="/yap/public/" method="POST" class="updateForm js-update-password-form"> 
            <h2 class="form__title">Update Password</h2>
            <label class="form__label">Old password</label>
            <input class="form__input" type="password" name="old_password" minlength="1" maxlength="72" required>
            <label class="form__label">New password</label>
            <input class="form__input" type="password" name="new_password" minlength="1" maxlength="72" autocomplete="password" required>
            <label class="form__labe">New password verification</label>
            <input class="form__input" type="password" name="new_password_verification" minlength="1" maxlength="72" autocomplete="password" required>

            <input type="hidden" name="action" value="update_password">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <button type="submit" class="form__save-btn">Save</button>
        </form>
         <div class="js-update-password-message-container"></div>
    </section>
    <hr class="settings__separator"></hr>
    <section>
        <h2 class="form__title">Delete Account</h2>
        <p class="form__warning">Deleting your account is permanent. Your posts, photos, messages, and other account data will be permanently deleted and cannot be recovered.</p>
        <button type="button" id="deleteAccountModalBtn" class="form__warning-btn">Delete account</button>
        <dialog id="deleteAccountModal" class="deleteAccountModal">
            <form action="/yap/public/" method="POST" class="deleteDialog js-delete-aac" >
                <h3 class="form__title">Delete your account</h3>
                <div class="deleteAccountModal__form">
                    <label class="form__label">Enter your password</label>
                    <input class="form__input form__input--password-check" type="password" name="password" autocomplete="off" required>
                    <div class="deleteDialog__confirmation">
                        <input type="checkbox" class="deleteDialog__comfirmation-checkbox" id="confirmation" name="confirmation" value="y" required>
                        <label for="comfirmation" class="deleteDialog__comfirmation-text">I understand that deleting my account is permanent and that data cannot be recovered</label>
                    </div>
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                    
                    <div class="deleteDialog__btns">
                        <button type="button" id="formCancel" class="form__cancel form__cancel--dialog">Cancel</button>
                        <button type="submit" class="form__warning-btn form__warning-btn--dialog">Delete</button>
                    </div>
                </div>
                <p class="js-delete-error-field form__errors"></p>
            </form>
            
        </dialog>
    </section>
    <hr class="settings__separator"></hr>
</main>




<?php 
require_once __DIR__ . '/partials/footer.php';
?>