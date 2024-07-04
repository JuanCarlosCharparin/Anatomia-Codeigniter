USE basededatos;

CREATE TABLE `persona` (
    `id` int unsigned not null primary key auto_increment,
    `nombre` varchar(50),
    `apellido` VARCHAR(50)
    `estado_civil` BOOLEAN
    );