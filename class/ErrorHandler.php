<?php

/* 
 * Manejador de errores
 */

require_once $GLOBALS['CFG']->path . $GLOBALS['CFG']->errorMessageFile;

class ErrorHandler{
    
    const SEPARATOR = "|";
    
    public function setErrorArray($arrayError){
        $date = getdate();
        $error = [
            'dateTime' => "{$date['year']}-{$date['mon']}-{$date['mday']} "
            . "{$date['hours']}:{$date['minutes']}:{$date['seconds']}",
            'file' => $file,
            'line' => $line,
            'code' => $arrayError['code'],
            'message' => str_replace(PHP_EOL, "", $arrayError['message']),
        ];
        self::registerInFile($error);
    }
    
    public static function register(Exception $e){
        
        $arrayFiles = [];
        
        $arrayTrace = $e->getTrace();
        
        foreach ($arrayTrace as $trace){
            $arrayFiles[] = $trace['file'] . "-" . $trace['line']; 
        }
        
        $date = getdate();
        $error = [
            'dateTime' => "{$date['year']}-{$date['mon']}-{$date['mday']} "
            . "{$date['hours']}:{$date['minutes']}:{$date['seconds']}",
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'files' => implode(self::SEPARATOR, $arrayFiles)
        ];
            
//        if (key_exists("args", $arrayTrace[0])){
//            $error['query'] = implode(";",$arrayTrace[0]['args']);
//        }    
        
        self::registerInFile($error);
    }
    
    public static function getErrorMessage(Exception $e){
        
        if ($GLOBALS['CFG']->development === TRUE){
            return $e->getCode() . $e->getMessage();    
        }
        
       
        return pathErrorMessage($e);    
       
    }
    
    
    private static function registerInFile($data){
        file_put_contents($GLOBALS['CFG']->path . $GLOBALS['CFG']->errorFile, implode(self::SEPARATOR
                , $data) . PHP_EOL , FILE_APPEND);
    }
    
}