<?php

include("../conexion.php");

$bd = conectar();

$cuentaInvolucrada = $_POST['cuentaInvolucrada'];


$sql = "SELECT SALDO FROM CUENTA WHERE CORREO='$cuentaInvolucrada'";
$result= mysqli_query($bd,$sql);

  if($result){
        $datos =mysqli_fetch_array($result);
        $mandar['saldo'] = $datos['SALDO'];
        $mandar['result'] = true;
        echo json_encode($mandar);
  }else{
    $mandar['mensaje'] = 'NO SE PUDO CONSULTAR EL SALDO PARA ACTUALIZARLO EN EL PORTAL DE PAGOS, Detalles: '. mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }
