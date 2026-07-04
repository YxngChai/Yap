<?php
$pageCss = 'feed.css';
?>


<?php require __DIR__ . '/header.php'; ?>


<main>
    <h1 class="feed__title">home</h1>


<section class="feed">
    <section class="post__create">
        <form action="/yap/public/" method="POST" class="post__form" >
            <label class="post__form-title">Create Post</label>
            <textarea class="post__form-textarea" name="post_content" type="textarea" minlength="1" maxlength="1000" placeholder="Write something"></textarea>
            <input type="hidden" name="action" value="create_post">
            <button class="post__form-btn" type="submit">Post</button>
        </form>
    </section>

    <?php if(!empty($posts)): ?>

    <?php foreach($posts as $post): ?>
    <article class="post">
        <header class="post__header">
            <h2 class="post__username"><?= $post["username"] ?></h2>
            <time class="post__time"><?= $post["created_at"] ?></time>
            <button class="post__btn" type="button" aria-label="Delete post">...</button>
        </header>
        <p class="post__content"><?= $post["content"] ?></p>
    </article>
     <?php endforeach; ?>
    <?php endif; ?>

    <h2>Me at the cinema</h2>
    <img src="https://img.pastemagazine.com/wp-content/uploads/2022/06/21005745/baby-yoda-snacks-main.jpg" alt=""><br>
    <h2>Me and my friends</h2>
    <img src="https://cdn.mos.cms.futurecdn.net/s4LPvCUzFQyZWUsTTsdHSP-1200-80.jpg.webp" alt="">
</section>
</main>

<!-- Feed content from pdo request -->
<?php require __DIR__ . '/footer.php'; ?>
