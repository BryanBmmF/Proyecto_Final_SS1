
<?php
  function conectar(){

  $servidor = "127.0.0.1";
  $usuario = "pventasdba";
  $clave = "Pventasdba$1";
  $base = "db_j3bank";
  $mysql = new mysqli($servidor,$usuario,$clave,$base);
  if($mysql->connect_errno){
    return "no conectado";
  }else{
    return $mysql;
  }
}




?>
