<?php
require_once __DIR__ . '/auth.php';
$page = 'jobs';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$departments = ['Küche', 'Service', 'Events', 'Strand-Imbiss'];
$jobTypes    = ['Vollzeit', 'Teilzeit', 'Voll-/Teilzeit', 'Saison', 'Minijob'];

// Leeres Template
$record = [
    'title' => '', 'department' => 'Küche', 'job_type' => 'Vollzeit',
    'description' => '', 'tasks' => '[]', 'photo' => '',
    'meta_json' => '[]', 'job_code' => '', 'is_active' => 1, 'sort_order' => 0,
];

// Laden bei Edit
if ($isEdit) {
    $record = dbRow("SELECT * FROM jobs WHERE id = ?", [$id]);
    if (!$record) {
        flash('error', 'Job nicht gefunden.');
        redirect('jobs.php');
    }
}

// Tasks als Text (eine Zeile pro Aufgabe)
$tasksText = implode("\n", json_decode($record['tasks'] ?? '[]', true) ?: []);

// Meta-JSON dekodieren (Array mit 3 Einträgen [{label, value}, ...])
$metaItems = json_decode($record['meta_json'] ?? '[]', true) ?: [];
$meta1 = $metaItems[0] ?? ['label' => '', 'value' => ''];
$meta2 = $metaItems[1] ?? ['label' => '', 'value' => ''];
$meta3 = $metaItems[2] ?? ['label' => '', 'value' => ''];

