<?php 
#Ejemplo Input::get('Username') ---> Alex

//Metodo para checkear que la data exista
    // <form method="GET">
// <input type ="tetx" name="primerNOmbre" >
class Input {

    //Metodo para confirmar que si envió data por GET o POST. Equivalente a preguntar if(isset($_POST)).
    public static function existe($type = 'post'){
        switch ($type){
            case 'post':
                if (!empty($_POST)){
                    return true;
                }else{
                    return false;
                }
            break;
            case 'get':
                if (!empty($_GET)){
                    return true;
                }else{
                    return false;
                }
            break;
            default:
                //Rrtornamos false porque asumismo que siempre debe venir DATA
                return false;
            break;

        }
    }

    //Método para devolver de forma más eficiente los parametros enviados por $_GET o $_POST
    //Si encuentra algo en GET, retorna $_GET[$item], si encuentra en post retorna $_POST[$item], si no encuentra nada,
    //devolvemos una cadena de texto vacia '' para que no se caiga la página.
    public static function get($item){
        if (isset($_POST[$item])){
            return $_POST[$item];
        }else if (isset($_GET[$item])){
            return $_GET[$item];
        }else{
            return '';
        }
        return '';
    }
}
?>