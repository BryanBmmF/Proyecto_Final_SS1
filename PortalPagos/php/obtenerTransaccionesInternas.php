<?php

include("../conexion.php");

$bd = conectar();


$TIPO_PERSONAL = 'PERSONAL';
$TIPO_GLOBAL = 'GLOBAL';


$correo = $_POST['usuario'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$tipo = $_POST['tipo'];

$filtros = ' ';

  if($fechaInicio!='' && $fechaFin == ''){
    $filtros = $filtros." AND fecha_transaccion>'$fechaInicio' ";
  }else if($fechaInicio=='' && $fechaFin != ''){
    $filtros = $filtros." AND fecha_transaccion<'$fechaFin' ";
  }else if($fechaInicio!='' && $fechaFin != ''){
    $filtros = $filtros." AND fecha_transaccion BETWEEN '$fechaInicio' AND '$fechaFin' ";
  }

if($tipo === $TIPO_PERSONAL){
    $filtros = $filtros." AND ( cuenta_emisora='$correo' ||  cuenta_receptora='$correo')"; 
}

$sql = "SELECT * FROM TRANSACCION_INTERNA WHERE ID IS NOT NULL $filtros;";
$result= mysqli_query($bd,$sql);
  if($result){
    $mandar['mensaje'] = $sql;
    $mandar['datos'] =  $result->fetch_all(MYSQLI_ASSOC);
    $mandar['result'] = true;
    echo json_encode($mandar);
  }else{
    $mandar['mensaje'] = 'NO SE PUDIERON OBTENER LAS TRANSACCIONES INTERNAS A PETICION DEL USUARIO: $correo, Detalles: '. mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }
  
  
 ?>