<?php
declare(strict_types=1);

define('DB_HOST', 'localhost');
define('DB_NAME', 'audiovisual_corp');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', '/plataforma_audiovisual');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function logged_in(): bool {
    return isset($_SESSION['admin_id']);
}

function require_admin(): void {
    if (!logged_in()) {
        header('Location: ' . BASE_URL . '/admin/login.php');
        exit;
    }
}

function upload_image(string $field, string $prefix = 'img'): ?string {
    if (empty($_FILES[$field]['name'])) return null;
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('No se pudo subir el archivo.');
    }
    if ($_FILES[$field]['size'] > 8 * 1024 * 1024) {
        throw new RuntimeException('El archivo supera el límite de 8 MB.');
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES[$field]['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Formato no permitido. Usa JPG, PNG o WEBP.');
    }
    $name = $prefix . '_' . bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], __DIR__ . '/uploads/' . $name)) {
        throw new RuntimeException('No se pudo guardar la imagen.');
    }
    return 'uploads/' . $name;
}
