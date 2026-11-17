CREATE DATABASE IF NOT EXISTS audiovisual_corp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE audiovisual_corp;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS equipment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(180) NOT NULL,
  brand VARCHAR(120) DEFAULT '',
  model VARCHAR(120) DEFAULT '',
  category VARCHAR(100) DEFAULT 'Sonido',
  short_description VARCHAR(255) DEFAULT '',
  specifications TEXT,
  image VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  description TEXT,
  icon VARCHAR(60) DEFAULT 'audio-lines',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  event_date DATE DEFAULT NULL,
  location VARCHAR(180) DEFAULT '',
  description TEXT,
  image VARCHAR(255) DEFAULT NULL,
  video_url VARCHAR(500) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS clients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(180) NOT NULL,
  sector VARCHAR(120) DEFAULT '',
  description TEXT,
  logo VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS quotes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  contact_name VARCHAR(160) NOT NULL,
  organization VARCHAR(180) DEFAULT '',
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(60) DEFAULT '',
  event_type VARCHAR(120) DEFAULT '',
  event_date DATE DEFAULT NULL,
  location VARCHAR(180) DEFAULT '',
  attendees INT DEFAULT NULL,
  services TEXT,
  details TEXT,
  status ENUM('Nueva','En revisión','Cotizada','Cerrada') DEFAULT 'Nueva',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO services (title, description, icon) VALUES
('Sonido profesional', 'Sistemas de audio, microfonía y operación técnica para eventos de distintos tamaños.', 'audio-lines'),
('Iluminación', 'Diseño y operación de iluminación escénica, arquitectónica y ambiental.', 'lightbulb'),
('Pantallas LED y video', 'Pantallas, procesamiento de video y soluciones visuales para escenarios y eventos.', 'monitor'),
('Escenarios y estructuras', 'Montaje de escenarios, truss y estructuras para producciones.', 'panels-top'),
('Producción de eventos', 'Planificación técnica, coordinación y ejecución de producciones audiovisuales.', 'clapperboard'),
('Alquiler de equipos', 'Soluciones de alquiler de equipos audiovisuales según las necesidades del evento.', 'package');
