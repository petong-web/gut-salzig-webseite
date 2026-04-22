<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $row = dbRow("SELECT photo FROM brunch WHERE id = ?", [$id]);
        if ($row && $row['photo'] && file_exists(__DIR__ . '/../' . $row['photo'])) {
            unlink(__DIR__ . '/../' . $row['photo']);
        }
        dbExec("DELETE FROM brunch WHERE id = ?", [$id]);
        flash('success', 'Brunch gelöscht.');
    }
}
redirect('brunch.php');
