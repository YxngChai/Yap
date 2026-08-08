
<form action="/yap/public/" method="POST" class="post__form ">
            <textarea class="post__form-textarea" name="comment_content" type="textarea" minlength="1" maxlength="2000" placeholder="Comment something..."><?=$_SESSION['old_post_content']  ?? ''   ?></textarea>
            <input type="hidden" name="action" value="create_comment">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?? '' ?>">
            <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars(csrfToken()) ?>">
            <?php if (!empty($_SESSION['create_comment_errors'])): ?>
                <div class="errors">
                    <?php foreach ($_SESSION['create_errors'] as $error): ?>
                        <p class="post__error"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['create_comment_errors']); ?>
            <?php endif; ?>
            <button class="post__form-btn" type="submit" disabled>Post</button>
        </form>