<?php $currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php"); $active = 'class="active"'; ?>

<header class="navigation">
    <div class="navigation__container">
        <div class="navigation__logo-container">
            <a class="navigation__logo-image" href="/">
                <img src="/assets/img/logo.svg" alt="Vakantie Villa">
            </a>
        </div>
        <button class="navigation__hamburger" aria-label="Toggle menu">
            &#9776;
        </button>
        <nav class="navigation__menu" data-menu>
            <ul class="navigation__list">
                <li class="navigation__item"><a class="navigation__link" <?php if ($currentPage == 'index' || $currentPage == '') echo $active; ?> href="../index.php">Home</a></li>
                <li class="navigation__item"><a class="navigation__link" <?php if ($currentPage == 'villa') echo $active; ?> href="../villa.php">Villas</a></li>
            </ul>
        </nav>
    </div>
</header>