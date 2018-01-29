<?php 
#Archivo dedicato a limpar la data enviada a través de los formularios. Para evitar PHP, SQL && HTML injections.
#Ocupa ENTIDADES DE PHP para limpiar la data al entrar y salir.

function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}


?>