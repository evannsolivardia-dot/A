<?php
require_once __DIR__ . '/../config.php'; require_admin();
$type = $_GET['type'] ?? 'equipment';
$allowed = ['equipment','services','events','clients','quotes'];
if (!in_array($type, $allowed, true)) $type = 'equipment';
$labels = ['equipment'=>'Equipos','services'=>'Servicios','events'=>'Eventos','clients'=>'Clientes','quotes'=>'Cotizaciones'];
$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update_status']) && $type === 'quotes') {
            $stmt = db()->prepare('UPDATE quotes SET status=? WHERE id=?');
            $stmt->execute([$_POST['status'], (int)$_POST['id']]); $notice = 'Estado actualizado.';
        } elseif (isset($_POST['delete_id']) && $type !== 'quotes') {
            $stmt = db()->prepare("DELETE FROM $type WHERE id=?"); $stmt->execute([(int)$_POST['delete_id']]); $notice = 'Registro eliminado.';
        } elseif (isset($_POST['save'])) {
            if ($type === 'equipment') {
                $img = upload_image('image','equipment');
                $stmt = db()->prepare('INSERT INTO equipment (name,brand,model,category,short_description,specifications,image) VALUES (?,?,?,?,?,?,?)');
                $stmt->execute([trim($_POST['name']),trim($_POST['brand']),trim($_POST['model']),trim($_POST['category']),trim($_POST['short_description']),trim($_POST['specifications']),$img]);
            } elseif ($type === 'services') {
                $stmt = db()->prepare('INSERT INTO services (title,description,icon) VALUES (?,?,?)');
                $stmt->execute([trim($_POST['title']),trim($_POST['description']),trim($_POST['icon'])]);
            } elseif ($type === 'events') {
                $img = upload_image('image','event');
                $stmt = db()->prepare('INSERT INTO events (title,event_date,location,description,image,video_url) VALUES (?,?,?,?,?,?)');
                $stmt->execute([trim($_POST['title']),($_POST['event_date'] ?: null),trim($_POST['location']),trim($_POST['description']),$img,trim($_POST['video_url'])]);
            } elseif ($type === 'clients') {
                $img = upload_image('image','client');
                $stmt = db()->prepare('INSERT INTO clients (name,sector,description,logo) VALUES (?,?,?,?)');
                $stmt->execute([trim($_POST['name']),trim($_POST['sector']),trim($_POST['description']),$img]);
            }
            $notice = 'Registro agregado correctamente.';
        }
    } catch (Throwable $ex) { $notice = 'No se pudo completar la operación: ' . $ex->getMessage(); }
}
$rows = db()->query("SELECT * FROM $type ORDER BY id DESC")->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($labels[$type])?> · Administración</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="dashboard-body">
<aside class="admin-sidebar"><a class="brand" href="../index.php">AV<span>PRO</span></a><p>ADMINISTRACIÓN</p><a href="dashboard.php">▦ Resumen</a><a class="<?=$type==='equipment'?'selected':''?>" href="?type=equipment">◈ Equipos</a><a class="<?=$type==='services'?'selected':''?>" href="?type=services">✳ Servicios</a><a class="<?=$type==='events'?'selected':''?>" href="?type=events">▣ Eventos</a><a class="<?=$type==='clients'?'selected':''?>" href="?type=clients">◎ Clientes</a><a class="<?=$type==='quotes'?'selected':''?>" href="?type=quotes">✉ Cotizaciones</a><a href="logout.php">↪ Cerrar sesión</a></aside>
<main class="admin-main"><div class="admin-top"><div><div class="section-kicker">GESTIÓN DE CONTENIDO</div><h1><?=e($labels[$type])?></h1><p>Agrega información y mantén actualizado el sitio.</p></div><a class="btn btn-ghost" href="../index.php" target="_blank">Ver sitio ↗</a></div>
<?php if($notice): ?><p class="notice"><?=e($notice)?></p><?php endif; ?>
<?php if($type !== 'quotes'): ?><section class="admin-panel"><h2>Agregar <?=e(strtolower(rtrim($labels[$type],'s')))?></h2><form method="post" enctype="multipart/form-data" class="admin-form">
<?php if($type==='equipment'): ?><label>Nombre<input name="name" required></label><label>Marca<input name="brand"></label><label>Modelo<input name="model"></label><label>Categoría<input name="category" placeholder="Sonido, Iluminación, Video..." required></label><label class="wide">Descripción breve<input name="short_description"></label><label class="wide">Especificaciones técnicas<textarea name="specifications" rows="4" placeholder="Potencia:\nRespuesta de frecuencia:\nConectividad:"></textarea></label><label>Imagen JPG, PNG o WEBP<input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
<?php elseif($type==='services'): ?><label>Título<input name="title" required></label><label>Icono (nombre interno)<input name="icon" value="audio-lines"></label><label class="wide">Descripción<textarea name="description" rows="3"></textarea></label>
<?php elseif($type==='events'): ?><label>Nombre del evento<input name="title" required></label><label>Fecha<input type="date" name="event_date"></label><label>Ubicación<input name="location"></label><label>Enlace de video<input name="video_url" placeholder="https://..."></label><label class="wide">Descripción<textarea name="description" rows="3"></textarea></label><label>Fotografía principal<input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
<?php else: ?><label>Nombre del cliente<input name="name" required></label><label>Sector<input name="sector" placeholder="Corporativo, institucional..."></label><label class="wide">Descripción<textarea name="description" rows="3"></textarea></label><label>Logo / imagen<input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label><?php endif; ?>
<button class="btn btn-primary" name="save" value="1">Guardar registro</button></form></section><?php endif; ?>
<section class="admin-panel"><div class="panel-heading"><h2><?=count($rows)?> registro(s)</h2></div><div class="table-wrap"><table><thead><tr><?php if($type==='quotes'): ?><th>Contacto</th><th>Evento</th><th>Servicios</th><th>Detalles</th><th>Estado</th><th>Actualizar</th><?php else: ?><th>Nombre</th><th>Información</th><th>Fecha</th><th>Acción</th><?php endif; ?></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><?php if($type==='quotes'): ?><td><b><?=e($r['contact_name'])?></b><small><?=e($r['email'])?> · <?=e($r['phone'])?></small><small><?=e($r['organization'])?></small></td><td><?=e($r['event_type'])?><small><?=e($r['event_date'])?> · <?=e($r['location'])?></small></td><td><?=e($r['services'])?></td><td><?=e($r['details'])?></td><td><span class="status"><?=e($r['status'])?></span></td><td><form method="post" class="inline-form"><input type="hidden" name="id" value="<?=$r['id']?>"><select name="status"><?php foreach(['Nueva','En revisión','Cotizada','Cerrada'] as $st): ?><option <?=$r['status']===$st?'selected':''?>><?=$st?></option><?php endforeach; ?></select><button name="update_status" value="1" class="mini-btn">Guardar</button></form></td>
<?php else: ?><td><b><?=e($r['name'] ?? $r['title'])?></b></td><td><?=e($r['category'] ?? $r['sector'] ?? $r['description'] ?? '')?></td><td><?=e($r['created_at'])?></td><td><form method="post" onsubmit="return confirm('¿Eliminar este registro?')"><input type="hidden" name="delete_id" value="<?=$r['id']?>"><button class="mini-btn danger">Eliminar</button></form></td><?php endif; ?></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="6">No hay registros todavía.</td></tr><?php endif; ?></tbody></table></div></section>
</main></body></html>
