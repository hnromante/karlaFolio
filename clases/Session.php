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

    //FLASH. Mostrar un mensaje con X nombre de sesion. Luego se borra X sesion para que cuando refresque la página ya no este el mensaje.
    //Si la sesion no existe, la creamos con el mensaje.
    #NOTA: PARA QUE ESTO FUNCIONE, EL MENSAJE DE FLASH DEBE SER RECIBIDO EN LA PAGINA QUE HICIMOS REDIRECCION. EJEMPLO registar.php -> index.php, con el siguiente formato:
    #
    public static function flash ($nombre, $mensaje = ""){

        if (self::existe($nombre)){
            $sesion = self::get($nombre);
            self::delete($nombre);
            print_r($sesion);

            return $sesion;
        }else{
            self::put($nombre,$mensaje);
        }
        return '';
    }
}
?>