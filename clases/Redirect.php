<?php 
#404 Error
#Redireccionamiento a diversas partes de nuetra aplicación
#Para no tener que escribir siempre header('Location': 'Index.php');

class Redirect {
    
    public static function to($location = null){
        if($location){
            if (is_numeric($location)){
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include ('includes/errors/404.php');
                        exit();
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            header('Location: '.$location);
            exit();  
        }
    }
}
?>