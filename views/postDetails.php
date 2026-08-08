<?php

$pageTitle = 'Yap';
$pageScript = 'post.js';
$pageCss = 'post.css';
$commentExpand = true;

require_once __DIR__ . '/header.php';

?>

<main class="post-details__section">
    <?php
        require __DIR__ . '/partials/post.php';
    ?>

</main>

<?php 

    require_once __DIR__ . '/footer.php';

?>
