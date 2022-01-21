<header class="header">
    <div class="wrapper wrapper_header">
        <div class="header-row">
            <a href="http://kinoreviews.lr4" class="logo">
                <img src="../Img/logo.png" alt="" class="logo__img">
                <div class="logo__title">KinoReviews</div>
            </a>
            <?php if ($_SESSION['user']['id'] == ""):?>
                <button class="openLoginForm_button" id="openLoginForm">Войти</button>
            <?php else:?>
                <a href="logout.php" class="logout_link" id="logout">Выйти</a>
            <?php endif;?>
        </div>
        <?php if ($_SESSION['user']['id'] != ""):?>
            <div class="header-row">
                <div class="header-welcome">Здравствуйте, <?= $_SESSION['user']['name']?></div>
            </div>
        <?php endif;?>
    </div>
</header>