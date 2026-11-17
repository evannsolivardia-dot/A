<?php
require_once __DIR__ . '/config.php';
$pageTitle = 'Clientes';
$clients = db()->query('SELECT * FROM clients ORDER BY name')->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<main class="inner-page"><section class="page-hero"><div class="section-kicker">RELACIONES / 03</div><h1>La confianza también<br><span>es parte del resultado.</span></h1><p>Trabajamos con organizaciones, instituciones, productores y personas que confían en nuestras soluciones audiovisuales.</p></section><section class="section"><div class="client-grid"><?php if(!$clients): ?><div class="empty-state">Los clientes y sectores atendidos se mostrarán aquí cuando la empresa agregue sus referencias.</div><?php endif; ?><?php foreach($clients as $c): ?><article class="client-card"><?php if($c['logo']): ?><img src="<?=e($c['logo'])?>" alt="<?=e($c['name'])?>"><?php else: ?><div class="client-initial"><?=e(mb_substr($c['name'],0,1))?></div><?php endif; ?><h3><?=e($c['name'])?></h3><span><?=e($c['sector'])?></span><p><?=e($c['description'])?></p></article><?php endforeach; ?></div></section></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
