<?php include '../includes/data.php'; ?>
<?php Session::CheckSession(); ?>
<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['villa'])) {
        if (isset($_POST['add'])) {
            $villa_id = null;
            if ($villa->addVilla($_POST['name'], $_POST['price'], $_POST['postal'], $_POST['street'], $_POST['number'], $_POST['desc'])) {
                $villa_id = $villa->getLastInsertId();
                if (!empty($_POST['eigenschappen'])) {
                    $villa->addVillaEigenschappen($villa_id, $_POST['eigenschappen']);
                }
                if (!empty($_POST['liggingsopties'])) {
                    $villa->addVillaOpties($villa_id, $_POST['liggingsopties']);
                }
            }
        } elseif (isset($_POST['update']) && isset($_POST['id'])) {
            if ($villa->updateVilla($_POST['id'], $_POST['name'], $_POST['price'], $_POST['postal'], $_POST['street'], $_POST['number'], $_POST['desc'])) {
                if (!empty($_POST['eigenschappen'])) {
                    $villa->addVillaEigenschappen($_POST['id'], $_POST['eigenschappen']);
                } else {
                    $villa->addVillaEigenschappen($_POST['id'], []);
                }
                if (!empty($_POST['liggingsopties'])) {
                    $villa->addVillaOpties($_POST['id'], $_POST['liggingsopties']);
                } else {
                    $villa->addVillaOpties($_POST['id'], []);
                }
            }
        } elseif (isset($_POST['delete']) && isset($_POST['id'])) {
            $villa->deleteVilla($_POST['id']);
        }
    } else if (isset($_GET['eigenschappen'])) {
        if (isset($_POST['add'])) {
            $options->addEigenschap($_POST['name']);
        } elseif (isset($_POST['update']) && isset($_POST['id'])) {
            $options->updateEigenschap($_POST['id'], $_POST['name']);
        } elseif (isset($_POST['delete']) && isset($_POST['id'])) {
            $options->deleteEigenschap($_POST['id']);
        }
    } else if (isset($_GET['liggingsopties'])) {
        if (isset($_POST['add'])) {
            $liggingsopties->addLiggingsoptie($_POST['name']);
        } elseif (isset($_POST['update']) && isset($_POST['id'])) {
            $liggingsopties->updateLiggingsoptie($_POST['id'], $_POST['name']);
        } elseif (isset($_POST['delete']) && isset($_POST['id'])) {
            $liggingsopties->deleteLiggingsoptie($_POST['id']);
        }
    } else if (isset($_GET['reserveringen'])) {
        if (isset($_POST['delete']) && isset($_POST['id'])) {
            $contact->deleteContact($_POST['id']);
        }
    }
}

?>

<body class="villadmin">
    <section class="sidebar">
        <h1>Vill<span>a</span>dmin</h1>
        <nav>
            <ul>
                <li><a href="/admin">Villa's</a></li>
                <li><a href="?eigenschappen">Eigenschappen</a></li>
                <li><a href="?liggingsopties">Liggingsopties</a></li>
                <li><a href="?reserveringen">Reserveringen</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </section>
    <section class="content">
