<?php
require_once __DIR__ . '/auth.php';
$page = 'events';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

// Kategorien und Icons
$categories = [
    'Live Musik'  => '♪',
    'Buffet'      => '◉',
    'Workshop'    => '✎',
    'Feiertag'    => '★',
    'Party'       => '✦',
    'Komedie'     => '☺',
    'Lesung'      => '❖',
];

// Leeres Event-Template
$event = [
    'title' => '', 'slug' => '', 'iata_code' => '', 'event_date' => date('Y-m-d'),
    'event_time' => '18:00', 'category' => 'Live Musik', 'category_icon' => '♪',
    'ticket_type' => 'free', 'price' => '', 'gate' => 'Terrasse',
    'description' => '', 'photo' => '', 'pnr_code' => '', 'is_active' => 1,
];

// Laden bei Edit
if ($isEdit) {
    $event = dbRow("SELECT * FROM events WHERE id = ?", [$id]);
    if (!$event) {
        flash('error', 'Event nicht gefunden.');
        redirect('events.php');
    }
}

// ── POST: Speichern ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $event['title']         = trim($_POST['title'] ?? '');
    $event['slug']          = slugify($event['title']);
    $event['iata_code']     = strtoupper(trim($_POST['iata_code'] ?? ''));
    $event['event_date']    = $_POST['event_date'] ?? date('Y-m-d');
    $event['event_time']    = $_POST['event_time'] ?? '18:00';
    $event['category']      = $_POST['category'] ?? 'Live Musik';
    $event['category_icon'] = $categories[$event['category']] ?? '♪';
    $event['ticket_type']   = $_POST['ticket_type'] ?? 'free';
    $event['price']         = !empty($_POST['price']) ? (float)$_POST['price'] : null;
    $event['gate']          = trim($_POST['gate'] ?? 'Terrasse');
    $event['description']   = trim($_POST['description'] ?? '');
    $event['is_active']     = isset($_POST['is_active']) ? 1 : 0;
    $event['pnr_code']      = generatePNR($event['event_date']);

    // Foto-Upload
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $path = uploadImage($_FILES['photo'], 'events');
        if ($path) $event['photo'] = $path;
    }

    // Validierung
    $errors = [];
    if (empty($event['title']))     $errors[] = 'Titel ist erforderlich.';
    if (empty($event['iata_code']) || strlen($event['iata_code']) !== 3)
        $errors[] = 'IATA-Code muss genau 3 Buchstaben haben.';
    if (empty($event['event_date'])) $errors[] = 'Datum ist erforderlich.';

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE events SET
                title=?, slug=?, iata_code=?, event_date=?, event_time=?,
                category=?, category_icon=?, ticket_type=?, price=?, gate=?,
                description=?, photo=?, pnr_code=?, is_active=?
                WHERE id=?", [
                $event['title'], $event['slug'], $event['iata_code'],
                $event['event_date'], $event['event_time'],
                $event['category'], $event['category_icon'],
                $event['ticket_type'], $event['price'], $event['gate'],
                $event['description'], $event['photo'], $event['pnr_code'],
                $event['is_active'], $id
            ]);
            flash('success', 'Event aktualisiert.');
        } else {
            $newId = dbInsert("INSERT INTO events
                (title, slug, iata_code, event_date, event_time, category, category_icon,
                 ticket_type, price, gate, description, photo, pnr_code, is_active)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
                $event['title'], $event['slug'], $event['iata_code'],
                $event['event_date'], $event['event_time'],
                $event['category'], $event['category_icon'],
                $event['ticket_type'], $event['price'], $event['gate'],
                $event['description'], $event['photo'], $event['pnr_code'],
                $event['is_active']
            ]);
            flash('success', 'Event erstellt.');
            redirect('event-edit.php?id=' . $newId);
        }
        redirect('events.php');
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
<title><?= $isEdit ? 'Event bearbeiten' : 'Neues Event' ?> — gut salzig Admin</title>
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
      <a href="events.php" class="btn-back">← Alle Events</a>
      <h1><?= $isEdit ? 'Event <em>bearbeiten</em>' : 'Neues <em>Event</em>' ?></h1>
    </div>
    <?php if ($isEdit): ?>
      <form method="post" action="event-delete.php" style="display:inline;" onsubmit="return confirm('Event wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" enctype="multipart/form-data" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>

    <!-- Titel + IATA -->
    <div class="form-row">
      <div class="field">
        <label for="title">Event-Titel</label>
        <input type="text" id="title" name="title" value="<?= h($event['title']) ?>" placeholder="z.B. Sommer-Eröffnungsfest" required>
      </div>
      <div class="field">
        <label for="iata_code">IATA-Code (3 Buchstaben)</label>
        <input type="text" id="iata_code" name="iata_code" value="<?= h($event['iata_code']) ?>" placeholder="SOM" maxlength="3" style="text-transform:uppercase;" required>
      </div>
    </div>

    <!-- Datum + Uhrzeit -->
    <div class="form-row">
      <div class="field">
        <label for="event_date">Datum</label>
        <input type="date" id="event_date" name="event_date" value="<?= h($event['event_date']) ?>" required>
      </div>
      <div class="field">
        <label for="event_time">Uhrzeit</label>
        <input type="time" id="event_time" name="event_time" value="<?= h($event['event_time']) ?>">
      </div>
    </div>

    <!-- Kategorie + Gate -->
    <div class="form-row">
      <div class="field">
        <label for="category">Kategorie</label>
        <select id="category" name="category">
          <?php foreach ($categories as $cat => $icon): ?>
            <option value="<?= h($cat) ?>" <?= $event['category'] === $cat ? 'selected' : '' ?>>
              <?= $icon ?> <?= h($cat) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="gate">Gate / Location</label>
        <input type="text" id="gate" name="gate" value="<?= h($event['gate']) ?>" placeholder="Terrasse">
      </div>
    </div>

    <!-- Ticket-Typ + Preis -->
    <div class="form-row">
      <div class="field">
        <label for="ticket_type">Ticket-Typ</label>
        <select id="ticket_type" name="ticket_type">
          <option value="free" <?= $event['ticket_type'] === 'free' ? 'selected' : '' ?>>Freier Eintritt</option>
          <option value="ticket" <?= $event['ticket_type'] === 'ticket' ? 'selected' : '' ?>>Ticket (kostenpflichtig)</option>
          <option value="reserve" <?= $event['ticket_type'] === 'reserve' ? 'selected' : '' ?>>Reservierung</option>
        </select>
      </div>
      <div class="field">
        <label for="price">Preis (€) — leer bei Free</label>
        <input type="number" id="price" name="price" value="<?= $event['price'] ? h($event['price']) : '' ?>" step="0.01" placeholder="89.00">
      </div>
    </div>

    <!-- Beschreibung -->
    <div class="form-row s1">
      <div class="field">
        <label for="description">Beschreibung</label>
        <textarea id="description" name="description" placeholder="Was erwartet die Gäste?"><?= h($event['description']) ?></textarea>
      </div>
    </div>

    <!-- Foto -->
    <div class="form-row s1">
      <div class="field">
        <label>Event-Foto</label>
        <div class="upload-zone">
          <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" onchange="previewImg(this)">
          <p>📷 <span>Foto auswählen</span> oder hierhin ziehen</p>
          <p style="font-size:0.6rem;color:var(--ink-mute);margin-top:0.3rem;">JPG, PNG oder WebP · max. 10 MB · wird auf 1200px skaliert</p>
        </div>
        <?php if (!empty($event['photo'])): ?>
          <img src="../<?= h($event['photo']) ?>" class="upload-preview" id="preview" alt="Event-Foto">
        <?php else: ?>
          <img src="" class="upload-preview" id="preview" alt="" style="display:none;">
        <?php endif; ?>
      </div>
    </div>

    <!-- Aktiv + PNR -->
    <div class="form-row">
      <div class="field">
        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" <?= $event['is_active'] ? 'checked' : '' ?> style="width:auto;">
          Event ist aktiv / sichtbar
        </label>
      </div>
      <div class="field">
        <label>PNR-Code (automatisch)</label>
        <input type="text" value="<?= h($event['pnr_code'] ?: generatePNR($event['event_date'])) ?>" disabled style="color:var(--ink-mute);">
      </div>
    </div>

    <div style="margin-top:1.5rem;">
      <button type="submit" class="btn-submit"><?= $isEdit ? 'Änderungen speichern' : 'Event erstellen' ?> →</button>
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
