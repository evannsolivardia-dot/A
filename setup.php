<?php
require_once __DIR__ . '/config.php';
$count = (int) db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
$message = '';
if ($count > 0) {
    $message = 'Ya existe un administrador. Por seguridad, elimina setup.php.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 10) {
        $stmt = db()->prepare('INSERT INTO admins (name,email,password_hash) VALUES (?,?,?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        $message = 'Administrador creado. Elimina setup.php y entra desde /admin/login.php.';
    } else {
        $message = 'Completa los campos y usa una contraseña de al menos 10 caracteres.';
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Configuración inicial</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="admin-body"><main class="login-card"><a class="brand" href="index.php">AV<span>PRO</span></a><h1>Crear administrador</h1>
<?php if ($message): ?><p class="notice"><?=e($message)?></p><?php endif; ?>
<?php if ($count === 0 && !str_contains($message, 'creado')): ?>
<form method="post" class="form-stack"><label>Nombre<input name="name" required></label><label>Correo<input type="email" name="email" required></label><label>Contraseña (mínimo 10 caracteres)<input type="password" name="password" minlength="10" required></label><button class="btn btn-primary">Crear administrador</button></form>
<?php endif; ?></main></body></html>
