<?php
/**
 * gut salzig — Shared Helper Functions
 */

// ── HTML Escaping ──────────────────────────────────────────
function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// ── CSRF Protection ────────────────────────────────────────
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="_csrf" value="' . csrfToken() . '">';
}

function csrfCheck(): void
{
    $token = $_POST['_csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Ungueltige Anfrage (CSRF). Bitte Seite neu laden.');
    }
}

// ── Flash Messages ─────────────────────────────────────────
function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function renderFlash(): string
{
    if (empty($_SESSION['flash'])) return '';
    $html = '';
    foreach ($_SESSION['flash'] as $f) {
        $cls = $f['type'] === 'error' ? 'flash--error' : 'flash--success';
        $html .= '<div class="flash ' . $cls . '">' . h($f['message']) . '</div>';
    }
    $_SESSION['flash'] = [];
    return $html;
}

// ── Slug ───────────────────────────────────────────────────
function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    $text = str_replace(
        ['ä','ö','ü','ß','é','è','ê','à','â'],
        ['ae','oe','ue','ss','e','e','e','a','a'],
        $text
    );
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// ── Image Upload + Resize (GD) ─────────────────────────────
function uploadImage(array $file, string $category, int $maxWidth = 1200, int $quality = 80): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > MAX_UPLOAD_SIZE) {
        return null;
    }

    $mime = mime_content_type($file['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($mime, $allowed)) {
        return null;
    }

    // Load image
    switch ($mime) {
        case 'image/jpeg': $src = imagecreatefromjpeg($file['tmp_name']); break;
        case 'image/png':  $src = imagecreatefrompng($file['tmp_name']); break;
        case 'image/webp': $src = imagecreatefromwebp($file['tmp_name']); break;
        default: return null;
    }
    if (!$src) return null;

    // Resize if wider than maxWidth
    $origW = imagesx($src);
    $origH = imagesy($src);
    if ($origW > $maxWidth) {
        $newH = (int) ($origH * ($maxWidth / $origW));
        $dst = imagecreatetruecolor($maxWidth, $newH);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $maxWidth, $newH, $origW, $origH);
        imagedestroy($src);
        $src = $dst;
    }

    // Save as JPEG
    $dir = UPLOAD_DIR . '/' . $category;
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $filename = time() . '-' . bin2hex(random_bytes(4)) . '.jpg';
    $path = $dir . '/' . $filename;

    imagejpeg($src, $path, $quality);
    imagedestroy($src);

    return 'uploads/' . $category . '/' . $filename;
}

// ── Redirect ───────────────────────────────────────────────
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// ── Date Helpers ───────────────────────────────────────────
function formatDate(string $date, string $format = 'd. M Y'): string
{
    $months = [
        'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mrz', 'Apr' => 'Apr',
        'May' => 'Mai', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Aug',
        'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Dez'
    ];
    $formatted = date($format, strtotime($date));
    return str_replace(array_keys($months), array_values($months), $formatted);
}

function formatTime(string $time): string
{
    return date('H:i', strtotime($time));
}

// ── PNR Code Generator ────────────────────────────────────
function generatePNR(string $date): string
{
    return 'GS' . date('dmy', strtotime($date));
}
