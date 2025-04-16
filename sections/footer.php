<?php $currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php"); $active = 'class="active"'; ?>
<footer class="footer">
    <div class="footer__container">
        <div class="footer__logo-container">
            <a class="footer__logo-image" href="/">
                <img src="/assets/img/logo.svg" alt="Vakantie Villa">
            </a>
        </div>

        <div class="footer__contact-info contacts">
            <ul class="contacts__list">
                <li class="contacts__item">Telefoon: <a href="tel:+123456789">+123456789</a></li>
                <li class="contacts__item">Email: <a href="mailto:info@example.com">info@example.com</a></li>
            </ul>
        </div>
    </div>





    <!-- jQuery (vereist door Owl Carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="/assets/js/script.js"></script>
</footer>

