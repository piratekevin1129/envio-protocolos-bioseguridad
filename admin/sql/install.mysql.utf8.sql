DROP TABLE IF EXISTS #__envioprotocolosbioseguridad;
CREATE TABLE IF NOT EXISTS #__envioprotocolosbioseguridad(
    id INT NOT NULL AUTO_INCREMENT,
    tipo_documento VARCHAR(2) DEFAULT NULL,
    numero_documento BIGINT(20) DEFAULT NULL,
    nombre_comercial VARCHAR(500) DEFAULT NULL,
    nombre_legal VARCHAR(500) DEFAULT NULL,
    sector_economico INT(3) DEFAULT 0,
    departamento_residencia VARCHAR(100) DEFAULT NULL,
    ciudad_residencia VARCHAR(100) DEFAULT NULL,
    direccion_correspondencia VARCHAR(255) DEFAULT NULL,
    correo_electronico VARCHAR(255) DEFAULT NUll,
    numero_telefono BIGINT(20) DEFAULT NULL,
    archivo VARCHAR(255) DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;