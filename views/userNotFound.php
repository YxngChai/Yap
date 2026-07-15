<?php
$pageCss = 'profile.css';
/** @var array $user */
?>


<?php require __DIR__ . '/header.php'; ?>

<main class="userNotFound">
    <section class="userNotFound__content">
        <h2 class="userNotFound__oops">Oops!</h2>
        <h1 class="userNotFound__title">User not Found</h1>
    <p class="userNotFound__text">The page you requested could not be found.</p>
    <a class="userNotFound__link" href="/yap/public/">Home</a>
</section>    
    
</main>

<?php require __DIR__ . '/footer.php'; ?>
