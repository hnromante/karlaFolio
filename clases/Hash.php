<?php 
#Para diversos motivos de seguridad.
//Ocuparemos sh256 pero hay que revisar PHP PRACTICES PARA MEJOR FUNCIONALIDAD. REMUEVE LA NECESIDAD DE SALT.
class Hash {

    //EJEMPLO:
    // 'password' = '12345'
    //SALT1: 'passwordnajsgduy123'
    //SALT2: 'passwordJ893129GASD'
    //Esto hace que lo valores de password hash sean diferentes
    public static function crear($texto, $salt= ''){
        return hash("sha256",$texto.$salt); 
    }

    //mcrypt_create_iv devuelve un string random. Le entregamos un largo prudente.
    public static function salt ($largo){
        return mcrypt_create_iv($largo);
    }

    public static function unico(){
        return self::crear(uniqid());
        }
}
?>