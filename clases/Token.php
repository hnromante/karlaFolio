<?php 
#Checkear si algunos datos fueron enviados a través de un formulario o no.
#Cross site request forgery
#Evita que se envie spam a través de otros sitios

class Token {
    public static function generar(){
        return Session::put(Config::get('session/nombre_token'), md5(uniqid()));
    }

    //Checkear si el token existe en la sesión.
    public static function check($token) {
        $nombre_token = Config::get('session/nombre_token');
        if(Session::existe($nombre_token) && $token === Session::get($nombre_token)){
            Session::delete($nombre_token);
            return true;
        }
        return false;
    }


}
?>