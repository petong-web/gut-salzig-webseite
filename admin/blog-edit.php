<?php
require_once __DIR__ . '/auth.php';
$page = 'blog';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$record = [
    'entry_type' => 'manual',
    'title' => '', 'slug' => '', 'body' => '', 'author' => 'Captain',
    'author_initial' => 'C.', 'coordinates' => '54°26′N · 10°14′E',
    'location' => 'Stein', 'photo' => '', 'entry_number' => 0,
    'instagram_url' => '', 'instagram_caption' => '', 'instagram_image' => '',
    'is_published' => 1, 'published_at' => date('Y-m-d\TH:i'),
];

if ($isEdit) {
    $record = dbRow("SELECT * FROM blog WHERE id = ?", [$id]);
    if (!$record) { flash('error', 'Nicht gefunden.'); redirect('blog.php'); }
    if (!empty($record['published_at'])) {
        $record['published_at'] = date('Y-m-d\TH:i', strtotime($record['published_at']));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $record['entry_type']       = $_POST['entry_type'] ?? 'manual';
    $record['title']            = trim($_POST['title'] ?? '');
    $record['slug']             = slugify($record['title']) ?: ('post-' . time());
    $record['body']             = trim($_POST['body'] ?? '');
    $record['author']           = trim($_POST['author'] ?? 'Captain');
    $record['author_initial']   = trim($_POST['author_initial'] ?? 'C.');
    $record['coordinates']      = trim($_POST['coordinates'] ?? '54°26′N · 10°14′E');
    $record['location']         = trim($_POST['location'] ?? 'Stein');
    $record['entry_number']     = (int)($_POST['entry_number'] ?? 0);
    $record['instagram_url']    = trim($_POST['instagram_url'] ?? '');
    $record['instagram_caption']= trim($_POST['instagram_caption'] ?? '');
    $record['is_published']     = isset($_POST['is_published']) ? 1 : 0;
    $record['published_at']     = !empty($_POST['published_at'])
        ? date('Y-m-d H:i:s', strtotime($_POST['published_at']))
        : date('Y-m-d H:i:s');

    // Foto-Upload (manuell)
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $p = uploadImage($_FILES['photo'], 'blog');
        if ($p) $record['photo'] = $p;
    }

    // Instagram-Image-Upload (Cover/Screenshot vom Post)
    if (!empty($_FILES['instagram_image']['name']) && $_FILES['instagram_image']['error'] === UPLOAD_ERR_OK) {
        $p = uploadImage($_FILES['instagram_image'], 'blog');
        if ($p) $record['instagram_image'] = $p;
    }

    // Validierung
    $errors = [];
    if (empty($record['title'])) $errors[] = 'Titel ist erforderlich.';
    if ($record['entry_type'] === 'manual' && empty($record['body'])) {
        $errors[] = 'Text ist bei manuellem Eintrag erforderlich.';
    }
    if ($record['entry_type'] === 'instagram' && empty($record['instagram_url'])) {
        $errors[] = 'Instagram-URL ist erforderlich.';
    }

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE blog SET
                entry_type=?, title=?, slug=?, body=?, author=?, author_initial=?, coordinates=?,
                location=?, photo=?, entry_number=?,
                instagram_url=?, instagram_caption=?, instagram_image=?,
                is_published=?, published_at=?
                WHERE id=?", [
                $record['entry_type'], $record['title'], $record['slug'], $record['body'],
                $record['author'], $record['author_initial'], $record['coordinates'],
                $record['location'], $record['photo'], $record['entry_number'],
                $record['instagram_url'], $record['instagram_caption'], $record['instagram_image'],
                $record['is_published'], $record['published_at'], $id
            ]);
            flash('success', 'Eintrag aktualisiert.');
        } else {
            $newId = dbInsert("INSERT INTO blog
                (entry_type, title, slug, body, author, author_initial, coordinates, location, photo, entry_number,
                 instagram_url, instagram_caption, instagram_image, is_published, published_at)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
                $record['entry_type'], $record['title'], $record['slug'], $record['body'],
                $record['author'], $record['author_initial'], $record['coordinates'],
                $record['location'], $record['photo'], $record['entry_number'],
                $record['instagram_url'], $record['instagram_caption'], $record['instagram_image'],
                $record['is_published'], $record['published_at']
            ]);
            flash('success', 'Eintrag erstellt.');
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
<style>
.type-tabs { display:flex; gap:0; margin-bottom:1.5rem; border-bottom:1px solid var(--line); }
.type-tab { padding:0.7rem 1.4rem; cursor:pointer; font-family:var(--ff-mono); font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--ink-mute); border-bottom:2px solid transparent; transition:all 0.2s; background:none; border-top:0; border-left:0; border-right:0; }
.type-tab.is-active { color:var(--accent); border-bottom-color:var(--accent); }
.type-section { display:none; }
.type-section.is-active { display:block; }
.ig-preview { background:var(--bg); border:1px solid var(--line); padding:1rem; margin-top:0.8rem; font-family:var(--ff-mono); font-size:0.78rem; color:var(--ink-soft); }
.ig-preview a { color:var(--accent); }
.help { font-size:0.7rem; color:var(--ink-mute); line-height:1.6; margin-top:0.4rem; }
.help code { font-family:var(--ff-mono); background:var(--bg); padding:0.1rem 0.35rem; border-radius:2px; color:var(--accent); }
</style>
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
      <form method="post" action="blog-delete.php" style="display:inline;" onsubmit="return confirm('Wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" enctype="multipart/form-data" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>

    <!-- Tabs: Manuell / Instagram -->
    <div class="type-tabs">
      <button type="button" class="type-tab <?= $record['entry_type']==='manual'?'is-active':'' ?>" data-type="manual">✎ Eigener Eintrag</button>
      <button type="button" class="type-tab <?= $record['entry_type']==='instagram'?'is-active':'' ?>" data-type="instagram">📷 Instagram-Post</button>
    </div>
    <input type="hidden" name="entry_type" id="entry_type" value="<?= h($record['entry_type']) ?>">

    <!-- Titel (immer sichtbar) -->
    <div class="form-row">
      <div class="field">
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" value="<?= h($record['title']) ?>" placeholder="z.B. Erster Dorsch der Saison" required>
      </div>
      <div class="field">
        <label for="entry_number">Eintrag Nr.</label>
        <input type="number" id="entry_number" name="entry_number" value="<?= h($record['entry_number']) ?>" placeholder="42">
      </div>
    </div>

    <!-- ===== TYPE: MANUELL ===== -->
    <div class="type-section <?= $record['entry_type']==='manual'?'is-active':'' ?>" id="section-manual">
      <div class="form-row s1">
        <div class="field">
          <label for="body">Text</label>
          <textarea id="body" name="body" style="min-height:200px;" placeholder="Was passiert heute…"><?= h($record['body']) ?></textarea>
        </div>
      </div>

      <div class="form-row s1">
        <div class="field">
          <label>Foto (optional)</label>
          <div class="upload-zone">
            <input type="file" name="photo" accept="image/*" onchange="previewImg(this,'preview-photo')">
            <p>📷 <span>Foto auswählen</span></p>
          </div>
          <?php if (!empty($record['photo'])): ?>
            <img src="../<?= h($record['photo']) ?>" class="upload-preview" id="preview-photo">
          <?php else: ?>
            <img class="upload-preview" id="preview-photo" style="display:none;">
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- ===== TYPE: INSTAGRAM ===== -->
    <div class="type-section <?= $record['entry_type']==='instagram'?'is-active':'' ?>" id="section-instagram">
      <div class="form-row s1">
        <div class="field">
          <label for="instagram_url">Instagram Post-URL</label>
          <input type="url" id="instagram_url" name="instagram_url" value="<?= h($record['instagram_url']) ?>" placeholder="https://www.instagram.com/p/ABC123xyz/" oninput="updateIgPreview()">
          <p class="help">
            URL des Instagram-Posts. So findest du sie:<br>
            1. Geh auf den Post in Instagram<br>
            2. Klicke auf <code>⋯</code> oben rechts → <code>Link kopieren</code><br>
            Oder im Browser: einfach die URL aus der Adressleiste kopieren.<br>
            Beispiel: <code>https://www.instagram.com/p/ABC123/</code> oder <code>/reel/XYZ789/</code>
          </p>
          <div id="ig-preview" class="ig-preview" style="display:<?= $record['instagram_url']?'block':'none' ?>;">
            ✓ Wird auf der Website als Instagram-Post eingebettet (Original-Foto, Caption, Likes)
          </div>
        </div>
      </div>

      <div class="form-row s1">
        <div class="field">
          <label for="instagram_caption">Caption / Beitragstext</label>
          <textarea id="instagram_caption" name="instagram_caption" style="min-height:200px;" placeholder="Hier den vollständigen Text des Instagram-Posts einfügen — wird direkt auf der Website in der Captain's-Log-Kachel angezeigt. Zeilenumbrüche bleiben erhalten. Hashtags sind erlaubt."><?= h($record['instagram_caption']) ?></textarea>
          <p class="help" style="margin-top:0.5rem;">
            <strong>Tipp:</strong> Kopiere den kompletten Caption-Text aus deinem Instagram-Post hier rein — Besucher der Website lesen ihn direkt in der Kachel ohne zu Instagram weitergeleitet zu werden. Lange Captions werden mit Fade ausgeblendet und beim Hover voll angezeigt.
          </p>
        </div>
      </div>

      <div class="form-row s1">
        <div class="field">
          <label>Vorschau-Bild für Captain's Log Karte</label>
          <div class="upload-zone">
            <input type="file" name="instagram_image" accept="image/*" onchange="previewImg(this,'preview-ig')">
            <p>📷 <span>Cover-Foto hochladen</span> (optional)</p>
          </div>
          <p class="help">
            Falls leer: wird das Default Captain's Log Foto genutzt. Bestes Format: 1:1 oder 4:5 (wie Instagram-Post).
          </p>
          <?php if (!empty($record['instagram_image'])): ?>
            <img src="../<?= h($record['instagram_image']) ?>" class="upload-preview" id="preview-ig">
          <?php else: ?>
            <img class="upload-preview" id="preview-ig" style="display:none;">
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Autor + Ort (immer) -->
    <div class="form-row">
      <div class="field">
        <label for="author">Autor</label>
        <input type="text" id="author" name="author" value="<?= h($record['author']) ?>" placeholder="Captain">
      </div>
      <div class="field">
        <label for="author_initial">Autor-Kürzel</label>
        <input type="text" id="author_initial" name="author_initial" value="<?= h($record['author_initial']) ?>" maxlength="5">
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label for="location">Ort</label>
        <input type="text" id="location" name="location" value="<?= h($record['location']) ?>" placeholder="Stein">
      </div>
      <div class="field">
        <label for="coordinates">Koordinaten</label>
        <input type="text" id="coordinates" name="coordinates" value="<?= h($record['coordinates']) ?>">
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label for="published_at">Veröffentlicht am</label>
        <input type="datetime-local" id="published_at" name="published_at" value="<?= h($record['published_at']) ?>">
      </div>
      <div class="field">
        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;">
          <input type="checkbox" name="is_published" value="1" <?= $record['is_published'] ? 'checked' : '' ?> style="width:auto;">
          Veröffentlicht / sichtbar
        </label>
      </div>
    </div>

    <button type="submit" class="btn-submit" style="margin-top:1.5rem;"><?= $isEdit ? 'Änderungen speichern' : 'Eintrag erstellen' ?> →</button>
  </form>
