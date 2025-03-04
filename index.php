<?php include 'includes/data.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'sections/header.php'; ?>
    <?php include 'sections/banner.php'; ?>
    <main>
        <section id="welcome">
            <h2>Welcome</h2>
            <p>Welcome to our website! Here you can find all the information you need about our holiday villa.</p>
        </section>
        <section id="popular">
            <h2>Popular villas</h2>
            <div class="villas">
                <?php
                $villas = $villa->getVillas();
                foreach ($villas as $villa) {
                    echo '<div class="villa">';
                    echo '<img src="images/' . $villa->image . '" alt="' . $villa->name . '">';
                    echo '<h3>' . $villa->name . '</h3>';
                    echo '<p>' . $villa->desc . '</p>';
                    echo '<a href="villa.php?id=' . $villa->id . '">More information</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </main>
    <?php include 'sections/footer.php'; ?>
</body>
</html>