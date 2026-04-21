<?php
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        // Foto löschen
        $event = dbRow("SELECT photo FROM events WHERE id = ?", [$id]);
        if ($event && $event['photo'] && file_exists(__DIR__ . '/../' . $event['photo'])) {
            unlink(__DIR__ . '/../' . $event['photo']);
        }
        dbExec("DELETE FROM events WHERE id = ?", [$id]);
        flash('success', 'Event gelöscht.');
    }
}
redirect('events.php');
