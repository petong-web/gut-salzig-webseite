<?php
require_once __DIR__ . '/auth.php';
$page = 'blog';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

// Leeres Template
$record = [
    'title' => '', 'slug' => '', 'body' => '', 'author' => 'Captain',
    'author_initial' => 'C.', 'coordinates' => '54°26′N · 10°14′E',
    'location' => 'Stein', 'photo' => '', 'entry_number' => 0,
    'is_published' => 0, 'published_at' => date('Y-m-d\TH:i'),
];

// Laden bei Edit
if ($isEdit) {
    $record = dbRow("SELECT * FROM blog WHERE id = ?", [$id]);
    if (!$record) {
        flash('error', 'Blog-Eintrag nicht gefunden.');
        redirect('blog.php');
    }
    // Format datetime for input field
    if (!empty($record['published_at'])) {
        $record['published_at'] = date('Y-m-d\TH:i', strtotime($record['published_at']));
    }
}

// ── POST: Speichern ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $record['title']          = trim($_POST['title'] ?? '');
    $record['slug']           = slugify($record['title']);
    $record['body']           = trim($_POST['body'] ?? '');
    $record['author']         = trim($_POST['author'] ?? 'Captain');
    $record['author_initial'] = trim($_POST['author_initial'] ?? 'C.');
    $record['coordinates']    = trim($_POST['coordinates'] ?? '54°26′N · 10°14′E');
    $record['location']       = trim($_POST['location'] ?? 'Stein');
    $record['entry_number']   = (int)($_POST['entry_number'] ?? 0);
    $record['is_published']   = isset($_POST['is_published']) ? 1 : 0;
    $record['published_at']   = !empty($_POST['published_at']) ? date('Y-m-d H:i:s', strtotime($_POST['published_at'])) : null;

    // Foto-Upload
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $path = uploadImage($_FILES['photo'], 'blog');
        if ($path) $record['photo'] = $path;
    }

    // Validierung
    $errors = [];
    if (empty($record['title'])) $errors[] = 'Titel ist erforderlich.';
    if (empty($record['body']))  $errors[] = 'Text ist erforderlich.';

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE blog SET
                title=?, slug=?, body=?, author=?, author_initial=?, coordinates=?,
                location=?, photo=?, entry_number=?, is_published=?, published_at=?
                WHERE id=?", [
                $record['title'], $record['slug'], $record['body'],
                $record['author'], $record['author_initial'], $record['coordinates'],
                $record['location'], $record['photo'], $record['entry_number'],
                $record['is_published'], $record['published_at'], $id
            ]);
            flash('success', 'Blog-Eintrag aktualisiert.');
        } else {
            $newId = dbInsert("INSERT INTO blog
                (title, slug, body, author, author_initial, coordinates, location, photo, entry_number, is_published, published_at)
                VALUES (?,?,?,?,?,?,?,?,?,?,?)", [
                $record['title'], $record['slug'], $record['body'],
                $record['author'], $record['author_initial'], $record['coordinates'],
                $record['location'], $record['photo'], $record['entry_number'],
                $record['is_published'], $record['published_at']
            ]);
            flash('success', 'Blog-Eintrag erstellt.');
            redirect('blog-edit.php?id=' . $newId);
        }
        redirect('blog.php');
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
<title><?= $isEdit ? 'Log-Eintrag bearbeiten' : 'Neuer Log-Eintrag' ?> — gut salzig Admin</title>
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
      <a href="blog.php" class="btn-back">← Alle Einträge</a>
      <h1><?= $isEdit ? 'Log-Eintrag <em>bearbeiten</em>' : 'Neuer <em>Log-Eintrag</em>' ?></h1>
    </div>
    <?php if ($isEdit): ?>
      <form method="post" action="blog-delete.php" style="display:inline;" onsubmit="return confirm('Log-Eintrag wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" enctype="multipart/form-data" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>

    <!-- Titel + Entry Number -->
    <div class="form-row">
      <div class="field">
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" value="<?= h($record['title']) ?>" placeholder="z.B. Erster Sturm der Saison" required>
      </div>
      <div class="field">
        <label for="entry_number">Eintrag Nr.</label>
        <input type="number" id="entry_number" name="entry_number" value="<?= h($record['entry_number']) ?>" step="1" placeholder="1">
      </div>
    </div>

    <!-- Body -->
    <div class="form-row s1">
      <div class="field">
        <label for="body">Text</label>
        <textarea id="body" name="body" style="min-height:250px;" placeholder="Der Logbuch-Text..." required><?= h($record['body']) ?></textarea>
      </div>
    </div>

    <!-- Autor + Autor Initial -->
    <div class="form-row">
      <div class="field">
        <label for="author">Autor</label>
        <input type="text" id="author" name="author" value="<?= h($record['author']) ?>" placeholder="Captain">
      </div>
      <div class="field">
        <label for="author_initial">Autor-Kürzel</label>
        <input type="text" id="author_initial" name="author_initial" value="<?= h($record['author_initial']) ?>" placeholder="C." maxlength="5">
      </div>
    </div>

    <!-- Koordinaten + Ort -->
    <div class="form-row">
      <div class="field">
        <label for="coordinates">Koordinaten</label>
        <input type="text" id="coordinates" name="coordinates" value="<?= h($record['coordinates']) ?>" placeholder="54°26′N · 10°14′E">
      </div>
      <div class="field">
        <label for="location">Ort</label>
        <input type="text" id="location" name="location" value="<?= h($record['location']) ?>" placeholder="Stein">
      </div>
    </div>

    <!-- Veröffentlicht am -->
    <div class="form-row">
      <div class="field">
        <label for="published_at">Veröffentlicht am</label>
        <input type="datetime-local" id="published_at" name="published_at" value="<?= h($record['published_at'] ?? '') ?>">
      </div>
      <div class="field">
        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;">
          <input type="checkbox" name="is_published" value="1" <?= ($record['is_published'] ?? 0) ? 'checked' : '' ?> style="width:auto;">
          Veröffentlicht
        </label>
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

    <div style="margin-top:1.5rem;">
      <button type="submit" class="btn-submit"><?= $isEdit ? 'Änderungen speichern' : 'Log-Eintrag erstellen' ?> →</button>
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
