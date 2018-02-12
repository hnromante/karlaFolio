<?php 
#Loguearse en el sistema
require_once 'core/init.php';
include 'extend/header.php';

if (Input::existe()){
    //CHECKEAD QUE EL TOKEN EXISTE
    if(Token::check(Input::get('token'))){
        $validar = new Validar();
        $validacion = $validar->comprobar($_POST,array(
            'nombreusuario' => array('nombre'=>'Nombre de usuario','required' => true),
            'password' => array('nombre'=>'La contraseña','required' => true)
        ));

        if ($validacion->correcta()){
            //LOGUEAR USUARIO
            $usu = new User();
            $login = $usu->login(Input::get('nombreusuario'), Input::get('password'));

            if($login){
                echo 'Éxito!';
            }else{
                echo '<p>Login fallido!</p>';
            }
            
        }else{
            $errores = $validacion->errores();

            foreach ($errores as $error) {
                echo $error.'<br>';
            }
        }
    }
}
?>

<div class="container">
  <div class="row">
    <div class="col">
        <form action="" method="POST">
            <!--NOMBRE DE USUARIO -->
            <div class="input-field col s12 l6">
                <input type="text" id="nombreusuario" name="nombreusuario" class="validate" value="<?php echo escape(Input::get('nombreusuario'))?>">
                <label for="nombreusuario">Nombre de usuario</label>
            </div>
            <!--PASSWORD --> 
            <div class="input-field col s12 l6">
                <input type="password" id="password" name ="password" class="validate">
                <label for="password">Contraseña</label>
            </div>
            <!-- BOTON-->
            <div class="input-field col s12">
                <input type="hidden" name="token" value="<?php echo Token::generar()?>">
                <button id="guardar" name="Ingresar" type="submit" class="btn">Ingresar <i class="material-icons small">send</i></button>
            </div>
        </form>
    </div>
  </div>
</div>

<?php include 'extend/footer.php'; ?>