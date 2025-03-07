<?php include './data.php'; ?>
<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $villa = $villa->getVilla($id);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= $villa->name; ?></title>
    <link rel="stylesheet" href="/assets/css/pdf.css">
</head>

<body class="pdf">
    <div class="header">
        <img src="/assets/img/logo.svg" alt="Vakantie Villa">
    </div>
    <br>
    <h2><?php echo $villa->name; ?></h2>
    <section class="banner">
        <img src="/assets/img/villa/<?= $villa->image; ?>" alt="<?= $villa->name; ?>">
    </section>
    <h2 class="right">€ <?= $villa->price; ?></h2>
    <main class="content">
        <p><?= $villa->desc; ?></p>
    </main>
</body>

</html>