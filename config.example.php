<?php
/**
 * gut salzig — Konfiguration
 * Kopiere diese Datei zu config.php und passe die Werte an.
 */

// Datenbank
define('DB_HOST', 'localhost');
define('DB_NAME', 'gutsalzig');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Pfade
define('BASE_URL', 'http://localhost:8081');   // ohne trailing slash
define('UPLOAD_DIR', __DIR__ . '/uploads');
define('UPLOAD_URL', BASE_URL . '/uploads');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024);  // 10 MB

// Admin
define('ADMIN_SESSION_NAME', 'gs_admin');
define('SITE_NAME', 'gut salzig');

// E-Mail (für Formular-Benachrichtigungen)
define('MAIL_TO_CONTACT', 'flaschenpost@gut-salzig.de');
define('MAIL_TO_JOBS', 'jobs@gut-salzig.de');
define('MAIL_FROM', 'noreply@gut-salzig.de');

// Zeitzone
date_default_timezone_set('Europe/Berlin');