</main>
</div>

<script>
function previewImg(input, targetId) {
  const p = document.getElementById(targetId);
  if (input.files && input.files[0]) {
    const r = new FileReader();
    r.onload = e => { p.src = e.target.result; p.style.display = 'block'; };
    r.readAsDataURL(input.files[0]);
  }
}

// Tab-Switch
document.querySelectorAll('.type-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    const type = tab.dataset.type;
    document.querySelectorAll('.type-tab').forEach(t => t.classList.toggle('is-active', t.dataset.type === type));
    document.querySelectorAll('.type-section').forEach(s => s.classList.toggle('is-active', s.id === 'section-' + type));
    document.getElementById('entry_type').value = type;
  });
});

function updateIgPreview() {
  const url = document.getElementById('instagram_url').value.trim();
  const preview = document.getElementById('ig-preview');
  if (url.match(/instagram\.com\/(p|reel|tv)\//)) {
    preview.style.display = 'block';
    preview.innerHTML = '✓ Gültiger Instagram-Link erkannt — wird auf der Website eingebettet';
    preview.style.color = 'var(--sage)';
  } else if (url.length > 0) {
    preview.style.display = 'block';
    preview.innerHTML = '⚠ Bitte einen gültigen Instagram-Post-Link eingeben (instagram.com/p/... oder /reel/...)';
    preview.style.color = 'var(--red, #C9524F)';
  } else {
    preview.style.display = 'none';
  }
}
</script>
</body>
</html>
