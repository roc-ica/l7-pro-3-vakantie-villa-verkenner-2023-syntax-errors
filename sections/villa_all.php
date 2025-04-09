<?php include_once 'includes/data.php'; ?>

<?php if (!isset($_GET['id'])): ?>
    <?php $villas = $villa->getVillas(); ?>
    <?php
    $filters = [
        'name' => $_GET['name'] ?? null,
        'min_price' => $_GET['min_price'] ?? null,
        'max_price' => $_GET['max_price'] ?? null,
        'liggingsoptie' => isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) ? $_GET['liggingsoptie'] : [],
        'eigenschap' => isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) ? $_GET['eigenschap'] : [],
    ];

    $villas = $villa->getVillas($filters);
    ?>
    <section class="all-villas">
        <form method="GET" action="villa.php" style="margin-bottom: 20px;">
            <input type="text" name="name" placeholder="Zoek op naam"
                value="<?= htmlspecialchars($_GET['name'] ?? '') ?>" style="margin-right: 10px;">
            <input type="number" name="min_price" placeholder="Min. prijs"
                value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" style="margin-right: 10px;">
            <input type="number" name="max_price" placeholder="Max. prijs"
                value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" style="margin-right: 10px;">

            <fieldset style="margin-bottom: 10px;">
                <legend>Ligging</legend>
                <label><input type="checkbox" name="liggingsoptie[]" value="1" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(1, $_GET['liggingsoptie'])) ? 'checked' : '' ?>> Dicht bij een bos</label><br>
                <label><input type="checkbox" name="liggingsoptie[]" value="2" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(2, $_GET['liggingsoptie'])) ? 'checked' : '' ?>> Dicht bij een stad</label><br>
                <label><input type="checkbox" name="liggingsoptie[]" value="3" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(3, $_GET['liggingsoptie'])) ? 'checked' : '' ?>> Dicht bij de zee</label><br>
                <label><input type="checkbox" name="liggingsoptie[]" value="4" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(4, $_GET['liggingsoptie'])) ? 'checked' : '' ?>> In het heuvelland</label><br>
                <label><input type="checkbox" name="liggingsoptie[]" value="5" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(5, $_GET['liggingsoptie'])) ? 'checked' : '' ?>> Aan het water</label>
            </fieldset>

            <fieldset style="margin-bottom: 10px;">
                <legend>Eigenschappen</legend>
                <label><input type="checkbox" name="eigenschap[]" value="1" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(1, $_GET['eigenschap'])) ? 'checked' : '' ?>> Inclusief overname inventaris</label><br>
                <label><input type="checkbox" name="eigenschap[]" value="2" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(2, $_GET['eigenschap'])) ? 'checked' : '' ?>> Zwembad</label><br>
                <label><input type="checkbox" name="eigenschap[]" value="3" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(3, $_GET['eigenschap'])) ? 'checked' : '' ?>> Winkel(s) in de buurt</label><br>
                <label><input type="checkbox" name="eigenschap[]" value="4" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(4, $_GET['eigenschap'])) ? 'checked' : '' ?>> Entertainment in de buurt</label><br>
                <label><input type="checkbox" name="eigenschap[]" value="5" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(5, $_GET['eigenschap'])) ? 'checked' : '' ?>> Op een privépark</label>
            </fieldset>

            <button type="submit">Zoeken</button>
        </form>
        <div style="display:flex;flex-wrap:wrap;gap:15px;padding:20px;">
            <?php foreach ($villas as $item): ?>
                <div style="border:1px solid #ccc;padding:15px;width:250px;">
                    <a href="villa.php?id=<?= htmlspecialchars($item['id']) ?>"
                        style="text-decoration:none;color:black;">
                        <?php
                        $primaryImage = $villa->getPrimaryImage($item['id']);
                        if ($primaryImage):
                        ?>
                            <img src="assets/img/villa/<?= htmlspecialchars($primaryImage) ?>"
                                alt="<?= htmlspecialchars($item['name']) ?>"
                                style="width:100%;height:auto;margin-bottom:10px;">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/250x150?text=Geen+afbeelding" alt="Geen afbeelding"
                                style="width:100%;height:auto;margin-bottom:10px;">
                        <?php endif; ?>

                        <h2 style="margin:0 0 10px 0;font-size:18px;"><?= htmlspecialchars($item['name']) ?></h2>
                        <p style="margin:0;"><?= htmlspecialchars($item['street'] . ' ' . $item['number']) ?></p>
                        <p style="margin:0;"><?= htmlspecialchars($item['postal']) ?></p>
                        <p style="margin:10px 0 0 0;font-weight:bold;">Prijs:
                            €<?= htmlspecialchars(number_format($item['price'], 2, ',', '.')) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php else: ?>

    <?php include_once 'sections/villa_detail.php'; ?>

<?php endif; ?>