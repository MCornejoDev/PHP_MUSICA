CREATE DATABASE IF NOT EXISTS music CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE music;

CREATE TABLE IF NOT EXISTS usuarios(
id INT(255) NOT NULL AUTO_INCREMENT,
nombre_usuario VARCHAR(100) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
nombre VARCHAR(100) NOT NULL,
apellidos VARCHAR(255) NOT NULL,
rol VARCHAR(20) NOT NULL,
imagen VARCHAR(255) NOT NULL,
direccion VARCHAR(255) NOT NULL,
CONSTRAINT pk_usuarios PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS categorias(
id INT(255) NOT NULL AUTO_INCREMENT,
nombre VARCHAR(50) NOT NULL,
CONSTRAINT pk_categorias PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS discos(
id INT(255) NOT NULL AUTO_INCREMENT,
categoria_id INT(255) NOT NULL,
titulo VARCHAR(50) NOT NULL,
artista VARCHAR(100) NOT NULL,
descripcion TEXT NOT NULL,
stock INT(255) NOT NULL,
precio DECIMAL(10,2) NOT NULL,
fecha DATE NOT NULL,
imagen VARCHAR(255) NOT NULL,
CONSTRAINT pk_discos PRIMARY KEY(id),
CONSTRAINT fk_discos FOREIGN KEY(categoria_id) REFERENCES categorias(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS singles(
id INT(255) NOT NULL AUTO_INCREMENT,
disco_id INT(255) NOT NULL,
titulo VARCHAR(255) NOT NULL,
duracion VARCHAR(255) NOT NULL,
archivo_musical VARCHAR(255) NOT NULL,
CONSTRAINT pk_singles PRIMARY KEY(id),
CONSTRAINT fk_singles FOREIGN KEY(disco_id) REFERENCES discos(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS pedidos(
id INT(255) NOT NULL AUTO_INCREMENT,
usuario_id INT(255) NOT NULL,
estado BOOLEAN NOT NULL,
fecha DATE NOT NULL,
coste DOUBLE(2,2) NOT NULL,
CONSTRAINT pk_pedidos PRIMARY KEY(id),
CONSTRAINT fk_pedidos FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS lineas_pedidos(
id INT(255) NOT NULL AUTO_INCREMENT,
pedido_id INT(255) NOT NULL,
disco_id INT(255) NOT NULL,
unidades INT(255) NOT NULL,
CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
CONSTRAINT fk_lineas_pedidos FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
CONSTRAINT fk_lineas_discos FOREIGN KEY(disco_id) REFERENCES discos(id)
)ENGINE=InnoDb;