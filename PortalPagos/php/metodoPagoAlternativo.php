<?php

include("../conexion.php");

$bd = conectar();


$ACREDITACION = 'ACREDITACION';
$RETIRO = 'RETIRO';

$METODO_PAGO_TARJETA='TARJETA';
$METODO_PAGO_CUENTA='CUENTA';

$usuario = $_POST['usuario'];
$tipoMetodoPago = $_POST['tipoMetodoPago'];
$numeroMetodoPago = $_POST['numeroMetodoPago'];


if($tipoMetodoPago===$METODO_PAGO_CUENTA){
    $sql = "UPDATE CUENTA SET cuenta_financiera='$numeroMetodoPago' WHERE CORREO='$usuario';";
}else{
    $sql = "UPDATE CUENTA SET tarjeta_credito='$numeroMetodoPago' WHERE CORREO='$usuario';";
}
$result= mysqli_query($bd,$sql);
  if($result){
    $mandar['mensaje'] = 'SE VINCULO CORRECTAMENTE EL METODO DE PAGO';
    $mandar['result'] = true;
    echo json_encode($mandar);
  }else{
    $mandar['mensaje'] = 'NO SE PUDO CREAR LA TRANSACCION_FINANCIERA EN EL PORTAL DE PAGOS, Detalles: '. mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }
  
  
 ?>
