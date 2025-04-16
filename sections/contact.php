<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = htmlspecialchars(trim($_POST['naam']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $villa_id = '0';
    $vraag = htmlspecialchars(trim($_POST['vraag'] ?? ''));

    // Debugging: Log the form data
    error_log("Naam: $naam, Email: $email, Villa ID: $villa_id, Vraag: $vraag");

    if (!empty($naam) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($vraag)) {
        if ($contact->addContact($naam, $email, $villa_id, $vraag)) {
            $message = "<p class='p-3 bg-green-100 text-green-700 rounded'>Bedankt voor je bericht! We nemen snel contact op.</p>";
        } else {
            $message = "<p class='p-3 bg-red-100 text-red-700 rounded'>Er is iets misgegaan. Probeer het opnieuw.</p>";
        }
    } else {
        $message = "<p class='p-3 bg-red-100 text-red-700 rounded'>Vul alle velden correct in!</p>";
    }
}
?>

<section id="contact" class="contact">
    <div class="contact__container">
        <h2>Get in touch</h2>
        <div class="contact__wrapper">
            <?php if (!empty($message)) echo $message; // Display the message 
            ?>
            <form action="bedankt.php" method="post" class="contact__form forms">
                <input type="hidden" name="villa" value="0"> <!-- Hidden input for villa_id -->

                <label class="forms__name" for="name">Naam</label>
                <input class="forms__name-input" type="text" name="naam" id="name" required>

                <label class="forms__email" for="email">E-mail</label>
                <input class="forms__email-input" type="email" name="email" id="email" required>

                <label class="forms__message" for="message">Bericht</label>
                <textarea class="forms__message-input" name="vraag" id="message" rows="5" required></textarea>

                <button class="forms__button" type="submit">Verstuur</button>
            </form>

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