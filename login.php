<?php
require_once __DIR__ . '/../config.php';
if (logged_in()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('SELECT * FROM admins WHERE email = ?');
    $stmt->execute([trim($_POST['email'] ?? '')]); $admin = $stmt->fetch();
    if ($admin && password_verify($_POST['password'] ?? '', $admin['password_hash'])) {
        session_regenerate_id(true); $_SESSION['admin_id'] = $admin['id']; $_SESSION['admin_name'] = $admin['name'];
        header('Location: dashboard.php'); exit;
    } else { $error = 'Correo o contraseña incorrectos.'; }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acceso administrativo</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="admin-body"><main class="login-card"><a class="brand" href="../index.php">AV<span>PRO</span></a><div class="section-kicker">ÁREA PRIVADA</div><h1>Panel administrativo</h1><p>Ingresa con tus credenciales para administrar el sitio.</p><?php if($error): ?><p class="notice error"><?=e($error)?></p><?php endif; ?><form method="post" class="form-stack"><label>Correo electrónico<input type="email" name="email" required></label><label>Contraseña<input type="password" name="password" required></label><button class="btn btn-primary">Iniciar sesión</button></form><a class="back-link" href="../index.php">← Volver al sitio</a></main></body></html>
