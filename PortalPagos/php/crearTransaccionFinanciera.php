<?php

include("../conexion.php");

$bd = conectar();


$ACREDITACION = 'ACREDITACION';
$RETIRO = 'RETIRO';


$cuentaInvolucrada = $_POST['cuentaInvolucrada']; // LA CUENTA A LA QUE LE ASIGNARA PISTO
$monto = $_POST['monto']; // 100 
$impuestos = $_POST['impuestos']; // 0
$total = $_POST['total']; // MONTO
$tipo = $_POST['tipo'];// ACREDITACION
$tipoMetodo =$_POST['tipoMetodo']; // CUENTA O TARJETA
$numeroMetodoPago = $_POST['numeroMetodoPago']; // NUMERO DE LA TARJETA O DE LA CUENTA
$numeroTransaccionPortalFinanciero = $_POST['numeroTransaccionPortalFinanciero']; //



$sql = "INSERT INTO TRANSACCION_FINANCIERA VALUES(null,'$cuentaInvolucrada',$monto,$impuestos,$total,'$tipo',now(),'$tipoMetodo',$numeroMetodoPago,$numeroTransaccionPortalFinanciero);";
$result= mysqli_query($bd,$sql);
$codigoTransaccionFinanciera = $bd->insert_id;
  if($result){
    if($tipo === $ACREDITACION){
        $sql2 = "UPDATE CUENTA SET SALDO=SALDO+$total WHERE CORREO='$cuentaInvolucrada';";
    }else if($tipo === $RETIRO){
        $sql2 = "UPDATE CUENTA SET SALDO=SALDO-$total WHERE CORREO='$cuentaInvolucrada';";
    }
      $result2= mysqli_query($bd,$sql2);
      if($result2){
        $sql3 = "SELECT SALDO FROM CUENTA WHERE CORREO='$cuentaInvolucrada'";
        $result3= mysqli_query($bd,$sql3);
        if($result3){
            $datos =mysqli_fetch_array($result);
            $mandar['mensaje'] = 'SE CREO CON EXITO LA TRANSACCION FINANCIERA EN EL PORTAL DE PAGOS';
            $mandar['correo'] = $correo;
            $mandar['saldo'] = $datos['SALDO'];
            $mandar['codigoTransaccionFinanciera'] = $codigoTransaccionFinanciera;
            $mandar['result'] = true;
            echo json_encode($mandar);
        }else{
            $mandar['mensaje'] = 'NO SE PUDO OBTENER EL SALDO EN EL PORTAL DE PAGOS, Detalles: '. mysqli_error($bd);
            $mandar['result'] = false;
            echo json_encode($mandar);
        }

      }else{
        $mandar['mensaje'] = 'NO SE PUDO ACTUALIZAR EL SALDO EN EL PORTAL DE PAGOS, Detalles: '. mysqli_error($bd);
        $mandar['result'] = false;
        echo json_encode($mandar);
      }
      

  }else{
    $mandar['mensaje'] = 'NO SE PUDO CREAR LA TRANSACCION_FINANCIERA EN EL PORTAL DE PAGOS, Detalles: '. mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }
  
  
 ?>
