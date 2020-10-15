<?php

include("../conexion.php");

 if(isset($_POST['usuario']) && isset($_POST['contrasena'])){
   $bd = conectar();
   $usuario = $_POST['usuario']; // en realidad es el correo no el usuario
   $contrasena = $_POST['contrasena'];

   //$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
   $contrasenaHash = $contrasena;

   $sql = "SELECT correo FROM CUENTA WHERE correo= '$usuario' AND contrasena='$contrasenaHash'";
   $resultado= mysqli_query($bd,$sql);
   $mostrar=sizeof(mysqli_fetch_array($resultado));
   if($mostrar>0){
     $sql2 = "SELECT nombre_completo, codigo_empresa, empresa, saldo, tipo,tarjeta_credito,cuenta_financiera,estado FROM CUENTA WHERE correo= '$usuario' AND contrasena='$contrasenaHash'";
     $resultado2= mysqli_query($bd,$sql2);
     $mandar['mensaje'] = "Inicio de sesion correcto";
     $mandar['datos'] =  $resultado2->fetch_all(MYSQLI_ASSOC);
     $mandar['result'] = true;
     echo json_encode($mandar);

   }else{
     $mandar['mensaje'] = "Error, datos incorrectos, ".$usuario.', '.$contrasena;
     $mandar['result'] = false;
     echo json_encode($mandar);
   }
 }






 ?>