// ── POST: Speichern ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $record['title']       = trim($_POST['title'] ?? '');
    $record['department']  = $_POST['department'] ?? 'Küche';
    $record['job_type']    = $_POST['job_type'] ?? 'Vollzeit';
    $record['description'] = trim($_POST['description'] ?? '');
    $record['job_code']    = trim($_POST['job_code'] ?? '');
    $record['is_active']   = isset($_POST['is_active']) ? 1 : 0;
    $record['sort_order']  = (int)($_POST['sort_order'] ?? 0);

    // Tasks: eine pro Zeile -> JSON array
    $lines = array_filter(array_map('trim', explode("\n", $_POST['tasks'] ?? '')));
    $record['tasks'] = json_encode(array_values($lines), JSON_UNESCAPED_UNICODE);
    $tasksText = implode("\n", $lines);

    // Meta-JSON: 3 label/value Paare
    $metaArr = [];
    for ($i = 1; $i <= 3; $i++) {
        $label = trim($_POST["meta_label_$i"] ?? '');
        $value = trim($_POST["meta_value_$i"] ?? '');
        if ($label !== '' || $value !== '') {
            $metaArr[] = ['label' => $label, 'value' => $value];
        }
    }
    $record['meta_json'] = json_encode($metaArr, JSON_UNESCAPED_UNICODE);
    $meta1 = $metaArr[0] ?? ['label' => '', 'value' => ''];
    $meta2 = $metaArr[1] ?? ['label' => '', 'value' => ''];
    $meta3 = $metaArr[2] ?? ['label' => '', 'value' => ''];

    // Foto-Upload
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $path = uploadImage($_FILES['photo'], 'jobs');
        if ($path) $record['photo'] = $path;
    }

    // Validierung
    $errors = [];
    if (empty($record['title']))       $errors[] = 'Titel ist erforderlich.';
    if (empty($record['description'])) $errors[] = 'Beschreibung ist erforderlich.';
    if (!in_array($record['department'], $departments)) $errors[] = 'Ungültige Abteilung.';
    if (!in_array($record['job_type'], $jobTypes))      $errors[] = 'Ungültiger Stellentyp.';

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE jobs SET
                title=?, department=?, job_type=?, description=?, tasks=?,
                photo=?, meta_json=?, job_code=?, is_active=?, sort_order=?
                WHERE id=?", [
                $record['title'], $record['department'], $record['job_type'],
                $record['description'], $record['tasks'], $record['photo'],
                $record['meta_json'], $record['job_code'],
                $record['is_active'], $record['sort_order'], $id
            ]);
            flash('success', 'Job aktualisiert.');
        } else {
            $newId = dbInsert("INSERT INTO jobs
                (title, department, job_type, description, tasks, photo, meta_json, job_code, is_active, sort_order)
                VALUES (?,?,?,?,?,?,?,?,?,?)", [
                $record['title'], $record['department'], $record['job_type'],
                $record['description'], $record['tasks'], $record['photo'],
                $record['meta_json'], $record['job_code'],
                $record['is_active'], $record['sort_order']
            ]);
            flash('success', 'Job erstellt.');
            redirect('jobs-edit.php?id=' . $newId);
        }
        redirect('jobs.php');
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
<title><?= $isEdit ? 'Job bearbeiten' : 'Neuer Job' ?> — gut salzig Admin</title>
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
      <a href="jobs.php" class="btn-back">← Alle Jobs</a>
      <h1><?= $isEdit ? 'Job <em>bearbeiten</em>' : 'Neuer <em>Job</em>' ?></h1>
    </div>
    <?php if ($isEdit): ?>
      <form method="post" action="jobs-delete.php" style="display:inline;" onsubmit="return confirm('Job wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" enctype="multipart/form-data" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>

    <!-- Titel + Job-Code -->
    <div class="form-row">
      <div class="field">
        <label for="title">Stellentitel</label>
        <input type="text" id="title" name="title" value="<?= h($record['title']) ?>" placeholder="z.B. Sous Chef (m/w/d)" required>
      </div>
      <div class="field">
        <label for="job_code">Job-Code</label>
        <input type="text" id="job_code" name="job_code" value="<?= h($record['job_code']) ?>" placeholder="z.B. GS · CHEF · 001" maxlength="20">
      </div>
    </div>

    <!-- Abteilung + Stellentyp -->
    <div class="form-row">
      <div class="field">
        <label for="department">Abteilung</label>
        <select id="department" name="department">
          <?php foreach ($departments as $dep): ?>
            <option value="<?= h($dep) ?>" <?= $record['department'] === $dep ? 'selected' : '' ?>>
              <?= h($dep) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="job_type">Stellentyp</label>
        <select id="job_type" name="job_type">
          <?php foreach ($jobTypes as $jt): ?>
            <option value="<?= h($jt) ?>" <?= $record['job_type'] === $jt ? 'selected' : '' ?>>
              <?= h($jt) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <!-- Beschreibung -->
    <div class="form-row s1">
      <div class="field">
        <label for="description">Beschreibung</label>
        <textarea id="description" name="description" style="min-height:120px;" placeholder="Was erwartet den Bewerber?" required><?= h($record['description']) ?></textarea>
      </div>
    </div>

    <!-- Aufgaben (eine pro Zeile) -->
    <div class="form-row s1">
      <div class="field">
        <label for="tasks">Aufgaben (eine pro Zeile)</label>
        <textarea id="tasks" name="tasks" style="min-height:150px;" placeholder="Zubereitung von Fischgerichten&#10;Mise en place&#10;Wareneinkauf und Qualitätskontrolle"><?= h($tasksText) ?></textarea>
      </div>
    </div>

    <!-- Meta-Felder (3 Label/Value Paare) -->
    <fieldset style="border:1px solid var(--line);padding:1.2rem;margin:1rem 0;">
      <legend style="font-family:var(--ff-mono);font-size:0.75rem;color:var(--ink-mute);padding:0 0.5rem;">Meta-Infos (z.B. Erfahrung, Startdatum, Gehalt)</legend>

      <div class="form-row">
        <div class="field">
          <label for="meta_label_1">Label 1</label>
          <input type="text" id="meta_label_1" name="meta_label_1" value="<?= h($meta1['label'] ?? '') ?>" placeholder="z.B. Erfahrung">
        </div>
        <div class="field">
          <label for="meta_value_1">Wert 1</label>
          <input type="text" id="meta_value_1" name="meta_value_1" value="<?= h($meta1['value'] ?? '') ?>" placeholder="z.B. 2+ Jahre">
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label for="meta_label_2">Label 2</label>
          <input type="text" id="meta_label_2" name="meta_label_2" value="<?= h($meta2['label'] ?? '') ?>" placeholder="z.B. Start">
        </div>
        <div class="field">
          <label for="meta_value_2">Wert 2</label>
          <input type="text" id="meta_value_2" name="meta_value_2" value="<?= h($meta2['value'] ?? '') ?>" placeholder="z.B. Ab sofort">
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label for="meta_label_3">Label 3</label>
          <input type="text" id="meta_label_3" name="meta_label_3" value="<?= h($meta3['label'] ?? '') ?>" placeholder="z.B. Gehalt">
        </div>
        <div class="field">
          <label for="meta_value_3">Wert 3</label>
          <input type="text" id="meta_value_3" name="meta_value_3" value="<?= h($meta3['value'] ?? '') ?>" placeholder="z.B. Nach Vereinbarung">
        </div>
      </div>
    </fieldset>

    <!-- Foto -->
    <div class="form-row s1">
      <div class="field">
        <label>Job-Foto</label>
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
      <button type="submit" class="btn-submit"><?= $isEdit ? 'Änderungen speichern' : 'Job erstellen' ?> →</button>
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
