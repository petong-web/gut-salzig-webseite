<?php
require_once __DIR__ . '/auth.php';
$page = 'reviews';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$record = ['author_name'=>'','rating'=>5,'text'=>'','review_date'=>date('Y-m-d'),'source'=>'Google','is_active'=>1,'sort_order'=>0];
if ($isEdit) {
    $record = dbRow("SELECT * FROM reviews WHERE id = ?", [$id]);
    if (!$record) { flash('error','Nicht gefunden.'); redirect('reviews.php'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $record['author_name'] = trim($_POST['author_name'] ?? '');
    $record['rating']      = (int)($_POST['rating'] ?? 5);
    $record['text']        = trim($_POST['text'] ?? '');
    $record['review_date'] = $_POST['review_date'] ?: null;
    $record['source']      = trim($_POST['source'] ?? 'Google');
    $record['is_active']   = isset($_POST['is_active']) ? 1 : 0;
    $record['sort_order']  = (int)($_POST['sort_order'] ?? 0);

    $errors = [];
    if (empty($record['author_name'])) $errors[] = 'Autor ist erforderlich.';
    if (empty($record['text']))        $errors[] = 'Text ist erforderlich.';
    if ($record['rating'] < 1 || $record['rating'] > 5) $errors[] = 'Bewertung 1–5 Sterne.';

    if (empty($errors)) {
        if ($isEdit) {
            dbExec("UPDATE reviews SET author_name=?,rating=?,text=?,review_date=?,source=?,is_active=?,sort_order=? WHERE id=?",
                [$record['author_name'],$record['rating'],$record['text'],$record['review_date'],$record['source'],$record['is_active'],$record['sort_order'],$id]);
            flash('success','Bewertung aktualisiert.');
        } else {
            dbInsert("INSERT INTO reviews (author_name,rating,text,review_date,source,is_active,sort_order) VALUES (?,?,?,?,?,?,?)",
                [$record['author_name'],$record['rating'],$record['text'],$record['review_date'],$record['source'],$record['is_active'],$record['sort_order']]);
            flash('success','Bewertung erstellt.');
        }
        redirect('reviews.php');
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
<title>Bewertung bearbeiten — gut salzig Admin</title>
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
    <div><a href="reviews.php" class="btn-back">← Alle Bewertungen</a>
    <h1>★ Bewertung <em><?= $isEdit ? 'bearbeiten' : 'erstellen' ?></em></h1></div>
    <?php if ($isEdit): ?>
      <form method="post" action="review-delete.php" style="display:inline;" onsubmit="return confirm('Wirklich löschen?');">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="btn-delete">Löschen</button>
      </form>
    <?php endif; ?>
  </div>

  <form method="post" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>
    <div class="form-row">
      <div class="field"><label>Autor / Name</label><input type="text" name="author_name" value="<?= h($record['author_name']) ?>" placeholder="z.B. Julia K." required></div>
      <div class="field"><label>Bewertung (1–5 Sterne)</label>
        <select name="rating">
          <?php for ($i=5; $i>=1; $i--): ?>
            <option value="<?= $i ?>" <?= $record['rating']==$i?'selected':'' ?>><?= str_repeat('★', $i) ?> (<?= $i ?>)</option>
          <?php endfor; ?>
        </select>
      </div>
    </div>
    <div class="form-row s1">
      <div class="field"><label>Bewertungstext</label>
        <textarea name="text" style="min-height:160px;" required><?= h($record['text']) ?></textarea>
      </div>
    </div>
    <div class="form-row">
      <div class="field"><label>Bewertungsdatum</label><input type="date" name="review_date" value="<?= h($record['review_date'] ?? '') ?>"></div>
      <div class="field"><label>Quelle</label>
        <select name="source">
          <option value="Google" <?= $record['source']==='Google'?'selected':'' ?>>Google Bewertung</option>
          <option value="Tripadvisor" <?= $record['source']==='Tripadvisor'?'selected':'' ?>>Tripadvisor</option>
          <option value="Facebook" <?= $record['source']==='Facebook'?'selected':'' ?>>Facebook</option>
          <option value="Direkt" <?= $record['source']==='Direkt'?'selected':'' ?>>Direkte Rückmeldung</option>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="field"><label>Sortierreihenfolge</label><input type="number" name="sort_order" value="<?= h($record['sort_order']) ?>" placeholder="0"></div>
      <div class="field"><label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;"><input type="checkbox" name="is_active" value="1" <?= $record['is_active']?'checked':'' ?> style="width:auto;"> Aktiv / sichtbar</label></div>
    </div>
    <button type="submit" class="btn-submit" style="margin-top:1.5rem;"><?= $isEdit?'Speichern':'Erstellen' ?> →</button>
  </form>
</main>
</div>
</body>
</html>
