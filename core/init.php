<?php 
#Incluida en todas las paginas, autocarga los archivos necesarios.
# VIDEO 6: https://www.youtube.com/watch?v=S6vDgLwJ7n8 
#Para permitir que la gente se loguee.
session_start();

#Creamos un array de configuraciones. 
$GLOBALS['config'] = array(
    # Array con los datos de conexión a la base de datos.
    'mysql' => array( 
        'host' => '127.0.0.1', #No ocupamos LOCALHOST porque tiene que hacer un DNS Lookup y lo hace la app más lenta.
        'username' => 'root',
        'password' => '',
        'db' => 'karlafolio'
    ),
    #Array para recordar datos sobre cookies.
    'remember' => array(
        'cookie_nombre' => 'hash',
        'cookie_expiracion' => 86400 #Duración de la cookie en SEGUNDOS = 1 DIA
    ), 
    #Array que se encarga de gaurdar los hashes de las sesiones activas. 'Remember me'.
    'session' =>array( 
        'nombre_token' => 'usuario'

    ) 
);

#Para autocargar las distintas clases que ocuparemos a través de la aplicación.
#No ocuparemos REQUIRE_ONCE porque hace dificil la mantención si cambiamos algún nombre y es redundante.
// require_once 'clases/Config.php';
// require_once 'clases/Cookie.php';
// require_once 'clases/DB.php';

#Usaremos AUTOLOAD. de SPL Standar PHP Library

#MINUTO 6: https://www.youtube.com/watch?v=JQkfAdZbAJE , esto evita que se carguen archivos innecesariamente. Carga lo justo y necesario dinamicamente.

spl_autoload_register(
    function ($clase){
        require_once 'clases/'.$clase.'.php';
    }
);
//Cargamos las funciones con require, ya que no están dentro de una clase y no es necesario ponerlas en una.
require_once 'funciones/sanitar.php';

?>