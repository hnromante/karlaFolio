<?php 
#Mi perfil

require_once 'core/init.php';

//Acá vamos a MODIFICAR datos

echo '<h1>Acá vamos a hacer las pruebas de UPDATE</h1>';

$user = DB::getInstance()->actualizar(
    'usuarios',
    3,
    array(
        'nombreusuario' => 'mcsob',
        'email' => 'NEWMAIL@gmail.com',
        'password' => '123456'
    )
);
#FORMA CONVENCIONAL DE ACTUALIZAR UN REGISTRO.
// $actualizar_usr = DB::getInstance()->query("UPDATE usuarios SET nombreusuario = ?, email = ?, password = ? WHERE id = ?", array('MIGUELITO','EMAILACTUALIZADO@GMAIL.COM','654321',3));

// if ($actualizar_usr){
//     echo 'Se actualizo el usuario';
// }else {
//     echo 'No se puedo actualizar el usuario';
// }

?>