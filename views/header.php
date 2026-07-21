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
    <nav >
        <ul class="header__items">
            <li><a href="/yap/public/">
                    <h2 class="header__title">Yap</h2>
                </a>
            </li>
            <li >
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="header__profile-section">
                        <button popovertarget="profile-menu" class="profile-btn">
                            <img class="header__profile-picture" src="/yap/public/assets/images/babyyoda-profile.jpg">
                        </button>
                        <div id="profile-menu" class="header__popover" popover>
                            <nav>
                                <ul class="popover__ul">
                                    <li class="popover_li "><a href="/yap/public/user/<?= htmlspecialchars((string) $_SESSION['user']['username'])?>"><h3 class="popover__item popover__username"><?=$_SESSION['user']['username'] ?></h3></a></li>
                                    <li class="popover_li"><h3 class="popover__item">Settings</h3></li>
                                    <li class="popover_li"><form method="POST" action="/yap/public/">
                                        <input type="hidden" name="action" value="logout">
                                        <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars(csrfToken()) ?>">
                                        <button class="popover__item" type="submit">Logout</button>
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
            </li>
        </ul>
    </nav>
</header>