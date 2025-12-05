CREATE TABLE IF NOT EXISTS logindb (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'cliente') NOT NULL DEFAULT 'cliente'
);

CREATE TABLE IF NOT EXISTS papers (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Autores TEXT,
    Fecha DATE,
    Explicacion TEXT,
    Imagen VARCHAR(255),
    Archivo VARCHAR(255),
    Tipo VARCHAR(50),
    Borrado TINYINT(1) DEFAULT 0
);

CREATE TABLE IF NOT EXISTS acceso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    fecha DATETIME,
    login TINYINT(1),
    FOREIGN KEY (usuario_id) REFERENCES logindb(id)
);

CREATE TABLE IF NOT EXISTS descargas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paper_id INT,
    usuario_id INT,
    fecha DATETIME,
    FOREIGN KEY (paper_id) REFERENCES papers(ID),
    FOREIGN KEY (usuario_id) REFERENCES logindb(id)
);
