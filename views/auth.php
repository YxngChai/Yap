<?php 
$pageTitle = 'Yap - Login';
$pageScript = '/yap/public/assets/script/auth.js';

require __DIR__ . '/header.php'; ?>

<main>
    <!-- <h1>Yap</h1><br> -->
    <section>
        <h2>Login</h2>
        <form method="POST" action="/yap/public/">
            <label>Email</label>
            <input type="email" name="email" required><br>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="hidden" name="action" value="login">
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
    </section>
    <!-- <section>
        <h2>Register</h2>
        <form method="POST" action="/yap/public/">
            <label>Name</label>
            <input type="text" name="name">
            <label>Email</label>
            <input type="email" name="email">
            <label>Password</label>
            <input type="password" name="password">
            <label>Verify Password</label>
            <input type="password" name="password_verification">
            <input type="hidden" name="action" value="register">
            <button type="submit">Register</button>
        </form>
    </section> -->
</main>

<?php require __DIR__ . '/footer.php'; ?>
