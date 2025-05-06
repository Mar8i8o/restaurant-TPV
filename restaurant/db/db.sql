CREATE TABLE `Tipo_usuario` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `rol` VARCHAR(255)
);

CREATE TABLE `Tipo_unidad` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `unidad` VARCHAR(255)
);

CREATE TABLE `Tipo_moneda` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `Moneda` VARCHAR(50),
  `Simbolo` char
);

CREATE TABLE `Usuario` (
  `usuario_id` INT PRIMARY KEY AUTO_INCREMENT,
  `restaurante_id` INT,
  `password` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(255),
  `direccion` VARCHAR(255),
  `contacto` VARCHAR(255),
  `tipo_usuario_id` INT
);

CREATE TABLE `log` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `restaurante_id` int,
  `timeStamp` timestamp,
  `tipo_accion` int,
  `tipo_tabla` int,
  `registro_id` int,
  `cantidad` int,
  `comentario` varchar(255)
);

CREATE TABLE `Tipo_accion` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `accion` varchar(255)
);

CREATE TABLE `Tipo_tabla` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tabla` varchar(255)
);

CREATE TABLE `Elaborado` (
  `elaborado_id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(255),
  `descripcion` VARCHAR(2550)
);

CREATE TABLE `Ingrediente` (
  `ingrediente_id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(255)
);

CREATE TABLE `Stock` (
  `restaurante_id` INT,
  `elaborado_id` INT,
  `ingrediente_id` INT,
  `cantidad_stock` INT,
  `unidad` INT,
  `precio` DECIMAL(10,2),
  `moneda` INT
);

CREATE TABLE `Receta` (
  `restaurante_id` INT,
  `receta_id` INT PRIMARY KEY AUTO_INCREMENT,
  `elaborado_id` INT,
  `nombre` VARCHAR(255),
  `descripcion` VARCHAR(2550),
  `cantidad_producida` int,
  `cantidad_producida_unidad` int
);

CREATE TABLE `Receta_Ingrediente` (
  `receta_id` INT,
  `ingrediente_id` INT,
  `cantidad` DECIMAL(10,2),
  `unidad` INT
);

CREATE TABLE `Restaurante` (
  `restaurante_id` INT PRIMARY KEY AUTO_INCREMENT,
  `CIF` VARCHAR(255) NOT NULL,
  `Dirección` VARCHAR(255)
);

ALTER TABLE `Usuario` ADD FOREIGN KEY (`restaurante_id`) REFERENCES `Restaurante` (`restaurante_id`);

ALTER TABLE `log` ADD FOREIGN KEY (`restaurante_id`) REFERENCES `Restaurante` (`restaurante_id`);

ALTER TABLE `log` ADD FOREIGN KEY (`tipo_accion`) REFERENCES `Tipo_accion` (`id`);

ALTER TABLE `log` ADD FOREIGN KEY (`tipo_tabla`) REFERENCES `Tipo_tabla` (`id`);

ALTER TABLE `Stock` ADD FOREIGN KEY (`moneda`) REFERENCES `Tipo_moneda` (`id`);

ALTER TABLE `Stock` ADD FOREIGN KEY (`unidad`) REFERENCES `Tipo_unidad` (`id`);

ALTER TABLE `Receta` ADD FOREIGN KEY (`cantidad_producida_unidad`) REFERENCES `Tipo_unidad` (`id`);

ALTER TABLE `Receta_Ingrediente` ADD FOREIGN KEY (`unidad`) REFERENCES `Tipo_unidad` (`id`);

ALTER TABLE `Usuario` ADD FOREIGN KEY (`tipo_usuario_id`) REFERENCES `Tipo_usuario` (`id`);

ALTER TABLE `Stock` ADD FOREIGN KEY (`restaurante_id`) REFERENCES `Restaurante` (`restaurante_id`);

ALTER TABLE `Receta` ADD FOREIGN KEY (`restaurante_id`) REFERENCES `Restaurante` (`restaurante_id`);

ALTER TABLE `Stock` ADD FOREIGN KEY (`elaborado_id`) REFERENCES `Elaborado` (`elaborado_id`);

ALTER TABLE `Stock` ADD FOREIGN KEY (`ingrediente_id`) REFERENCES `Ingrediente` (`ingrediente_id`);

ALTER TABLE `Receta` ADD FOREIGN KEY (`elaborado_id`) REFERENCES `Elaborado` (`elaborado_id`);

ALTER TABLE `Receta_Ingrediente` ADD FOREIGN KEY (`receta_id`) REFERENCES `Receta` (`receta_id`);

ALTER TABLE `Receta_Ingrediente` ADD FOREIGN KEY (`ingrediente_id`) REFERENCES `Ingrediente` (`ingrediente_id`);


/* DATOS DE PRUEBA */

INSERT INTO `restaurante` (`restaurante_id`, `CIF`, `Dirección`) VALUES (NULL, 'Q1673095D', 'C/ de Manuel Melià i Fuster, 1'), (NULL, 'E99788119', 'C/ de Murillo, 22, Ciutat Vella, 46001 València, Valencia');
INSERT INTO `tipo_usuario` (`id`, `rol`) VALUES ('1', 'Gerente'), ('2', 'Cocinero');
/* Da error raro por la moneda de SAL */
INSERT INTO `tipo_moneda` (`id`, `Moneda`, `Simbolo`) VALUES (NULL, 'EUR', '€'), (NULL, 'DOL', '$'), (NULL, 'SAR', '﷼.'); 

INSERT INTO `tipo_unidad` (`id`, `unidad`) VALUES (NULL, 'Qty'), (NULL, 'kg'), (NULL, 'g'), (NULL, 'l'), (NULL, 'ml'), (NULL, 'lb');
INSERT INTO `tipo_tabla` (`id`, `tabla`) VALUES (NULL, 'Usuario'), (NULL, 'Stock'), (NULL, 'Ingrediente'), (NULL, 'Elaborado');
INSERT INTO `ingrediente` (`ingrediente_id`, `nombre`) VALUES (NULL, 'Salsa Boloñesa'), (NULL, 'Aceite'), (NULL, 'Queso Rallado'), (NULL, 'Champiñones en láminas'), (NULL, 'Carne picada vacuno'), (NULL, 'Cebolla'), (NULL, 'Albóndigas'), (NULL, 'Salsa bechamel'), (NULL, 'Salsa Pesto'), (NULL, 'Espaguetis'), (NULL, 'Macarrones'), (NULL, 'Salsa carbonara'), (NULL, 'Arroz'), (NULL, 'Masa de pizza'), (NULL, 'Huevos');
INSERT INTO `elaborado` (`elaborado_id`, `nombre`, `descripcion`) VALUES (NULL, 'Espaguetis Boloñesa', NULL);
INSERT INTO `elaborado` (`elaborado_id`, `nombre`, `descripcion`) VALUES (NULL, 'Macarrones al Pesto', NULL), (NULL, 'Espaguetis carbonara', NULL);
INSERT INTO `receta` (`restaurante_id`, `receta_id`, `elaborado_id`, `nombre`, `descripcion`, `cantidad_producida`, `cantidad_producida_unidad`) VALUES (NULL, NULL, '1', 'Espaguetis Boloñesa', '1. Hervir 80g de <a href=\"#\">[Espaguetis]</a> durante 12min <br> 2. Calentar <a href=\"#\">[Bolsa salsa boloñesa]</a> durante 2min <br> 3. Emplatar y agregar una pizca de <a href=\"#\">[Orégano]</a> <br> 4. Acompañar con <a href=\"#\">[Queso parmesano en polvo]</a>', '1', '1'), (NULL, NULL, '2', 'Macarrones al Pesto', '1. Hervir 80g de <a href=\"#\">[Macarrones]</a> durante 12min <br> 2. Una vez terminado añadir <a href=\"#\">[Salsa Pesto]</a> <br> 3. Emplatar y agregar una pizca de <a href=\"#\">[Orégano]</a> <br> 4. Acompañar con <a href=\"#\">[Queso parmesano en polvo]</a>', NULL, NULL);
INSERT INTO `receta_ingrediente` (`receta_id`, `ingrediente_id`, `cantidad`, `unidad`) VALUES ('1', '10', '75', '3'), ('1', '1', '50', '3'), ('2', '11', '75', '3'), ('2', '9', '20', '3');
INSERT INTO `stock` (`restaurante_id`, `elaborado_id`, `ingrediente_id`, `cantidad_stock`, `unidad`, `precio`, `moneda`) VALUES ('1', NULL, '11', '10', '2', NULL, NULL), ('1', NULL, '15', '24', '1', NULL, NULL), ('1', NULL, '7', '6', '1', NULL, NULL), ('1', '1', NULL, '5', '1', '12,5', '1'), ('1', '3', NULL, '15', '1', '12', '1');