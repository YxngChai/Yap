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
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
     <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
> -->
    <title><?=  isset($pageTitle)? htmlspecialchars($pageTitle) : 'Yap' ?>
    </title> 
</head>
<body class="body">
<header class="header">
    <nav >
        <ul class="header__items">
            <li>
                <h2 class="header__title">Yap</h2>
            </li>
            <li class="header__profile-section">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="#"><img class="header__profile-picture" src="../public/assets/images/profile_anonymous_mini.jpeg"></img></a>
                    <form method="POST" action="/yap/public/">
                        <input type="hidden" name="action" value="logout">
                        <button class="header__profile-logout-btn" type="submit">Logout</button>
                    </form>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>