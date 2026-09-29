<?php
/** @var array $user */
$pageTitle = 'Yap - User Not Found';
$pageCss = 'profile.css';

?>


<?php require __DIR__ . '/partials/header.php'; ?>

<main class="pageNotFound">
    <section class="pageNotFound__content">
        <h2 class="pageNotFound__oops">Oops!</h2>
        <h1 class="pageNotFound__title">Page not Found</h1>
    <p class="pageNotFound__text">The page you requested could not be found.</p>
    <a class="pageNotFound__link" href="/yap/public/">Home</a>
</section>    
    
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
