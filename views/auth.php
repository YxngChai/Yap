<?php 
$pageTitle = 'Yap - Login';
$pageScript = '/yap/public/assets/script/auth.js';
$pageCss = 'auth.css';

require __DIR__ . '/header.php'; ?>

<main class="main">
    <!-- <h1>Yap</h1><br> -->
    <section class="auth auth-signin <?= ($form ?? 'signin') === 'signup' ? 'hidden' : '' ?>">
        <h2>Sign in</h2>
        <form class="auth-form" method="POST" action="/yap/public/">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="hidden" name="action" value="signin">
            <input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars(csrfToken()) ?>"
>
            <button class="auth__btn" type="submit">Login</button>
        </form>
        <?php if (!empty($signInError)): ?>
    <p class="auth__error"><?= htmlspecialchars($signInError) ?></p>
<?php endif; ?>
    </section>
    <section class="auth auth-signout <?= ($form ?? 'signin') === 'signup' ? '' : 'hidden' ?>">
        <h2>Sign up</h2>
        <form  class="auth-form" method="POST" action="/yap/public/">
            <label>Username</label>
            <input type="text" name="username" minlength="4" maxlength="50"  value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
            <label>Name</label>
            <input type="text" name="name"  minlength="2" maxlength="50" autocomplete="name"  value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
            <label>Surname</label>
            <input type="text" name="surname" minlength="2" maxlength="100"  autocomplete="surname"  value="<?= htmlspecialchars($old['surname'] ?? '') ?>" required>
            <label>Birth date</label>
            <input type="date" name="birth_date" max="<?= date('Y-m-d', strtotime('-16 years')) ?>" min="1900-01-01" autocomplete="birthdate"  value="<?= htmlspecialchars($old['birth_date'] ?? '') ?>" required >
            <label>Email</label>
            <input type="email" name="email"  maxlength="100" autocomplete="email"  value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
            <label class="auth__password">Password <span class="help-icon" title="Must be at least 8 characters">?</span></label>
            <input type="password" name="password" minlength="8" maxlength="72"  autocomplete="password" required>
            <label>Verify Password</label>
            <input type="password" name="password_verification" minlength="8" maxlength="72"  autocomplete="password" required>
            <input type="hidden" name="action" value="signup">
            <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars(csrfToken()) ?>">
            <button class="auth__btn" type="submit">Register</button>
        </form>
                <?php if (!empty($signUpError)): ?>
    <p class="auth__error"><?= htmlspecialchars($signUpError) ?></p>
<?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/footer.php'; ?>
