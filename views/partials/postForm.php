<section class="post__create">
    <form action="/yap/public/" method="POST" class="post__form js-create-post-form js-post-form">
        <?php if ($_SERVER['REQUEST_URI'] == '/yap/public/'): ?>
            <label class="post__form-title">Create Post</label>
        <?php endif; ?>
        <textarea class="post__form-textarea js-post-textarea" name="post_content" type="textarea" minlength="1" maxlength="2000" placeholder="Write something"><?=$_SESSION['old_post_content']  ?? ''   ?></textarea>
        <input type="hidden" name="action" value="create_post">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
        <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars(csrfToken()) ?>">
        <?php if (!empty($_SESSION['create_errors'])): ?>
            <div class="errors">
                <?php foreach ($_SESSION['create_errors'] as $error): ?>
                    <p class="post__error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['create_errors']); ?>
        <?php endif; ?>
        <p class="post__error js-post__error"></p>
        <button class="post__form-btn js-post-btn" type="submit" disabled>Post</button>
    </form>
</section>
