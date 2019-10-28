CREATE TABLE `empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_empresas` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registro de empresas y locales comerciales'