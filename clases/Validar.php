<?php 
#Validaciones varias principalmente para formularios.
#Reutilización del código.

//VIDEO 11 - min 10: https://www.youtube.com/watch?v=rWon2iC-cQ0
require_once ('core/init.php');
//Esta clase necesita una isntancia del singleton BD.



class Validar{
    private $_correcta = false,
            $_errores = array(),
            $_db = null; 

    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function comprobar($fuente, $inputs = array()){
        
        //1.-Por cada input dentro del array de inputs, descomprime las reglas.
        foreach ($inputs as $input => $reglas) {

            //1.0 .- Capturamos el nombre del <input>: 'nombreusuario' => array('nombre' => 'Nombre de usuario' ......  
            $input_nombre=$reglas['nombre'];
            //Limpiamos lo ingreado por input
            $input = escape($input);

            //1,1.-Loopiamos las reglas
            foreach ($reglas as $regla => $valor_regla) {
                //echo "{$input} {$regla} debe ser: {$valor_regla}<br>";

                //RECUPERAMOS LA DATA INGRESADA. $fuente[$input] == $_POST['nombreusuario'] == $valor. Representa lo que va dentro del tag <input>.
                $valor = $fuente[$input];
                $valor_cortado = trim($valor);
                //Lo primero es ver si el campo es requerido y esta vacio.
                if ($regla === 'required' && empty($valor)){
                    //Añadir error por cada campo que no se rellenó.
                    $this->agregarError("{$input_nombre} es requerido");

                }else if (!empty($valor)){ //Si el valor no esta vacio, comprobamos que cumpla con las reglas.
                    //Comprobamos las otras validaciones. Acá agregaríamos más reglas en caso de necesitarlas.
                    switch ($regla){
                        case 'min':
                            if(strlen($valor_cortado)< $valor_regla){
                                $this->agregarError("{$input_nombre} debe tener un mínimo de {$valor_regla} caracteres.");
                            }
                        break;

                        case 'max':
                            if(strlen($valor_cortado) > $valor_regla){
                                $this->agregarError("{$input_nombre} debe tener un máximo de {$valor_regla} caracteres.");
                            }
                        break;
                        //Si el valor del <input name='password_r'> no coincide con $_POST['password']
                        case 'coincide':
                            if ($valor != $fuente[$valor_regla]){
                                $this->agregarError("Las contraseñas no coinciden");
                            }
                        break;
                        //Este valor lo capturamos de la base de datos. get('Nombre tabla', array('nombrecolumnatabla/nombreinputhtml','=','karla'))
                        case 'unico':
                        //https://www.youtube.com/watch?v=rWon2iC-cQ0&list=PLfdtiltiRHWF5Rhuk7k4UAU1_yLAZzhWc&index=11 , Min 33.

                            $unico = $this->_db->get($valor_regla, array($input,'=',$valor));

                            if($unico->count()){
                                $this->agregarError("{$valor} ya existe");
                            }
                        break;
                    }
                }

            }
        }
        //Checkeamos si el array de ERRORES esta vacio. Si es asi, devolvemos verdadero a CORRECTO
        if(empty($this->_errores)){
            $this->_correcta = true;
        }
        return $this;
    }

    private function agregarError($error){
        $this->_errores[] = $error;
    }

    public function errores(){
        return $this->_errores;
    }

    public function correcta(){
        return $this->_correcta;
    }
}

?>