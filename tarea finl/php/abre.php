<?php
    $conexion= new mysqli('localhost', 'id20713119_josue', 'Odie3000?', 'id20713119_universidad');
    if($conexion){
        echo "CONEXION EXITOSA";
    }else {
        echo "NO FUNCIONO LA CONEXION";
    }
?>