<?php
    require_once 'includes/connection.php';

    if(isset($_POST)){

        //Borrar error antiguo
        if(isset($_SESSION['error_login'])){
            unset($_SESSION['error_login']);
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = '$email'";

        $login = mysqli_query($db,$sql) or die('Error en la conexión a la BBDD');
        
        mysqli_close($db);

        if($login && mysqli_num_rows($login) == 1){
            $usuario = mysqli_fetch_assoc($login);

            $verify = password_verify($password,$usuario['pass']);
            
            if(!$verify && $password == $usuario['pass']){
                $verify = true;
            }

            if($verify){
                $_SESSION['user'] = $usuario;
            }else{
                $_SESSION['error_login'] = 'Login incorrecto....';
            }
        }else{
            $_SESSION['error_login'] = 'Login incorrecto....';
        }
    }
    header('Location: index.php');
?>