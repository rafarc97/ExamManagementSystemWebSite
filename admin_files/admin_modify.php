<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Admin Page</title>
</head>
<body>

<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>

<?php if($_SESSION['user']['rol'] == 'admin'): ?>

    <!-- REGISTRO -->
    <div id="register" class="bloque fondo">
    <h3> Bienvenido, <?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname'] ?> </h3>
    <h3>Menú administrador</h3>

        <!-- ÉXITO/ERROR REGISTRO -->
        <?php 
            if(isset($_SESSION['completed'])): ?>
                <div class="alerta alerta-exito">
                    <?=$_SESSION['completed']?>
                </div>
            <?php elseif(isset($_SESSION['errors']['general'])): ?>
                <div class="alerta alerta-error">
                    <?=$_SESSION['errors']['general']?>
                </div>
            <?php endif;
        ?>
        
        <h4> Modificar usuarios</h4>
        <br>

        <?php
            $sql = "SELECT * FROM users";
            $result = mysqli_query($db,$sql) or die('Error en la conexión a la BBDD');
            mysqli_close($db);

            if($result && mysqli_num_rows($result) >= 1){
                
                $counter = 1;
                $html = "";
                while($users = mysqli_fetch_assoc($result)){
                    $uid = $users['uid'];
                    $name = $users['name'];
                    $surname = $users['surname'];
                    $email = $users['email'];
                    $pass = $users['pass'];
                    $rol = $users['rol'];
                    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
                    
                    $html .= "
                        <form action='update_user.php' method='POST'>
                            <h4>Usuario nº $counter</h4>
                            <label for='nombre'>Nombre</label>
                            <input style='width: 200px; 
                            type='text' name='nombre' value='$name'>
                            <?php echo isset($errors) ? mostrarError($errors,'nombre') : '' ?>

                            <label for='apellidos'>Apellidos</label>
                            <input style='width: 200px;    padding: 0px;
                            ' type='text' name='apellidos' value='$surname' required>
                            <?php echo isset($errors) ? mostrarError($errors,'apellidos') : '' ?>

                            <label for='email'>Email</label>
                            <input style='width: 200px; type='email' name='email' value='$email' required>
                            <?php echo isset($errors) ? mostrarError($errors,'email') : '' ?>

                            <label for='email_not_modify'></label>
                            <input type='hidden' name='email_not_modify' value='$email' required>
                            
                            <label for='rol'>Rol</label>
                            <input style='width: 200px; type='text' name='rol' value='$rol' required>
                            <?php echo isset($errors) ? mostrarError($errors,'rol') : '' ?>
                            <input type='submit' value='Actualizar'>
                        
                        </form>

                        <form action='delete_user.php' method='POST'>
                            <label for='uid'></label>
                            <input type='hidden' name='uid' value='$uid' required>
                            
                            <input type='submit' value='Borrar'>
                        </form>

                        <br>";

                     $counter++;
                }
                echo $html;

            }else{
                $_SESSION['error_login'] = 'Login incorrecto....';
            }
        ?>

        <br>
        <a class="boton boton-verde" href="../admin.php">Volver</a>
        <?php borrarAlertas(); ?> 
    </div>
    
<?php else: ?>
    <?php header('Location: ../index.php'); ?>
<?php endif; ?>
  
</body>
</html>