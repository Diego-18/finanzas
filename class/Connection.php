<?php

/* 
 * Conexión con la base de datos
 */
#namespace app\classes;

require_once $GLOBALS['CFG']->path . 'class/ErrorHandler.php';

class Connection{
    
    private $connection;
    private $errorMessage = '';
    
    public function __construct() {
       try {
        $dsn = "mysql:host={$GLOBALS['CFG']->dbhost};"
            . "dbname={$GLOBALS['CFG']->dbname}";
        $this->connection = new PDO($dsn
                    ,$GLOBALS['CFG']->dbuser
                    ,$GLOBALS['CFG']->dbpassword
                );
       } catch (PDOException $e){
           ErrorHandler::register($e);
           echo ErrorHandler::getErrorMessage($e);
          die();
       }
       $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    }
   
    public function getErrorMessage(){
        return $this->errorMessage;
    }

    public function executeQuery($query){   
        try{
            $data = $this->connection->query($query, PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            ErrorHandler::register($e);
           $this->errorMessage = ErrorHandler::getErrorMessage($e);
            return false;
        }
        return $data;
    }
    
    public function execute($statement){
        $rows = 0;
        try {
            $rows = $this->connection->exec($statement);
        } catch (PDOException $e) {
            ErrorHandler::register($e);
           $this->errorMessage = ErrorHandler::getErrorMessage($e);
            return false;
        }
        return [
            'rows' => $rows,
            'lastInsertId' => $this->connection->lastInsertId(),
        ];
    }
    
    public function executePreparedStatement($statement, $parameters){
        try{
            $ps = $this->connection->prepare($statement);
            $ps->execute($parameters);
        } catch (PDOException $e){
            ErrorHandler::register($e);
            $this->errorMessage = ErrorHandler::getErrorMessage($e);
            return FALSE;
        }
        return [
            'rows' => $ps->rowCount(),
            'id' => $this->connection->lastInsertId()
        ];
    }
    
}

#$connection = new connection();

#Modelo se Select
//if (!$data = $connection->executeQuery("SELECT * FROM empresa")){
//    echo "Error " , var_dump($data);
//}
//
//foreach ($data as $item){
//    echo $item['empresa'];
//    echo $item['nombre'];
//    echo '----<br>';
//}

#Modelo de Insert
//$statement = "INSERT INTO empresa SET nombre='Tienda de la esquina'";
//
//if (FALSE === $result = $connection->execute($statement)){
//    echo $connection->getErrorMessage();
//} else {
//    echo "Registro creado con código: ". $result['lastInsertId'] ;
//}

#Modelo de Update
//$statement = "UPDATE empresa "
//        . "SET nombre= 'Tienda corazón' "
//        . "WHERE empresa = 20";
//
//if (FALSE === $result = $connection->execute($statement)){
//    echo $connection->getErrorMessage();
//} else {
//    echo "Filas actualizadas: ". $result['rows'] ;
//}

#Modelo de Delete
//$statement = "DELETE FROM empresa WHERE empresa = 24";
//if (FALSE === $result = $connection->execute($statement)){
//    echo $connection->getErrorMessage();
//} else {
//    echo "Filas actualizadas: ". $result['rows'] ;
//}