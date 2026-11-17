<?php
require_once __DIR__ . '/../config.php'; require_admin();
$counts = [];
foreach (['equipment'=>'Equipos','services'=>'Servicios','events'=>'Eventos','clients'=>'Clientes','quotes'=>'Solicitudes'] as $table=>$label) $counts[$label] = (int)db()->query("SELECT COUNT(*) FROM $table")->fetchColumn();
$recent = db()->query('SELECT * FROM quotes ORDER BY created_at DESC LIMIT 6')->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Panel administrativo</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="dashboard-body">
<aside class="admin-sidebar"><a class="brand" href="../index.php">AV<span>PRO</span></a><p>ADMINISTRACIÓN</p><a class="selected" href="dashboard.php">▦ Resumen</a><a href="manage.php?type=equipment">◈ Equipos</a><a href="manage.php?type=services">✳ Servicios</a><a href="manage.php?type=events">▣ Eventos</a><a href="manage.php?type=clients">◎ Clientes</a><a href="manage.php?type=quotes">✉ Cotizaciones</a><a href="logout.php">↪ Cerrar sesión</a></aside>
<main class="admin-main"><div class="admin-top"><div><div class="section-kicker">CENTRO DE CONTROL</div><h1>Hola, <?=e($_SESSION['admin_name'])?>.</h1><p>Este es el resumen de actividad de tu sitio web.</p></div><a class="btn btn-ghost" href="../index.php" target="_blank">Ver sitio ↗</a></div>
<div class="admin-stats"><?php foreach($counts as $label=>$count): ?><div class="admin-stat"><span><?=e($label)?></span><strong><?=$count?></strong></div><?php endforeach; ?></div>
<section class="admin-panel"><div class="panel-heading"><h2>Solicitudes recientes</h2><a class="text-link" href="manage.php?type=quotes">Ver todas ↗</a></div><?php if(!$recent): ?><p class="muted">Todavía no hay solicitudes recibidas.</p><?php else: ?><div class="table-wrap"><table><thead><tr><th>Contacto</th><th>Evento</th><th>Fecha de solicitud</th><th>Estado</th></tr></thead><tbody><?php foreach($recent as $q): ?><tr><td><b><?=e($q['contact_name'])?></b><small><?=e($q['email'])?></small></td><td><?=e($q['event_type'])?></td><td><?=e($q['created_at'])?></td><td><span class="status"><?=e($q['status'])?></span></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></section>
</main></body></html>
