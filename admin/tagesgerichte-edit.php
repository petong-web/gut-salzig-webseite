<?php
require_once __DIR__ . '/auth.php';
$page = 'tagesgerichte';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

// Leeres Template
$record = [
    'name' => '', 'label' => '', 'code' => '', 'description' => '',
    'price' => '', 'photo' => '', 'is_active' => 1, 'sort_order' => 0,
];

// Laden bei Edit
if ($isEdit) {
    $record = dbRow("SELECT * FROM tagesgerichte WHERE id = ?", [$id]);
    if (!$record) {
        flash('error', 'Tagesgericht nicht gefunden.');
        redirect('tagesgerichte.php');
    }
}

// ── POST: Speichern ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $record['name']        = trim($_POST['name'] ?? '');
    $record['label']       = trim($_POST['label'] ?? '');
    $record['code']        = trim($_POST['code'] ?? '');
    $record['description'] = trim($_POST['description'] ?? '');
    $record['price']       = !empty($_POST['price']) ? (float)$_POST['price'] : 0;
    $record['is_active']   = isset($_POST['is_active']) ? 1 : 0;
    $record['sort_order']  = (int)($_POST['sort_order'] ?? 0);

    // Foto-Upload
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $path = uploadImage($_FILES['photo'], 'tagesgerichte');
        if ($path) $record['photo'] = $path;
    }

    // Validierung
    $errors = [];
    if (empty($record['name']))        $errors[] = 'Name ist erforderlich.';
    if (empty($record['description'])) $errors[] = 'Beschreibung ist erforderlich.';
    if ($record['price'] <= 0)         $errors[] = 'Preis ist erforderlich.';

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE tagesgerichte SET
                name=?, label=?, code=?, description=?, price=?, photo=?, is_active=?, sort_order=?
                WHERE id=?", [
                $record['name'], $record['label'], $record['code'],
                $record['description'], $record['price'], $record['photo'],
                $record['is_active'], $record['sort_order'], $id
            ]);
            flash('success', 'Tagesgericht aktualisiert.');
        } else {
            $newId = dbInsert("INSERT INTO tagesgerichte
                (name, label, code, description, price, photo, is_active, sort_order)
                VALUES (?,?,?,?,?,?,?,?)", [
                $record['name'], $record['label'], $record['code'],
                $record['description'], $record['price'], $record['photo'],
                $record['is_active'], $record['sort_order']
            ]);
            flash('success', 'Tagesgericht erstellt.');
            redirect('tagesgerichte-edit.php?id=' . $newId);
        }
        redirect('tagesgerichte.php');
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
<title><?= $isEdit ? 'Tagesgericht bearbeiten' : 'Neues Tagesgericht' ?> — gut salzig Admin</title>
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
      <a href="tagesgerichte.php" class="btn-back">← Alle Tagesgerichte</a>
      <h1><?= $isEdit ? 'Tagesgericht <em>bearbeiten</em>' : 'Neues <em>Tagesgericht</em>' ?></h1>
    </div>
    <?php if ($isEdit): ?>
      <form method="post" action="tagesgerichte-delete.php" style="display:inline;" onsubmit="return confirm('Tagesgericht wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" enctype="multipart/form-data" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>

    <!-- Name + Label -->
    <div class="form-row">
      <div class="field">
        <label for="name">Gericht-Name</label>
        <input type="text" id="name" name="name" value="<?= h($record['name']) ?>" placeholder="z.B. Gebratener Dorsch" required>
      </div>
      <div class="field">
        <label for="label">Label / Kategorie</label>
        <input type="text" id="label" name="label" value="<?= h($record['label']) ?>" placeholder="z.B. Tagesfisch">
      </div>
    </div>

    <!-- Code + Preis -->
    <div class="form-row">
      <div class="field">
        <label for="code">Code</label>
        <input type="text" id="code" name="code" value="<?= h($record['code']) ?>" placeholder="z.B. GS · DRS" maxlength="10">
      </div>
      <div class="field">
        <label for="price">Preis (€)</label>
        <input type="number" id="price" name="price" value="<?= $record['price'] ? h($record['price']) : '' ?>" step="0.01" placeholder="18.50" required>
      </div>
    </div>

    <!-- Beschreibung -->
    <div class="form-row s1">
      <div class="field">
        <label for="description">Beschreibung</label>
        <textarea id="description" name="description" placeholder="z.B. mit Kartoffelstampf, Senfsauce und Gurkensalat" required><?= h($record['description']) ?></textarea>
      </div>
    </div>

    <!-- Foto -->
    <div class="form-row s1">
      <div class="field">
        <label>Foto</label>
        <div class="upload-zone">
          <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" onchange="previewImg(this)">
          <p>📷 <span>Foto auswählen</span> oder hierhin ziehen</p>
          <p style="font-size:0.6rem;color:var(--ink-mute);margin-top:0.3rem;">JPG, PNG oder WebP · max. 10 MB · wird auf 1200px skaliert</p>
        </div>
        <?php if (!empty($record['photo'])): ?>
          <img src="../<?= h($record['photo']) ?>" class="upload-preview" id="preview" alt="Foto">
        <?php else: ?>
          <img src="" class="upload-preview" id="preview" alt="" style="display:none;">
        <?php endif; ?>
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
      <button type="submit" class="btn-submit"><?= $isEdit ? 'Änderungen speichern' : 'Tagesgericht erstellen' ?> →</button>
    </div>
  </form>

</main>
</div>

<script>
function previewImg(input) {
  const preview = document.getElementById('preview');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
</body>
</html>
