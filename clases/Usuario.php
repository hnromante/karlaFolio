<?php 
#Una de las clases más grande
#Ocuparemos mucho el wrapper DB para crear usaurios, actualizar user information, etc.

class Usuario {
    private $_db,
            $_data;
    
    public function __construct ($usuario = null){  
        $this->_db = DB::getInstance();
    }

    public function crear($campos = array()){
        //Preguntamos por !insertar ya que retorna True si salio todo bien.
        if (!$this->_db->insertar('usuarios',$campos)){
            throw new Exception("Hubo un problema creando la cuenta");
            
        }
    }
    //El método encontrar nos va a seevir para buscar por ID o NOmbre, dentro preguntamos si el campo es numerico o String.
    public function encontrar($usu = null){
        if($user){
            $campo = null; 
            //ES ID O NOMBRE?
            if(is_numeric($usu)){
                $campo = 'id';
            }else{
                $campo = 'nombreusuario';
            }
            //SELECT *  FROM usuario WHERE (id/nombreusuario) = $usu;
            $data = $this->_db->get('usuarios',array($campo,'=',$usu));
            if ($data->count()){
                $this->_data = $data->primero();
                return true;
            }
        }
        return false;
    }

    public function login($nombreusuario = null, $password = null){
        
        $usu = $this->encontrar($nombreusuario);
        print_r($this->_data);
        return false;
    }
}
?>