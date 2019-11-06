<?php

/* 
 * Archivo de configuración del proyecto.
 *Copie este archivo a config.php y complete los datos de configuración.

 */
//error_reporting(E_ALL);
unset($CFG);  // Ignore this line
global $CFG;  // This is necessary here for PHPUnit execution
$CFG = new stdClass();

/*
 * Configuración de la base de datos 
 */

$CFG->dbtype    = 'mysql';      // 'pgsql', 'mariadb', 'mysqli', 'sqlsrv' or 'oci'
$CFG->dbhost    = 'localhost';  // eg 'localhost' or 'db.isp.com' or IP
$CFG->dbname    = 'Finanzas';     // database name, eg moodle
$CFG->dbuser    = 'user';   // your database username
$CFG->dbpassword    = 'password';   // your database password

/*
 * Ruta absoluta del proyecto
 */
$CFG->path = '/www/finanzas/';
/*
 
/*
 * Archivo para registrar los errores de log
 */
$CFG->errorFile = 'log/error_log';

/*
 * Definir si el ambiente es de desarrollo
 * Si $CFG->development = TRUE los mensajes que se presentarán en interfaz
 * serán los proporcionados por los mensajes de errores. Si el valor es falso
 * los mensajes que se mostrarán serán los indicados en el archivo de configuración
 * de idioma de los mensajes de error ($CFG->errorMessageFile)
 */
$CFG->development = FALSE;
/*
* Archivo de mensajes de errores 
 */
$CFG->errorMessageFile = 'language/errorMessage_es.php';

/*
 * JWT
 * Datos para el token
 * date_default_timezone_set: zona horaria en donde se encuentra el servidor
 * iss: emisor del token
 * aud: a qué audiencia está dirigido
 * iat: (iussed at) hora en que se emitió el token
 * nbf: (not before) hora antes de la cual no debe ser aceptado
 * exp: (expiratin time) expiración del token. Luego de este tiempo, ya no
 *  podrá ser utilizado 
 * 
 */

// set your default time-zone
date_default_timezone_set('America/Guayaquil');
 
// variables used for jwt
$CFG->key = "PASSWORD_KEY"; 
$CFG->iss = "http://localhost/finanzas";
$CFG->aud = "http://localhost/finanzas";
$CFG->iat = 1356999524;
$CFG->nbf = 1357000000;
