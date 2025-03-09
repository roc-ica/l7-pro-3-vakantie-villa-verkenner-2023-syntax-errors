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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400..800&display=swap');

        * {
            font-size: 12pt !important;
            font-family: "Baloo Da 2", sans-serif !important;
            font-optical-sizing: auto !important;
            font-weight: 400 !important;
            font-style: normal !important;
        }

        body.pdf {
            font-size: 12pt !important;
            font-family: "Baloo Da 2", sans-serif !important;
            font-optical-sizing: auto !important;
            font-weight: 400 !important;
            font-style: normal !important;

            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 30px;
        }

        .pdf .header {
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .pdf .header img {
            height: 60px;
        }

        .pdf h2 {
            margin: 0;
            padding: 0;
            font-size: 48pt !important;
            font-weight: 700 !important;
            text-align: center;
        }

        .pdf h2.right {
            font-size: 24pt !important;
            text-align: right;
        }

        .pdf .banner {
            display: flex;
            height: 450px;
            justify-content: center;
            align-items: center;
            border: #333 1px solid;
            border-radius: 8px;
        }

        .pdf .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .pdf .content p {
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
    </style>
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