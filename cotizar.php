<?php
require_once __DIR__ . '/config.php';
$pageTitle = 'Solicitar cotización';
$success = false; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['contact_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Escribe tu nombre y un correo electrónico válido.';
    } else {
        $date = trim($_POST['event_date'] ?? '');
        $date = $date !== '' ? $date : null;
        $attendees = ($_POST['attendees'] ?? '') !== '' ? (int)$_POST['attendees'] : null;
        $stmt = db()->prepare('INSERT INTO quotes (contact_name,organization,email,phone,event_type,event_date,location,attendees,services,details) VALUES (?,?,?,?,?,?,?,?,?,?)');
        $stmt->execute([$name, trim($_POST['organization'] ?? ''), $email, trim($_POST['phone'] ?? ''), trim($_POST['event_type'] ?? ''), $date, trim($_POST['location'] ?? ''), $attendees, implode(', ', $_POST['services'] ?? []), trim($_POST['details'] ?? '')]);
        $success = true;
    }
}
$equipment = trim($_GET['equipo'] ?? '');
include __DIR__ . '/includes/header.php';
?>
<main class="inner-page"><section class="page-hero"><div class="section-kicker">EMPECEMOS A PLANIFICAR / 04</div><h1>Cuéntanos tu idea.<br><span>Diseñemos la experiencia.</span></h1><p>Completa los datos y nuestro equipo podrá conocer las necesidades de tu evento para preparar una propuesta.</p></section><section class="section quote-layout"><div class="quote-aside"><div class="section-kicker">TU PROYECTO, NUESTRA EXPERIENCIA</div><h2>Un buen evento<br>empieza con una<br><span>buena conversación.</span></h2><p>Cuanta más información compartas, mejor podremos entender el alcance técnico de tu producción.</p><div class="contact-detail"><b>Correo</b><span>contacto@empresa.com</span></div><div class="contact-detail"><b>Atención</b><span>Por cita / coordinación previa</span></div></div>
<form method="post" class="quote-form">
<?php if($success): ?><div class="notice success">¡Solicitud recibida! Gracias por compartir los detalles de tu evento. El equipo podrá revisar tu solicitud desde el panel administrativo.</div><?php endif; ?>
<?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<div class="form-section-title">01 / Datos de contacto</div><div class="form-grid"><label>Nombre completo *<input name="contact_name" required></label><label>Empresa u organización<input name="organization"></label><label>Correo electrónico *<input type="email" name="email" required></label><label>Teléfono / WhatsApp<input name="phone"></label></div>
<div class="form-section-title">02 / Información del evento</div><div class="form-grid"><label>Tipo de evento<select name="event_type"><option value="">Selecciona una opción</option><option>Corporativo</option><option>Concierto / espectáculo</option><option>Institucional</option><option>Religioso</option><option>Social / celebración</option><option>Feria / exposición</option><option>Otro</option></select></label><label>Fecha del evento<input type="date" name="event_date"></label><label>Ubicación<input name="location" placeholder="Ciudad, lugar o recinto"></label><label>Cantidad aproximada de asistentes<input type="number" min="1" name="attendees"></label></div>
<div class="form-section-title">03 / Servicios que necesitas</div><div class="check-grid"><?php foreach(['Sonido profesional','Iluminación','Pantallas LED y video','Escenario y estructuras','Producción técnica','Alquiler de equipos','Otro / Asesoría'] as $s): ?><label class="check-option"><input type="checkbox" name="services[]" value="<?=e($s)?>"><span><?=e($s)?></span></label><?php endforeach; ?></div>
<label class="full-label">Cuéntanos más sobre tu evento<textarea name="details" rows="5" placeholder="Tipo de montaje, dimensiones del espacio, necesidades técnicas, horarios, presupuesto estimado u otra información..."><?=e($equipment ? 'Consulta relacionada con: '.$equipment : '')?></textarea></label>
<button class="btn btn-primary submit-btn">Enviar solicitud de cotización ↗</button><small class="form-note">Este formulario envía una solicitud; no confirma una reserva ni constituye una cotización definitiva.</small>
</form></section></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
