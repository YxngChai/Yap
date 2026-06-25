<?php 
$pageTitle = 'Yap - Login';
$pageScript = '/yap/public/assets/script/auth.js';
$pageCss = 'auth.css';

require __DIR__ . '/header.php'; ?>

<main>
    <!-- <h1>Yap</h1><br> -->
    <section class="auth auth-signin hidden">
        <h2>Sign in</h2>
        <form class="auth-form" method="POST" action="/yap/public/">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="hidden" name="action" value="login">
            <button class="auth__btn" type="submit">Login</button>
        </form>
        <?php if (!empty($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
    </section>
    <section class="auth auth-signout">
        <h2>Sign up</h2>
        <form  class="auth-form" method="POST" action="/yap/public/">
            <label>Name</label>
            <input type="text" name="name">
            <label>Email</label>
            <input type="email" name="email">
            <label>Password</label>
            <input type="password" name="password">
            <label>Verify Password</label>
            <input type="password" name="password_verification">
            <input type="hidden" name="action" value="register">
            <button class="auth__btn" type="submit">Register</button>
        </form>
    </section>
</main>

<?php require __DIR__ . '/footer.php'; ?>
