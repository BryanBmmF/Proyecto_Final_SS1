
<?php
  function conectar(){

  $servidor = "127.0.0.1";
  $usuario = "jp";
  $clave = "Suchi123!";
  $base = "portal_pagos";
  $mysql = new mysqli($servidor,$usuario,$clave,$base);
  if($mysql->connect_errno){
    return "no conectado";
  }else{
    return $mysql;
  }
}




?>