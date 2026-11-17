<?php
require_once __DIR__ . '/config.php';
$pageTitle = 'Eventos';
$events = db()->query('SELECT * FROM events ORDER BY event_date DESC, id DESC')->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<main class="inner-page"><section class="page-hero"><div class="section-kicker">PORTAFOLIO / 02</div><h1>Momentos reales.<br><span>Producciones memorables.</span></h1><p>Una muestra de experiencias, escenarios y proyectos realizados por nuestro equipo.</p></section><section class="section"><div class="event-grid"><?php if(!$events): ?><div class="empty-state">El portafolio de eventos aparecerá aquí cuando se publiquen los primeros proyectos.</div><?php endif; ?><?php foreach($events as $ev): ?><article class="event-card"><?php if($ev['image']): ?><img src="<?=e($ev['image'])?>" alt="<?=e($ev['title'])?>"><?php else: ?><div class="project-placeholder">EVENTO / GALERÍA</div><?php endif; ?><div class="event-info"><span class="category-label"><?=e($ev['event_date'] ?: 'PRODUCCIÓN AUDIOVISUAL')?> · <?=e($ev['location'])?></span><h2><?=e($ev['title'])?></h2><p><?=e($ev['description'])?></p><?php if($ev['video_url']): ?><a class="text-link" target="_blank" rel="noopener" href="<?=e($ev['video_url'])?>">Ver video del evento ↗</a><?php endif; ?></div></article><?php endforeach; ?></div></section></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
