<?php
require('../config/db.php');

session_start();

$nombre = $conn->real_escape_string($_POST['nombre']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$genero = $conn->real_escape_string($_POST['genero']);

$sql = "INSERT INTO pelicula (nombre, descripcion, id_genero, fecha_alta)
            VALUES ('$nombre', '$descripcion', $genero, NOW())";

if ($conn->query($sql)) {
    $id = $conn->insert_id;

    $_SESSION['msg'] .= "<br>Registro guardo de forma exitosa!";
    $_SESSION['color'] = "success";

    // Verificar cargue imagen
    if ($_FILES['poster']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg", "image/jpeg");
        if (in_array($_FILES['poster']['type'], $permitidos)) {

            // Variable carpeta
            $dir = "posters";

            // Info de la imagen
            $info_img = pathinfo($_FILES['poster']['name']);
            $info_img['extension'];

            // Relacionando los datos de la imagen con el id correspondiente al cargue
            $poster = $dir . '/' . $id . '.jpg';

            // Creando la carpeta de almacenamiento img
            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }

            if (!move_uploaded_file($_FILES['poster']['tmp_name'], $poster)) {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al guardar la imágen";
            }
        } else {
            $_SESSION['color'] = "warning";
            $_SESSION['msg'] .= "<br>Formato de imágen no permitido";
        }
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al guardar la imágen";
    }
}

header('Location: index.php');
