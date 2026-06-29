<?php
$pageCss = 'feed.css';
?>


<?php require __DIR__ . '/header.php'; ?>


<main>
    <h1 class="feed__title">home</h1>
<section class="feed">
    <article class="post">
        <header class="post__header">
            <h2 class="post__title">Author name</h2>
            <time class="post__time">date created</time>
            <button class="post__btn" type="button" aria-label="Delete post">...</button>
        </header>
        <p class="post__content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus, quas perspiciatis sit ullam dicta et voluptas sunt repellendus aut molestias soluta. Expedita laborum consectetur nam officia quasi veniam quis nesciunt.</p>
    </article>
    <article class="post">
        <header class="post__header">
            <h2 class="post__title">Author name</h2>
            <time class="post__time">date created</time>
            <button class="post__btn" type="button" aria-label="Delete post">...</button>
        </header>
        <p class="post__content">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus, quas perspiciatis sit ullam dicta et voluptas sunt repellendus aut molestias soluta. Expedita laborum consectetur nam officia quasi veniam quis nesciunt.</p>
    </article>


    <h2>Me at the cinema</h2>
    <img src="https://img.pastemagazine.com/wp-content/uploads/2022/06/21005745/baby-yoda-snacks-main.jpg" alt=""><br>
    <h2>Me and my friends</h2>
    <img src="https://cdn.mos.cms.futurecdn.net/s4LPvCUzFQyZWUsTTsdHSP-1200-80.jpg.webp" alt="">
</section>
</main>

<!-- Feed content from pdo request -->
<?php require __DIR__ . '/footer.php'; ?>
