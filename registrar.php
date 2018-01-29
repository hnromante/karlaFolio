<?php 
#Crear cuenta en el perfil

require_once 'core/init.php';

//Acá vamos a ingresar datos

echo '<h1>Acá vamos a hacer las pruebas de INSERT</h1>';

$user = DB::getInstance()->insertar(
    'usuarios',
    array(
        'nombreusuario' => 'miguel2',
        'email' => 'mcastilosobarzo@gmail.com',
        'password' => '123456',
        'salt' => 'salt',
        'nombre' => 'Miguel Castillo Sobarzo'
    )
);
?>