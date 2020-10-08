<?php

include("../conexion.php");

/*
include_once '../php/user.php';
include_once '../php/userSession.php';


 $userSession = new UserSession();
$user = new User();
*/

 if(isset($_SESSION['user'])){
   //$user->setUser($userSession->getCurrentUser());
   //.include_once '../paginas/usuario.html';
 }else if(isset($_POST['usuario']) && isset($_POST['contrasena'])){
   $bd = conectar();
   $usuario = $_POST['usuario'];//es el correo, no el usuario
   $contrasena = $_POST['contrasena'];

   //$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
   $contrasenaHash = md5($contrasena);


   $sql = "SELECT CORREO FROM CUENTA WHERE correo= '$usuario' AND contrasena='$contrasenaHash'";
   $resultado= mysqli_query($bd,$sql);
   $mostrar=sizeof(mysqli_fetch_array($resultado));



   if($mostrar>0){
     $sql2 = "SELECT ESTADO, TIPO FROM CUENTA WHERE correo= '$usuario' AND contrasena='$contrasenaHash'";
     $resultado2= mysqli_query($bd,$sql2);
     while($mostrar2=mysqli_fetch_array($resultado2)){
       $tipo = $mostrar2['TIPO'];
       $estado = $mostrar2['ESTADO'];
     }

     $mandar['mensaje'] = "Inicio de sesion correcto";
     $mandar['result'] = true;
     $mandar['key'] = $contrasenaHash;
     $mandar['usuario'] = $usuario;
     $mandar['tipo'] = $tipo;
     $mandar['estado'] = $estado;
     $mandar['correo'] = $usuario;
     echo json_encode($mandar);

   }else{
     $mandar['mensaje'] = "Error, datos incorrectos";
     $mandar['result'] = false;
     echo json_encode($mandar);
   }
 }else{
   include_once '../paginas/login.html';
 }








 ?>
