<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Añadir pregunta - Profesor</title>

    <script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript"  >
			$(document).ready(function(){
				$("#cbx_subject").change(function () {
					$("#cbx_subject option:selected").each(function () {
						subjectid = $(this).val();
						$.post("/practica1/includes/get_units.php", { subjectid: subjectid }, function(data){
							$("#cbx_unit").html(data);
						});            
					});
				})
			});
		</script>
</head>
<?php
require_once '../includes/helpers.php';
require_once '../includes/connection.php';
if($_SESSION['user']['rol'] == 'profesor'): ?>
<body>
    <!-- Añadir pregunta -->
    <div class="bloque">
        <h3>Añadir pregunta</h3>
        <form id="combo" name="combo" action="../includes/add_question.php" method="POST">
            <?php 
            $current_uid = $_SESSION['user']['uid'];
            $query = "SELECT S.name, S.subjectid FROM users U, usersubjects US, subjects S WHERE U.uid = '$current_uid' AND US.uid = U.uid AND US.subjectid = S.subjectid";

            $result = mysqli_query($db,$query);

            if(mysqli_num_rows($result) != 0){
                echo "Impartes <b>", mysqli_num_rows($result),"</b> asignaturas. <br><br>";
            ?>

            

            <!-- Asignatura y tema -->
            <label for="cbx_subject">Elige una asignatura: 
                <select name="cbx_subject" id="cbx_subject" required>
                
                    <option value="">Selecciona asignatura</option>
                    <?php 
                    while($row = $result->fetch_assoc()) { 
                        ?>
                        <option value="<?php echo $row['subjectid']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label for="cbx_unit">Elige un tema: 
                <select name="cbx_unit" id="cbx_unit" required>
                    <option value="">Selecciona tema</option>
                </select>
            </label>
            
            <br><hr><br>

            <!-- Pregunta -->
            <label for="new_question">Escriba la pregunta a insertar:</label>
            <input style="width: 50%;" type="text" name="new_question" required>

            <br><hr><br>

            <!-- Respuestas -->
            <label for="answer1">Respuesta 1:</label>
            <div>
            <input style="display: inline-block; margin-right: 10px; width: 50%;" type="text" name="answer1_text" required>
            <input style="display: inline-block;" type="radio" name="answer" value="answer1" checked>
            </div>

            <label for="answer2">Respuesta 2:</label>
            <div>
            <input style="display: inline-block; margin-right: 10px; width: 50%;" type="text" name="answer2_text" required>
            <input style="display: inline-block;" type="radio" name="answer" value="answer2">
            </div>

            <label for="answer3">Respuesta 3:</label>
            <div>
            <input style="display: inline-block; margin-right: 10px; width: 50%;" type="text" name="answer3_text" required>
            <input style="display: inline-block;" type="radio" name="answer" value="answer3">
            </div>

            <input type="submit" name="añadir" value="Añadir">
        </form>
        <?php } else {
                    echo "No impartes ninguna asignatura.<br>";
                }
            ?>
        <br>
        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
    <?php else:
    header('Location: ../index.php');
    endif;
    mysqli_close($db);?>
</body>
</html>