<?php
/**
 * gut salzig Admin — Auth Guard
 * Am Anfang jeder Admin-Seite einbinden.
 */
session_start();

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../functions.php';

if (!isset($_SESSION[ADMIN_SESSION_NAME])) {
    redirect('login.php');
}

$adminUser = $_SESSION[ADMIN_SESSION_NAME]['username'] ?? 'Admin';