<?php if (isset($_GET['eigenschappen'])) { ?>
            <h1>Eigenschappen</h1>
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($options->getEigenschappen() as $eigenschap): ?>
                        <tr>
                            <form method="POST" action="?eigenschappen">
                                <td>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($eigenschap->id) ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($eigenschap->name) ?>">
                                </td>
                                <td>
                                    <button type="submit" name="update">Update</button>
                                    <button type="submit" name="delete" onclick="return confirm('Weet je zeker dat je deze eigenschap wilt verwijderen?')">Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form method="POST" action="?eigenschappen">
                <input type="text" name="name" placeholder="Naam van de eigenschap">
                <button type="submit" name="add">Toevoegen</button>
            </form>
        <?php } else if (isset($_GET['liggingsopties'])) { ?>
            <h1>Liggingsopties</h1>
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($liggingsopties->getLiggingsopties() as $optie): ?>
                        <tr>
                            <form method="POST" action="?liggingsopties">
                                <td>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($optie->id) ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($optie->name) ?>">
                                </td>
                                <td>
                                    <button type="submit" name="update">Update</button>
                                    <button type="submit" name="delete" onclick="return confirm('Weet je zeker dat je deze liggingsoptie wilt verwijderen?')">Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form method="POST" action="?liggingsopties">
                <input type="text" name="name" placeholder="Naam van de liggingsoptie">
                <button type="submit" name="add">Toevoegen</button>
            </form>
        <?php } else if (isset($_GET['reserveringen'])) { ?>
            <h1>Reserveringen</h1>
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Email</th>
                        <th>Villa</th>
                        <th>Vraag</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contact->getContacts() as $contactItem): ?>
                        <tr>
                            <td><?= htmlspecialchars($contactItem->naam) ?></td>
                            <td><?= htmlspecialchars($contactItem->email) ?></td>
                            <td><?= htmlspecialchars($villa->getVilla($contactItem->villa)['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($contactItem->vraag) ?></td>
                            <td>
                                <form method="POST" action="?reserveringen" onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?')">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($contactItem->id) ?>">
                                    <button type="submit" name="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } else if (isset($_GET['villa'])) { ?>
            <?php if (isset($_GET['id'])): ?>
                <?php $v = $villa->getVilla($_GET['id']); ?>
                <?php if ($v): ?>
                    <h1>Villa bewerken</h1>
                    <form method="POST" action="?villa">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($v['id']) ?>">
                        <label>Naam:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($v['name']) ?>">
                        <label>Prijs:</label>
                        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($v['price']) ?>">
                        <label>Postcode:</label>
                        <input type="text" name="postal" value="<?= htmlspecialchars($v['postal']) ?>">
                        <label>Straat:</label>
                        <input type="text" name="street" value="<?= htmlspecialchars($v['street']) ?>">
                        <label>Nummer:</label>
                        <input type="text" name="number" value="<?= htmlspecialchars($v['number']) ?>">
                        <label>Beschrijving:</label>
                        <textarea name="desc"><?= htmlspecialchars($v['desc']) ?></textarea>
                        <label>Eigenschappen:</label>
                        <select name="eigenschappen[]" multiple>
                            <?php
                            $selectedEigenschappen = $options->getEigenschappenByVilla($v['id']);
                            $selectedEigenschapIds = array_map(function($e) { return $e->id; }, $selectedEigenschappen);
                            foreach ($options->getEigenschappen() as $eigenschap): ?>
                                <option value="<?= htmlspecialchars($eigenschap->id) ?>" <?= in_array($eigenschap->id, $selectedEigenschapIds) ? 'selected' : '' ?>><?= htmlspecialchars($eigenschap->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>Liggingsopties:</label>
                        <select name="liggingsopties[]" multiple>
                            <?php
                            $selectedOpties = $liggingsopties->getliggingsoptiesByVilla($v['id']);
                            $selectedOptieIds = array_map(function($o) { return $o->id; }, $selectedOpties);
                            foreach ($liggingsopties->getLiggingsopties() as $optie): ?>
                                <option value="<?= htmlspecialchars($optie->id) ?>" <?= in_array($optie->id, $selectedOptieIds) ? 'selected' : '' ?>><?= htmlspecialchars($optie->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="update">Update</button>
                        <button type="submit" name="delete" onclick="return confirm('Weet je zeker dat je deze villa wilt verwijderen?')">Delete</button>
                    </form>
                    <a href="/admin">Terug naar overzicht</a>
                <?php else: ?>
                    <p>Villa niet gevonden.</p>
                    <a href="/admin">Terug naar overzicht</a>
                <?php endif; ?>
            <?php else: ?>
                <h1>Nieuwe villa toevoegen</h1>
            <form method="POST" action="?villa">
                <label>Naam:</label>
                <input type="text" name="name" required>
                <label>Prijs:</label>
                <input type="number" step="0.01" name="price" required>
                <label>Postcode:</label>
                <input type="text" name="postal" required>
                <label>Straat:</label>
                <input type="text" name="street" required>
                <label>Nummer:</label>
                <input type="text" name="number" required>
                <label>Beschrijving:</label>
                <textarea name="desc" required></textarea>
                <label>Eigenschappen:</label>
                <select name="eigenschappen[]" multiple>
                    <?php foreach ($options->getEigenschappen() as $eigenschap): ?>
                        <option value="<?= htmlspecialchars($eigenschap->id) ?>"><?= htmlspecialchars($eigenschap->name) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Liggingsopties:</label>
                <select name="liggingsopties[]" multiple>
                    <?php foreach ($liggingsopties->getLiggingsopties() as $optie): ?>
                        <option value="<?= htmlspecialchars($optie->id) ?>"><?= htmlspecialchars($optie->name) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="add">Toevoegen</button>
            </form>
                <a href="/admin">Terug naar overzicht</a>
            <?php endif; ?>
        <?php } else { ?>
            <header class="search">
                <form method="GET" action="/admin">
                    <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button type="submit">Zoeken</button>
                    <a href="?villa">Toevoegen</a>
                </form>
            </header>
            <div class="cards">
                <?php foreach ($villa->getVillas() as $v) { ?>
                    <div class="card">
                        <a href="?villa&id=<?= htmlspecialchars($v['id']) ?>">
                            <div>
                                <h2><?= htmlspecialchars($v['name']) ?></h2>
                                <p>€ <?= htmlspecialchars(number_format($v['price'], 2, ',', '.')) ?></p>
                            </div>
                            <img src="/assets/img/villa/<?= htmlspecialchars($villa->getPrimaryImage($v['id'])); ?>" alt="<?= htmlspecialchars($v['name']) ?>">
                        </a>
                        <form method="POST" action="?villa" onsubmit="return confirm('Weet je zeker dat je deze villa wilt verwijderen?')">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($v['id']) ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
            <a href="?villa">Nieuwe villa toevoegen</a>
        <?php } ?>
    </section>
</body>
</html>
