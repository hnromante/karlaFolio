<?php 
#DATABASE WRAPPER
#PDO = PHP Data Objects
#Para conectar a cualquier DATABASE
#VIDEO 7: https://www.youtube.com/watch?v=3_alwb6Twiw


class DB {
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;
    
    private function __construct(){
        try {
                       
            $host = Config::get('mysql/host');
            $dbname = Config::get('mysql/db');
            $username = Config::get('mysql/username');
            $password = Config::get('mysql/password');
            #new PDO(HOST;DBNAME,USERNAME,PASSWORD)
            $this->_pdo = new PDO('mysql:host='.$host.';'.'dbname='.$dbname,$username.$password);
            //echo '<center>INSTANCIA DE BASE DE DATOS CONECTADA</center><br>';
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //METODO PARA  LA ÚNICA INSTANCIA DE BASE DE DATOS. Patrón singleton.

    public static function getInstance(){
        if (!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    //MÉTODO GENÉRICO PARA CREAR QUERIES
    public function query($sql, $params = array()){
        
        //Reseteamos el valor del error a falso como defecto
        $this->_error = false;

        //Checkear si la QUERY se preparó correctamente. Dentro del IF hay una asignacion y el checkeo en el mismo paso.
        $stmt = $this->_pdo->prepare($sql);
        if($this->_query = $stmt){
            //Si se prepararon correctamente los STATEMENT, preguntamos is hay algún parametro para RELACIONAR.
            #Ejemplo: SELECT * FROM USUARIOS WHERE id = ? AND password = ?
            #         $this->_query->bindValue(1,$ID);
            #         $this->_query->bindValue(2,$NOMBRE );
            $x = 1;
            if (count($params)){
                foreach ($params as $param) {
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }
            //AHORA RECIEN EJECUTAMOS LOS QUERIES
            if ($this->_query->execute()){
                //Guardamos el ResultSet.
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else{
                $this->_error = true;
            }
        }
        return $this;
    }
    //Creamos un metodo para preguntar si existio algún error en la última instancia llamada de PDO.
    //SI por ejemplo llamamos
    //DB::getInstance()->query("Select id FROM usuarios WHERE id = 'asd'", array());
    //Esto no devolvería nada, por lo tanto setiaría ERROR  a true.

    public function error(){
        return $this->_error;
    }

    //La función acción toma 3 parametros,
        //La acción a realizar EJ: SELECT *, DELETE *, UPDATE
        //La tabla donde se va aplicar la acción EJ: usuarios
        //Un arreglo de parámetros para filtrar EJ: WHERE nombreusuario = karla
    public function accion($accion,$tabla,$where = array()){
        //el arreglo $where debe tener 3 parametros: CAMPO, OPERADOR, VALOR

        if (count($where) === 3){
            $operadores_validos = array('=','>','<','>=','<=');
            
            $campo = $where[0];
            $operador = $where[1];
            $valor = $where[2];

            //Preguntamos si el operador recibido en $where existe dentro de los $operadores_validos
            //Si lo encuentra, construimos el QUERY ocupando el METODO QUERY que creamos más arriba.
            if (in_array($operador,$operadores_validos)){
                $sql = "{$accion} FROM {$tabla} WHERE {$campo} {$operador} ?";

                if (!$this->query($sql, array($valor))->error()){
                     return $this; 
                }
            }
        }
        return false;
    }

    public function get($tabla,$where){
        return $this->accion("SELECT * ",$tabla,$where);
    }
    
    public function eliminar($tabla,$where){
        return $this->action('DELETE',$tabla,$where);
    }

    public function count(){
        return $this->_count;
    }
    //RESULT SETS EN PDO VIDEO 9: https://www.youtube.com/watch?v=fFxGA4j83Jc
    public function resultados(){
        return $this->_results;
    }

    public function primero(){
        return $this->resultados()[0];
    }

    //INSERTAR Y UPDATEAR METODOS VIDEO 10: https://www.youtube.com/watch?v=FCnZsU19jyo

    //El método insertar recibe 2 parametros, la $tabla donde se va a insertar y un arreglo de $campos vamos a insertar
    public function insertar($tabla, $campos){
            
        $llaves = array_keys($campos);
        $valores = '';
        $x = 1;

        foreach ($campos as $campo){
            $valores .= "?";
            //Si el contador es menor que la cantidad de campos, vamos a agregar una compa y un espacio para separar.
            if ($x < count($campos)){
                $valores .= ', '; 
            }
            $x++;    
        }
        
        $sql = "INSERT INTO {$tabla} (".implode(",",$llaves).") VALUES ({$valores})";
        if (!$this->query($sql, $campos)->error()){
            echo 'Insertado correctamente';
            return true;
        }else{
            echo 'No se pudo ingresar el usuario';
        }

        return false;
    }

    //Actualizar toma 3 valores, la $tabla, $el id del objeto y los $campos a modificar.
    public function actualizar($tabla,$id,$campos){
        
        $set = '';
        $x = 1;

        foreach ($campos as $llave => $valor){
            
            $set .="{$llave} = ?";
            //Si el contador aun es menor que la cantidad de CAMPOS, vamos a CONDADENAR una COMA y un ESPACIO para separar.
            if($x < count($campos)){
                $set .= ', ';
            } 
            $x++;
        }
    
        $sql = "UPDATE {$tabla} SET {$set} WHERE id = {$id}";
        echo $sql;

        if (!$this->query($sql,$campos)->error()){
            echo '<br> Perfil modificado correctamente';
            return true;
        }else{
            echo '<br> No se pudo actualizar el perfil';
            return false;
        }
        return false;
    }

}
?>