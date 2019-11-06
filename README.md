# finanzas
Finanzas personales PHP puro
Proyecto para ejemplos de implementaciones de PHP.

CONFIGURACIÓN BÁSICA:
1. Copiar el archivo config.example.php a config.php
2. En el archivo config.php se deberá configurar:

 CONFIGURACIÓN DE LA CONEXIÓN A LA BASE DE DATOS:
  $CFG->dbtype:  El manejador de base de datos puede ser: 'pgsql', 'mariadb', 'mysqli', 'sqlsrv' or 'oci'
  $CFG->dbhost:  La dirección del servidor. Para proyectos locales puede trabajar con  'localhost'
  $CFG->dbname:  El nombre de la base de datos.
  $CFG->dbuser:   El usuario de la base de datos.
  $CFG->dbpassword:   La contraseña del usuario de la base de datos.
  
 CONFIGURACIÓN DE LAS RUTAS ESTÁTICAS:
  $CFG->path: El directorio en la cual se encuentra el proyecto, En la mayoría de los casos deberá dejar el valor por defecto
    /www/finanzas.
  $CFG->url: La dirección url del proyecto. En la mayoría de los casos deberá dejar el valor por defecto:  'http://localhost/finanzas/'

 CONFIGURACIÓN DE LA CLAVE PARA EL TOKEN JWT
  $CFG->key: Registre una clave segura para la generación del token de sesión. 
