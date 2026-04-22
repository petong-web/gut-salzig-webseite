<?php
require_once __DIR__ . '/auth.php';
$page = 'speisekarte';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$categories = [
    'starter'      => 'Starter',
    'fisch'        => 'Fisch',
    'fleisch'      => 'Fleisch',
    'vegetarisch'  => 'Vegetarisch',
    'dessert'      => 'Dessert',
];

// Leeres Template
$record = [
    'category' => 'starter', 'name' => '', 'description' => '',
    'price' => '', 'is_active' => 1, 'sort_order' => 0,
];

// Laden bei Edit
if ($isEdit) {
    $record = dbRow("SELECT * FROM speisekarte WHERE id = ?", [$id]);
    if (!$record) {
        flash('error', 'Menü-Eintrag nicht gefunden.');
        redirect('speisekarte.php');
    }
}

// ── POST: Speichern ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $record['category']    = $_POST['category'] ?? 'starter';
    $record['name']        = trim($_POST['name'] ?? '');
    $record['description'] = trim($_POST['description'] ?? '');
    $record['price']       = !empty($_POST['price']) ? (float)$_POST['price'] : null;
    $record['is_active']   = isset($_POST['is_active']) ? 1 : 0;
    $record['sort_order']  = (int)($_POST['sort_order'] ?? 0);

    // Validierung
    $errors = [];
    if (empty($record['name']))     $errors[] = 'Name ist erforderlich.';
    if (!isset($categories[$record['category']])) $errors[] = 'Ungültige Kategorie.';

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE speisekarte SET
                category=?, name=?, description=?, price=?, is_active=?, sort_order=?
                WHERE id=?", [
                $record['category'], $record['name'], $record['description'],
                $record['price'], $record['is_active'], $record['sort_order'], $id
            ]);
            flash('success', 'Menü-Eintrag aktualisiert.');
        } else {
            $newId = dbInsert("INSERT INTO speisekarte
                (category, name, description, price, is_active, sort_order)
                VALUES (?,?,?,?,?,?)", [
                $record['category'], $record['name'], $record['description'],
                $record['price'], $record['is_active'], $record['sort_order']
            ]);
            flash('success', 'Menü-Eintrag erstellt.');
            redirect('speisekarte-edit.php?id=' . $newId);
        }
        redirect('speisekarte.php');
    } else {
        foreach ($errors as $e) flash('error', $e);
    }
}
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $isEdit ? 'Menü-Eintrag bearbeiten' : 'Neuer Menü-Eintrag' ?> — gut salzig Admin</title>
<link rel="icon" type="image/svg+xml" href="../prototype/assets/logo/icon-blk.svg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;1,9..144,300&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-wrap">
<?php require __DIR__ . '/sidebar.php'; ?>
<main class="main">
  <?= renderFlash() ?>

  <div class="topbar">
    <div>
      <a href="speisekarte.php" class="btn-back">← Alle Gerichte</a>
      <h1><?= $isEdit ? 'Menü-Eintrag <em>bearbeiten</em>' : 'Neuer <em>Menü-Eintrag</em>' ?></h1>
    </div>
    <?php if ($isEdit): ?>
      <form method="post" action="speisekarte-delete.php" style="display:inline;" onsubmit="return confirm('Menü-Eintrag wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>

    <!-- Kategorie + Name -->
    <div class="form-row">
      <div class="field">
        <label for="category">Kategorie</label>
        <select id="category" name="category">
          <?php foreach ($categories as $key => $label): ?>
            <option value="<?= h($key) ?>" <?= $record['category'] === $key ? 'selected' : '' ?>>
              <?= h($label) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="name">Gericht-Name</label>
        <input type="text" id="name" name="name" value="<?= h($record['name']) ?>" placeholder="z.B. Scholle Finkenwerder Art" required>
      </div>
    </div>

    <!-- Beschreibung + Preis -->
    <div class="form-row">
      <div class="field">
        <label for="description">Beschreibung (optional)</label>
        <input type="text" id="description" name="description" value="<?= h($record['description'] ?? '') ?>" placeholder="z.B. mit Speck, Krabben und Bratkartoffeln">
      </div>
      <div class="field">
        <label for="price">Preis (€)</label>
        <input type="number" id="price" name="price" value="<?= $record['price'] ? h($record['price']) : '' ?>" step="0.01" placeholder="24.50">
      </div>
    </div>

    <!-- Aktiv + Sortierung -->
    <div class="form-row">
      <div class="field">
        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" <?= $record['is_active'] ? 'checked' : '' ?> style="width:auto;">
          Aktiv / sichtbar
        </label>
      </div>
      <div class="field">
        <label for="sort_order">Sortierung</label>
        <input type="number" id="sort_order" name="sort_order" value="<?= h($record['sort_order']) ?>" step="1" placeholder="0">
      </div>
    </div>

    <div style="margin-top:1.5rem;">
      <button type="submit" class="btn-submit"><?= $isEdit ? 'Änderungen speichern' : 'Menü-Eintrag erstellen' ?> →</button>
    </div>
  </form>

</main>
</div>
</body>
</html>
