<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        dbExec("DELETE FROM speisekarte WHERE id = ?", [$id]);
        flash('success', 'Menü-Eintrag gelöscht.');
    }
}
redirect('speisekarte.php');
