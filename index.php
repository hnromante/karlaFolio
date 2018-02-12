<?php 
#Landing age, página principal de la web

//LLAMAMOS AK COMIENZO DE NUESTRA PÁGINA init.php

require_once 'core/init.php';

include 'extend/header.php';
?>
<h1>El host name es : <?php echo Config::get('mysql/host');?></h1>
<h1>El Nombre de usuario es : <?php echo Config::get('mysql/username');?></h1>
<h1>El Nombre de la DB : <?php echo Config::get('mysql/db');?></h1>
<hr>
PROBANDO GET ISNTANCE DE LA BASE DE DATOS.
<hr>
<?php 
//Esta linea de codigo no funciona si no se ha inicializado la isntancia (Ver  singleton.)
#$db = new DB();
//$usuario = DB::getInstance()->query("SELECT nombreusuario FROM usuarios WHERE id = ?",    array('asd'));


//Acá llamemos a los usuarios pero esta vez ocupando una función HELPER.
                        #()->get('TABLA',array(campo,operador,valor));

$karla = DB::getInstance()->get('usuarios', array('nombreusuario','=','karla'));

$usuarios = DB::getInstance()->query("SELECT * FROM usuarios");
if (!$usuarios->count()){
    echo 'NO USER!';
}else{
    echo 'OK! <br>';
    
    foreach ($usuarios->resultados() as $usuario){
        echo $usuario->nombreusuario.'<br>';
    }

    echo '<hr>';
    echo 'El primer usuario es: '.$usuarios->primero()->nombreusuario;
}
//PRUEBA DE FLASH. Capturamos los datos enviamos desde REGISTRAR.PHP a INDEX.PHP a través de la sesión. Cuando refrescamos la página ya no debería estar
//porque eliminamos la session con el nombre 'EXITO'. Ver metodo Session::flash().

    if(Session::existe('exito')){
        echo '<h1>';
        
            Session::flash('exito');
        echo '</h1>';
    }

    if(Session::existe('home')){
        echo '<h1>'; 
            Session::flash('home');
        echo '</h1>';
    }
?>

<h1><a href="registrar.php">LINK RETORN REGISTRAR</a></h1>

<?php include 'extend/footer.php'; ?>