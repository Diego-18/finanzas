<?php

/* 
 * Personalización de mensajes en español cuando no se trabaja en Development
 */

function pathErrorMessage(Exception $e){
    
    switch ($e->getCode()){
        case 'HY000':
            return "Error general. Por favor contáctese con el Departamento de Informática.";
            
        case 'HY093':
            return "Error en el nombre del parámetro enviado a la consulta de la base de datos";
            
        case '1045':
            return "No se pudo realizar la conexión con la Base de datos. "
                                . " Nombre de usuario o contraseña no válidos."; 
            
        case '1049':
            return "No se pudo realizar la conexión con la Base de datos. "
                                    . "Base de datos desconocida"; 
            
        case '2002':
            return "No se pudo establecer la conexión con el servidor de la Base de datos. "
                                . "El servidor no responde."; 
            
        case '42S02':
            return "La tabla no existe"; 
            
        case '42S22':
            return "Uno o más campos listados no existen"; 
            
        case '42000':
            return "Existe un error en la consulta a la base de datos"; 
            
        case '23000':
            return "El registro ya existe."; 

        case '99001':
            return "Tipo de consulta a la base de datos no permitido. Este evento fue reportado";
        
        
        
        default:
            return "Error desconocido. Por favor comuníquese con el "
                        . "Departamento de Informática."; 
            
    }
}


