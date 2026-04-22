<?php
require_once __DIR__ . '/auth.php';
$page = 'brunch';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$record = ['week_date'=>date('Y-m-d',strtotime('next sunday')),'eyebrow'=>'','intro'=>'','menu_items'=>'[]','photo'=>'','price'=>29.00,'is_active'=>1];
if ($isEdit) { $record = dbRow("SELECT * FROM brunch WHERE id = ?", [$id]); if (!$record) { flash('error','Nicht gefunden.'); redirect('brunch.php'); } }
$menuText = implode("\n", json_decode($record['menu_items'] ?? '[]', true) ?: []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $record['week_date']  = $_POST['week_date'] ?? date('Y-m-d');
    $record['eyebrow']    = trim($_POST['eyebrow'] ?? '');
    $record['intro']      = trim($_POST['intro'] ?? '');
    $record['price']      = (float)($_POST['price'] ?? 29);
    $record['is_active']  = isset($_POST['is_active']) ? 1 : 0;
    $lines = array_filter(array_map('trim', explode("\n", $_POST['menu_items'] ?? '')));
    $record['menu_items'] = json_encode(array_values($lines), JSON_UNESCAPED_UNICODE);
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) { $p = uploadImage($_FILES['photo'], 'brunch'); if ($p) $record['photo'] = $p; }

    if ($isEdit) {
        dbExec("UPDATE brunch SET week_date=?,eyebrow=?,intro=?,menu_items=?,photo=?,price=?,is_active=? WHERE id=?",
            [$record['week_date'],$record['eyebrow'],$record['intro'],$record['menu_items'],$record['photo'],$record['price'],$record['is_active'],$id]);
        flash('success','Brunch aktualisiert.');
    } else {
        dbInsert("INSERT INTO brunch (week_date,eyebrow,intro,menu_items,photo,price,is_active) VALUES (?,?,?,?,?,?,?)",
            [$record['week_date'],$record['eyebrow'],$record['intro'],$record['menu_items'],$record['photo'],$record['price'],$record['is_active']]);
        flash('success','Brunch erstellt.');
    }
    redirect('brunch.php');
}
?>
<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Brunch — gut salzig Admin</title>
<link rel="icon" type="image/svg+xml" href="../prototype/assets/logo/icon-blk.svg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;1,9..144,300&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head><body><div class="admin-wrap"><?php require __DIR__.'/sidebar.php'; ?>
<main class="main"><?= renderFlash() ?>
  <div class="topbar"><div><a href="brunch.php" class="btn-back">← Zurück</a><h1>☀ Brunch <em><?= $isEdit?'bearbeiten':'erstellen' ?></em></h1></div></div>
  <form method="post" enctype="multipart/form-data" style="background:var(--surface);border:1px solid var(--line);padding:2rem;">
    <?= csrfField() ?>
    <div class="form-row"><div class="field"><label>Sonntag (Datum)</label><input type="date" name="week_date" value="<?= h($record['week_date']) ?>" required></div>
    <div class="field"><label>Preis pro Person (€)</label><input type="number" name="price" value="<?= h($record['price']) ?>" step="0.50"></div></div>
    <div class="form-row s1"><div class="field"><label>Eyebrow / Untertitel</label><input type="text" name="eyebrow" value="<?= h($record['eyebrow']) ?>" placeholder="Sonntag, 19. April 2026"></div></div>
    <div class="form-row s1"><div class="field"><label>Einleitung</label><textarea name="intro" style="min-height:80px;"><?= h($record['intro']) ?></textarea></div></div>
    <div class="form-row s1"><div class="field"><label>Menü-Gerichte (ein Gericht pro Zeile)</label>
    <textarea name="menu_items" style="min-height:200px;" placeholder="Hausgeräucherter Lachs mit Dill&#10;Pochierte Eier auf Spinat&#10;Nordsee-Krabben auf Rührei"><?= h($menuText) ?></textarea></div></div>
    <div class="form-row s1"><div class="field"><label>Brunch-Foto</label>
    <div class="upload-zone"><input type="file" name="photo" accept="image/*" onchange="previewImg(this)"><p>📷 <span>Foto auswählen</span></p></div>
    <?php if(!empty($record['photo'])): ?><img src="../<?= h($record['photo']) ?>" class="upload-preview" id="preview"><?php else: ?><img class="upload-preview" id="preview" style="display:none;"><?php endif; ?></div></div>
    <div class="form-row"><div class="field"><label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;"><input type="checkbox" name="is_active" value="1" <?= $record['is_active']?'checked':'' ?> style="width:auto;"> Aktiv</label></div></div>
    <button type="submit" class="btn-submit" style="margin-top:1.5rem;"><?= $isEdit?'Speichern':'Erstellen' ?> →</button>
  </form>
</main></div>
<script>function previewImg(i){const p=document.getElementById('preview');if(i.files&&i.files[0]){const r=new FileReader();r.onload=e=>{p.src=e.target.result;p.style.display='block';};r.readAsDataURL(i.files[0]);}}</script>
</body></html>
