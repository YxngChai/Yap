<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <link rel="stylesheet" href="../public/assets/style/header.css"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/yap/public/assets/style/reset.css">
    <link rel="stylesheet" href="/yap/public/assets/style/header.css">
    <link rel="stylesheet" href="/yap/public/assets/style/footer.css">
    <link rel="stylesheet" href="/yap/public/assets/style/global.css">
    <?php if (isset($pageCss)): ?>
        <link rel="stylesheet" href="/yap/public/assets/style/<?= $pageCss ?>">
    <?php endif; ?>
    <title><?=  isset($pageTitle)? htmlspecialchars($pageTitle) : 'Yap' ?>
    </title> 
</head>
<body class="body">
<header class="header">
    <nav class="header__items">
        <a href="/yap/public/">
            <h1 class="header__title">Yap</h1>
        </a>
        <div class="header__nav">
            <?php if (isset($_SESSION['user'])): ?>

            <?php 
                $currentPage = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
                $profileUrl = '/yap/public/user/' . $_SESSION['user']['username'] ?? null;
            ?>
                <a href="/yap/public/" class="header__nav-container <?= $currentPage === '/yap/public/' ? 'active' : '' ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="header__icon"><path d="M304 70.1C313.1 61.9 326.9 61.9 336 70.1L568 278.1C577.9 286.9 578.7 302.1 569.8 312C560.9 321.9 545.8 322.7 535.9 313.8L527.9 306.6L527.9 511.9C527.9 547.2 499.2 575.9 463.9 575.9L175.9 575.9C140.6 575.9 111.9 547.2 111.9 511.9L111.9 306.6L103.9 313.8C94 322.6 78.9 321.8 70 312C61.1 302.2 62 287 71.8 278.1L304 70.1zM320 120.2L160 263.7L160 512C160 520.8 167.2 528 176 528L224 528L224 424C224 384.2 256.2 352 296 352L344 352C383.8 352 416 384.2 416 424L416 528L464 528C472.8 528 480 520.8 480 512L480 263.7L320 120.3zM272 528L368 528L368 424C368 410.7 357.3 400 344 400L296 400C282.7 400 272 410.7 272 424L272 528z"/></svg></a>
                <a href="<?= htmlspecialchars($profileUrl)?>" class="header__nav-container <?= $currentPage === $profileUrl ? 'active' : '' ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="header__icon"><path d="M240 192C240 147.8 275.8 112 320 112C364.2 112 400 147.8 400 192C400 236.2 364.2 272 320 272C275.8 272 240 236.2 240 192zM448 192C448 121.3 390.7 64 320 64C249.3 64 192 121.3 192 192C192 262.7 249.3 320 320 320C390.7 320 448 262.7 448 192zM144 544C144 473.3 201.3 416 272 416L368 416C438.7 416 496 473.3 496 544L496 552C496 565.3 506.7 576 520 576C533.3 576 544 565.3 544 552L544 544C544 446.8 465.2 368 368 368L272 368C174.8 368 96 446.8 96 544L96 552C96 565.3 106.7 576 120 576C133.3 576 144 565.3 144 552L144 544z"/></svg></a>
                <div class="header__profile-picture-container">
                    <button popovertarget="profile-menu" class="profile-btn">
                        <img class="header__profile-picture" src="/yap/public/assets/images/babyyoda-profile.jpg">
                        <div class="header__profile-expand"><span class="header__profile-expand-btn">v</span></div>
                    </button>
                   
                    <div id="profile-menu" class="header__popover" popover>
                        <nav>
                            <ul class="popover__ul">
                                <li class="popover__li "><a href="/yap/public/user/<?= htmlspecialchars((string) $_SESSION['user']['username'])?>"><h3 class="popover__item popover__username"><?=$_SESSION['user']['username'] ?></h3></a></li>
                                <li class="popover__li"><h3 class="popover__item">Settings</h3></li>
                                <li class="popover__li"><form method="POST" action="/yap/public/" class="popover__item">
                                    <input type="hidden" name="action" value="logout">
                                    <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= htmlspecialchars(csrfToken()) ?>">
                                    <button  type="submit">Logout</button>
                                </form></li>
                            </ul>
                        <nav>
                    </div>
                </div>
            <?php else: ?>
                <div class="header__auth-section">
                    <button class="header__auth-btn header__auth-btn--in">Sign in</button>
                    <button class="header__auth-btn header__auth-btn--up">Sign up</button>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>