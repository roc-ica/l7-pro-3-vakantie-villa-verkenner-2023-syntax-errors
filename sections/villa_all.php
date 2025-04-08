<?php include_once 'includes/data.php'; ?>

<?php if (!isset($_GET['id'])): ?>
    <?php $villas = $villa->getVillas(); ?>
    <?php
    $filters = [
        'name' => $_GET['name'] ?? null,
        'min_price' => $_GET['min_price'] ?? null,
        'max_price' => $_GET['max_price'] ?? null,
        'liggingsoptie' => $_GET['liggingsoptie'] ?? null,
        'eigenschap' => $_GET['eigenschap'] ?? null,
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

            <select name="liggingsoptie" style="margin-right: 10px;">
                <option value="">Ligging</option>
                <option value="1" <?= (isset($_GET['liggingsoptie']) && $_GET['liggingsoptie'] == 1) ? 'selected' : '' ?>>
                    Dicht bij een bos
                </option>
                <option value="2" <?= (isset($_GET['liggingsoptie']) && $_GET['liggingsoptie'] == 2) ? 'selected' : '' ?>>
                    Dicht bij een stad
                </option>
                <option value="3" <?= (isset($_GET['liggingsoptie']) && $_GET['liggingsoptie'] == 3) ? 'selected' : '' ?>>
                    Dicht bij de zee
                </option>
                <option value="4" <?= (isset($_GET['liggingsoptie']) && $_GET['liggingsoptie'] == 4) ? 'selected' : '' ?>>
                    In het heuvelland
                </option>
                <option value="5" <?= (isset($_GET['liggingsoptie']) && $_GET['liggingsoptie'] == 5) ? 'selected' : '' ?>>
                    Aan het water
                </option>
            </select>

            <select name="eigenschap" style="margin-right: 10px;">
                <option value="">Eigenschap</option>
                <option value="1" <?= (isset($_GET['eigenschap']) && $_GET['eigenschap'] == 1) ? 'selected' : '' ?>>
                    Inclusief overname inventaris
                </option>
                <option value="2" <?= (isset($_GET['eigenschap']) && $_GET['eigenschap'] == 2) ? 'selected' : '' ?>>
                    Zwembad
                </option>
                <option value="3" <?= (isset($_GET['eigenschap']) && $_GET['eigenschap'] == 3) ? 'selected' : '' ?>>
                    Winkel(s) in de buurt
                </option>
                <option value="4" <?= (isset($_GET['eigenschap']) && $_GET['eigenschap'] == 4) ? 'selected' : '' ?>>
                    Entertainment in de buurt
                </option>
                <option value="5" <?= (isset($_GET['eigenschap']) && $_GET['eigenschap'] == 5) ? 'selected' : '' ?>>Op
                    een privépark
                </option>
            </select>

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