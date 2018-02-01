<?php 
#Crear cuenta en el perfil

require_once 'core/init.php';
include 'extend/header.php';
//Acá vamos a ingresar datos

// echo '<h1>Acá vamos a hacer las pruebas de INSERT</h1>';

// $user = DB::getInstance()->insertar(
//     'usuarios',
//     array(
//         'nombreusuario' => 'miguel2',
//         'email' => 'mcastilosobarzo@gmail.com',
//         'password' => '123456',
//         'salt' => 'salt',
//         'nombre' => 'Miguel Castillo Sobarzo'
//     )
// );
?>

<?php 
//PRUEBA DE INPUT
// if (Input::existe('get')){
//     echo 'Se ingresó data por GET';
// }

//-----------CHECK DE TOKEN Y SESION
//var_dump(Token::check(Input::get('token'))); RETORNA BOOL (FALSE)SI SE INTENTA PASAR PARAMETROS POR FUERA DE LA PÁGINA.

//PRUEBA DE INPUT
if (Input::existe('post')){
    if (Token::check(Input::get('token'))){
    //echo 'Se ingresó data por POST <br>';
    //echo Input::get('nombreusuario'); 
    echo 'INGRESO LOS DAOTS POR EL BOTÓN!<br>';
    //VALIDACION DE CAMPOS, la estructura es:
        //1.- Crear instancia de la clase Validar.
        $validar = new Validar();
        //2.- Ocupar el metodo comprobar() de la clase Validar. Este método recibe la FUENTE (get o post)  y los CAMPOS (username,password,email,etc)
        $validacion = $validar->comprobar($_POST,array(
        //3.- Los campos tienen asociados otro array, donde van cada una de las reglas.
            'nombreusuario' => array(
                'nombre' => 'Nombre de usuario',
                'required' => true,
                'min' => 5,
                'max' => 20,
                //Esta regla dice: el 'Nombre de usuario'  debe ser único en la tabla 'usuarios'. Se checkea con la BD.
                'unico' => 'usuarios'
            ),
            'email' => array(
                'nombre' => 'Email',
                'required' => true,
                'max' => 30
            ),
            'password' => array(
                'nombre' => 'Password',
                'required' => true,
                'min' => 6,
            ),
            'password_r' => array(
                'nombre' => 'Repetir contraseña ',
                'required' => true,
                //Esta regla dice que debe coincidir con la contraseña.
                'coincide' => 'password'
            ),
            'nombre' => array(
                'nombre' => 'Nombre',
                'required' => true,
                'min' => 5,
                'max' =>50
            )
        ));

        if ($validacion->correcta()){
            //Registrar usuario
            echo 'VALIDACION CORRECTA';
        }else {
            //Mostrar los errores
            foreach ($validacion->errores() as $error) {
                echo "{$error} <br>";
            }
        }
       
        }else{
            echo 'Debe ingresar los datos a través del formulario.';
    }
}
?>

<div class="container">
  <div class="row">
    <div class="col s12 m4 l6">
        <form action="" method="post">
            <!-- INPUT NOMBRE DE USUARIO -->
            <div class="input-field col s12 l6">
                <input type="text" id="nombreusuario" name="nombreusuario" value="<?php echo escape(Input::get('nombreusuario')); ?>">
                <label for="nombreusuario">Nombre de usaurio</label>
            </div>
            <!-- INPUT EMAIL -->
            <div class="input-field col s12 l6">
                <input type="email" id="email" name="email" class="validate"  value="<?php echo escape(Input::get('email')); ?>">
                <label for="email" data-error="wrong" data-success="right">Email</label>
            </div>
            <!-- INPUT PASSWORD -->
            <div class="input-field col s12">
                <input type="password" id="password" name="password"  >
                <label for="password" >Contraseña</label>
            </div>
            <!-- INPUT REPETIR PASSWORD -->
            <div class="input-field col s12">
                <input type="password" id="password_R" name="password_r" >
                <label for="password_r" data-error="wrong" data-success="right">Repetir contraseña</label>
            </div>
            <!-- INPUT NOMBRE COMPLETO -->
            <div class="input-field col s12">
                <input type="text" id="nombre" name="nombre" value="<?php echo  escape(Input::get('nombre')); ?>" >
                <label for="nombre">Nombre completo</label>
            </div>
            <div class="input-field col s12">
                <input type="hidden" name="token" value="<?php echo Token::generar();?>">
                <button id="guardar" name="guardar" type="submit" class="btn">Guardar <i class="material-icons small">send</i></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php include 'extend/footer.php'; ?>