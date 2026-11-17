<?php
require_once __DIR__ . '/config.php';
$pageTitle = 'Equipos';
$category = trim($_GET['categoria'] ?? '');
$sql = 'SELECT * FROM equipment'; $params = [];
if ($category !== '') { $sql .= ' WHERE category = ?'; $params[] = $category; }
$sql .= ' ORDER BY category, name';
$stmt = db()->prepare($sql); $stmt->execute($params); $items = $stmt->fetchAll();
$categories = db()->query('SELECT DISTINCT category FROM equipment ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
include __DIR__ . '/includes/header.php';
?>
<main class="inner-page"><section class="page-hero"><div class="section-kicker">INVENTARIO TÉCNICO / 01</div><h1>Herramientas para<br><span>producir a otro nivel.</span></h1><p>Conoce parte de nuestro inventario audiovisual y consulta las características de cada equipo.</p></section>
<section class="section"><div class="filter-row"><a class="filter-chip <?=!$category?'active':''?>" href="equipos.php">Todos</a><?php foreach($categories as $cat): ?><a class="filter-chip <?=$category===$cat?'active':''?>" href="?categoria=<?=urlencode($cat)?>"><?=e($cat)?></a><?php endforeach; ?></div>
<div class="catalog-grid"><?php if(!$items): ?><div class="empty-state">Aún no hay equipos publicados. El inventario se actualizará desde el panel administrativo.</div><?php endif; ?>
<?php foreach($items as $item): ?><article class="equipment-card"><?php if($item['image']): ?><img src="<?=e($item['image'])?>" alt="<?=e($item['name'])?>"><?php else: ?><div class="equipment-placeholder">EQUIPMENT / <?=e(strtoupper($item['category']))?></div><?php endif; ?><div class="equipment-info"><span class="category-label"><?=e($item['category'])?></span><h3><?=e($item['name'])?></h3><p class="muted"><?=e($item['brand'])?> <?=e($item['model'])?></p><p><?=e($item['short_description'])?></p><details><summary>Ver especificaciones técnicas</summary><p class="spec-text"><?=nl2br(e($item['specifications']))?></p></details><a class="text-link" href="cotizar.php?equipo=<?=urlencode($item['name'])?>">Consultar disponibilidad ↗</a></div></article><?php endforeach; ?></div></section></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
