<?php 
#Una de las clases más grande
#Ocuparemos mucho el wrapper DB para crear usaurios, actualizar user information, etc.

class Usuario {
    private $_db;
    
    public function __construct ($usuario = null){  
        $this->_db = DB::getInstance();
    }

    public function crear($campos = array()){
        //Preguntamos por !insertar ya que retorna True si salio todo bien.
        if (!$this->_db->insertar('usuarios',$campos)){
            throw new Exception("Hubo un problema creando la cuenta");
            
        }
    }
}
?>