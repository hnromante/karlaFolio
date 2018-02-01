<?php 
#Setter a sesión
#Checkear si un usuario esta logueado
class Session {
    //Para crear la sesion
    public static function put($nombre, $valor){
        return $_SESSION[$nombre] = $valor;
    }

    //Checkear si una sesion existe
    //SI la session con 'X NOMBRE' existe, retorna verdadero.
    public static function existe($nombre){
        if (isset($_SESSION[$nombre])){
            return true;
        }else{
            return false;
        }
    }

    //Si la sesion existe, borrala.
    public static function delete($nombre){
        if (self::existe($nombre)){
            unset($_SESSION[$nombre]);
        }
    }
    //GETTER
    public static function get($nombre){
        if (self::existe($nombre)){
            return $_SESSION[$nombre];
        }
    }
}
?>