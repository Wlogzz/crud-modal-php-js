<?php 
    require('../config/db.php');

    $id = $conn -> real_escape_string($_POST['id']);

    $sql = "DELETE FROM pelicula
            WHERE id = $id";

    if ($conn -> query($sql)) {
        
    }

    header('Location: index.php');

?>