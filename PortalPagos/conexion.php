
<?php
  function conectar(){

  $servidor = "localhost";
  $usuario = "pventasdba";
  $clave = "Pventasdba$1";
  $base = "portal_pagos";
  $mysql = new mysqli($servidor,$usuario,$clave,$base);
  if($mysql->connect_errno){
    return "no conectado";
  }else{
    return $mysql;
  }
}




?>
