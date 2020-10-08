<?php
include('conexion.php');

#ejemplo:
#http://ppagoss1.com/verificarCuenta.php?user=bmmf&pass=a4a537d4b35b0ace7746a374cd3937e71af41117

$user=$_GET['user'];
$pass=$_GET['pass'];

$consulta = "SELECT * FROM CUENTA WHERE usuario='$user' AND contrasena = '$pass' AND estado = 'ACTIVO'";

$resultado = $conexion -> query($consulta);
if ($resultado->num_rows!=1){
    #el usuario no existe, los datos son incorrectos o no esta activo
    $value = array( 
        "respuesta"=>"user_invalido"); 
    $producto[] = array_map('utf8_encode', $value);
} else {
    #el usuario si existe
    $value = array( 
        "respuesta"=>"user_valido"); 
        $producto[] = array_map('utf8_encode', $value); 

}

echo json_encode($producto);


?>