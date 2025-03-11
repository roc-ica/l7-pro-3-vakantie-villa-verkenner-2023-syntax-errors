<?php $currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php"); $active = 'class="active"'; ?>
<header>
    <a href="/">
        <img src="/assets/img/logo.svg" alt="Vakantie Villa">
    </a>
    <nav>
        <ul>
            <li><a <?php if ($currentPage == 'index' || $currentPage == '') echo $active; ?> href="index.php">Home</a></li>
            <li><a <?php if ($currentPage == 'villa') echo $active; ?> href="villa.php">Villas</a></li>
            <li><a <?php if ($currentPage == 'contact') echo $active; ?> href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>