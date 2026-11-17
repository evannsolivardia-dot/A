# Plataforma audiovisual corporativa

Primera versión funcional de un sitio web corporativo para una empresa de servicios audiovisuales.

## Tecnologías
- PHP 8.1+
- MySQL 8+
- HTML, CSS y JavaScript
- Diseño adaptable a móviles y escritorio

## Incluye
- Sitio público: inicio, equipos, servicios, eventos, clientes y contacto.
- Catálogo de equipos con fichas técnicas.
- Formulario de solicitud de cotización.
- Panel administrativo protegido por inicio de sesión.
- Gestión básica de equipos, servicios, eventos, clientes y solicitudes.
- Carga de imágenes para equipos y eventos.

## Instalación local (XAMPP)
1. Copia la carpeta `plataforma_audiovisual` dentro de `htdocs`.
2. Inicia Apache y MySQL desde XAMPP.
3. Abre phpMyAdmin e importa `database.sql`.
4. Edita `config.php` y coloca los datos de conexión de MySQL.
5. Abre `http://localhost/plataforma_audiovisual/setup.php`.
6. Crea el primer usuario administrador.
7. Después de crear el administrador, elimina `setup.php` del servidor.
8. Abre `http://localhost/plataforma_audiovisual/`.

## Acceso administrativo
- URL: `/admin/login.php`
- El primer usuario y contraseña se crean desde `setup.php`.

## Personalización pendiente
- Cambiar “NOMBRE DE LA EMPRESA” por el nombre real.
- Añadir el logotipo, teléfonos, correo y ubicación reales.
- Reemplazar los ejemplos de equipos, servicios y clientes por información verificada.
- Subir fotografías y videos autorizados de los eventos reales.

## Seguridad antes de publicar
- Cambia las credenciales de la base de datos.
- Usa HTTPS.
- Elimina `setup.php` después de crear el administrador.
- Configura permisos de escritura únicamente para `uploads/`.
- Haz copias de seguridad de la base de datos y de `uploads/`.
- Revisa límites de tamaño y tipos de archivos según el hosting.
