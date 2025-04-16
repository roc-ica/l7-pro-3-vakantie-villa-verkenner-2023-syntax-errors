<?php include 'includes/data.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<?php include 'includes/head.php'; ?>

<body>
    <?php include 'sections/navigation.php'; ?>
    <main id="site-content">
        <section id="contact" class="contact">
            <div class="contact__container">
                <h2>Bedankt voor uw bericht!</h2>
                <p>We hebben uw e-mail goed ontvangen. Ons team bekijkt uw bericht met zorg en u ontvangt zo snel mogelijk een reactie van ons.</p> 
                
                <div class="contact__wrapper">
                    <div class="contact__info">
                        <h3>Onze locatie</h3>
                        <p>Disketteweg 2-4 <br>3821 AR Amersfoort</p>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2437.697235237511!2d5.399142715797876!3d52.153032579743954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c65379f2a1cb37%3A0x6f1b0bb8b6b0ea65!2sDisketteweg%202%2C%203821%20AR%20Amersfoort!5e0!3m2!1snl!2snl!4v1712744069334!5m2!1snl!2snl"
                            width="100%"
                            height="250"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>
        <?php include 'sections/footer.php'; ?>
    </main>

    <!-- Redirect script -->
    <script>
        setTimeout(function() {
            window.location.href = "<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? '/') ?>";
        }, 3000); // Redirect after 3 seconds
    </script>
</body>

</html>