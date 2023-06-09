<?php 
    require('../config/db.php');

    session_start();

    $id = $conn -> real_escape_string($_POST['id']);

    $sql = "DELETE FROM pelicula
            WHERE id = $id";

    if ($conn -> query($sql)) {

        $dir = "posters";
        $poster = $dir . '/' . $id . 'jpg';

        if (file_exists($poster)) {
            unlink($poster);
        }
        $_SESSION['color'] = "success";
        $_SESSION['msg'] = "Registro eliminado de forma exitosa!";
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al eliminar el registro";
    }

    header('Location: index.php');
