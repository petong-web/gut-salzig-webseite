<?php
/**
 * gut salzig — Installer
 * Erstellt alle Datenbank-Tabellen und den Admin-User.
 * Einmal ausfuehren, dann loeschen oder umbenennen!
 *
 * Aufruf: php install.php (CLI) oder http://localhost/install.php (Browser)
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

$out = php_sapi_name() === 'cli' ? 'cli' : 'web';
function msg(string $text, string $mode = 'cli') {
    echo $mode === 'cli' ? "$text\n" : "<p>$text</p>";
}

if ($out === 'web') echo '<!doctype html><html><head><meta charset="utf-8"><title>gut salzig Installer</title></head><body style="font-family:monospace;padding:2rem;">';

msg("gut salzig — Datenbank-Setup", $out);
msg("================================", $out);

$pdo = db();

// ── Tabellen ────────────────────────────────────────────────

$tables = <<<'SQL'

CREATE TABLE IF NOT EXISTS users (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS brunch (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    week_date   DATE NOT NULL,
    eyebrow     VARCHAR(100) NOT NULL,
    intro       TEXT,
    menu_items  TEXT NOT NULL,
    photo       VARCHAR(255),
    price       DECIMAL(6,2) DEFAULT 29.00,
    is_active   TINYINT(1)   DEFAULT 1,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS events (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(150) NOT NULL,
    slug          VARCHAR(150) NOT NULL,
    iata_code     CHAR(3)      NOT NULL,
    event_date    DATE         NOT NULL,
    event_time    TIME         NOT NULL,
    event_end_date DATE       DEFAULT NULL,
    event_end_time TIME       DEFAULT NULL,
    category      VARCHAR(50)  NOT NULL,
    category_icon CHAR(5)      DEFAULT '♪',
    ticket_type   ENUM('free','ticket','reserve') NOT NULL DEFAULT 'free',
    price         DECIMAL(8,2) DEFAULT NULL,
    gate          VARCHAR(30)  DEFAULT 'Terr.',
    description   TEXT,
    photo         VARCHAR(255),
    pnr_code      VARCHAR(20),
    is_active     TINYINT(1)   DEFAULT 1,
    sort_order    INT          DEFAULT 0,
    created_at    DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (event_date),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tagesgerichte (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL,
    label       VARCHAR(50),
    code        VARCHAR(10),
    description VARCHAR(255) NOT NULL,
    price       DECIMAL(6,2) NOT NULL,
    photo       VARCHAR(255),
    is_active   TINYINT(1)   DEFAULT 1,
    sort_order  INT          DEFAULT 0,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS speisekarte (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category    ENUM('starter','fisch','fleisch','vegetarisch','dessert') NOT NULL,
    name        VARCHAR(200) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    price       DECIMAL(6,2) DEFAULT NULL,
    is_active   TINYINT(1)   DEFAULT 1,
    sort_order  INT          DEFAULT 0,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_cat (category, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS blog (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(200) NOT NULL,
    slug         VARCHAR(200) NOT NULL UNIQUE,
    body         TEXT         NOT NULL,
    author       VARCHAR(100) DEFAULT 'Captain',
    author_initial CHAR(2)   DEFAULT 'C.',
    coordinates  VARCHAR(30)  DEFAULT '54°26′N · 10°14′E',
    location     VARCHAR(50)  DEFAULT 'Stein',
    photo        VARCHAR(255),
    entry_number INT          DEFAULT 0,
    is_published TINYINT(1)   DEFAULT 0,
    published_at DATETIME,
    created_at   DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jobs (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(200) NOT NULL,
    department  VARCHAR(50)  NOT NULL,
    job_type    VARCHAR(50)  NOT NULL,
    description TEXT         NOT NULL,
    tasks       TEXT,
    photo       VARCHAR(255),
    meta_json   TEXT,
    job_code    VARCHAR(20),
    is_active   TINYINT(1)   DEFAULT 1,
    sort_order  INT          DEFAULT 0,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_messages (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(100) NOT NULL,
    email          VARCHAR(150) NOT NULL,
    phone          VARCHAR(30),
    occasion       VARCHAR(50),
    preferred_date DATE,
    message        TEXT,
    is_read        TINYINT(1)   DEFAULT 0,
    created_at     DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS bewerbungen (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vorname     VARCHAR(100) NOT NULL,
    nachname    VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL,
    phone       VARCHAR(30),
    stelle      VARCHAR(100),
    erfahrung   VARCHAR(100),
    wohnort     VARCHAR(100),
    verfuegbar  DATE,
    needs       VARCHAR(255),
    motivation  TEXT,
    is_read     TINYINT(1)   DEFAULT 0,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS newsletter (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100),
    email       VARCHAR(150) NOT NULL UNIQUE,
    topics      VARCHAR(255),
    is_active   TINYINT(1)   DEFAULT 1,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SQL;

// Execute each CREATE TABLE
foreach (explode(";\n", $tables) as $sql) {
    $sql = trim($sql);
    if (empty($sql) || $sql === '') continue;
    try {
        $pdo->exec($sql);
        // Extract table name for message
        if (preg_match('/CREATE TABLE IF NOT EXISTS (\w+)/', $sql, $m)) {
            msg("  ✓ Tabelle '{$m[1]}' erstellt/vorhanden", $out);
        }
    } catch (PDOException $e) {
        msg("  ✗ Fehler: " . $e->getMessage(), $out);
    }
}

// ── Admin-User ──────────────────────────────────────────────
msg("", $out);
msg("Admin-User anlegen...", $out);

$adminUser = 'admin';
$adminPass = 'gutsalzig2026';  // Bitte nach erstem Login aendern!

$exists = $pdo->query("SELECT COUNT(*) FROM users WHERE username = '$adminUser'")->fetchColumn();
if ($exists == 0) {
    $hash = password_hash($adminPass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$adminUser, $hash]);
    msg("  ✓ Admin-User erstellt: $adminUser / $adminPass", $out);
    msg("  ⚠ BITTE PASSWORT NACH ERSTEM LOGIN ÄNDERN!", $out);
} else {
    msg("  → Admin-User existiert bereits", $out);
}

msg("", $out);
msg("================================", $out);
msg("Installation abgeschlossen!", $out);
msg("Admin-Panel: " . BASE_URL . "/admin/", $out);
msg("", $out);
msg("⚠ DIESE DATEI NACH INSTALLATION LOESCHEN ODER UMBENENNEN!", $out);

if ($out === 'web') echo '</body></html>';
