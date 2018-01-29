<?php 
#Para acceder a datos de configuración de toda la aplicacion 
#desde un solo archivo.Como nombre de database.
class Config {

    public static function get($path = null){
        if ($path){
            $config = $GLOBALS['config'];
            $path = explode('/',$path);

            foreach ($path as $item) {
                #Checkeamos si cada uno de estos items esta configurado (SETEADO) en el array de $GLOBALS['config]..$config.
                if(isset($config[$item])){
                    #Si encuentra una coicidencia, asigna un nuevo valor de array  a config (el array interior).
                    $config = $config[$item];
                }
    
            }
            #Finalemente retornamos $config que va a tener el valor del item que estabamos buscando mysql/host ....127.0.0.1
            return $config;
    
        }
        #Retornamos falso si no hay un PATH que coincida
        return False;
    }

}

?>