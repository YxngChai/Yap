<?php
/** @var array $user */
$pageTitle = 'Yap - User Not Found';
$pageCss = 'profile.css';

?>


<?php require __DIR__ . '/partials/header.php'; ?>

<main class="userNotFound">
    <section class="userNotFound__content">
        <h2 class="userNotFound__oops">Oops!</h2>
        <h1 class="userNotFound__title">Post not Found</h1>
    <p class="userNotFound__text">The page you requested could not be found.</p>
    <a class="userNotFound__link" href="/yap/public/">Home</a>
</section>    
    
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
