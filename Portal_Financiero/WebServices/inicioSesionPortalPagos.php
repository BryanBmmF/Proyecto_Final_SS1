<?php
/* header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true"); */

include("../conexion.php");

$bd = conectar();


$METODO_PAGO_CUENTA = 'CUENTA';
$METODO_PAGO_TARJETA = 'TARJETA';
$ESTADO_TARJETA_ACTIVA = 'ACTIVA';
$ESTADO_TARJETA_DESACTIVADA = 'DESACTIVADA';

$ESTADO_CUENTA_ACTIVA = 'activa';
$ESTADO_CUENTA_DESACTIVADA = 'desactivada';

$metodoPago = $_POST['metodoPago'];




if($metodoPago === $METODO_PAGO_CUENTA){
  $usuarioFinanciero = $_POST['usuarioFinanciero'];
  $contrasenaUsuarioFinanciero = $_POST['contrasenaUsuarioFinanciero'];
  $noCuenta = $_POST['noCuenta'];
  $contrasenaHash = md5($contrasenaUsuarioFinanciero);


  $sql = "SELECT J1.NO_CUENTA_BANCARIA, J1.ESTADO FROM CUENTA AS J1 INNER JOIN USUARIO_CLIENTE AS J2 WHERE J1.DPI_CLIENTE=J2.DPI_CLIENTE AND J2.USUARIO_CLIENTE='$usuarioFinanciero' AND CONTRASENA='$contrasenaHash' AND NO_CUENTA_BANCARIA='$noCuenta';";
  $result= mysqli_query($bd,$sql);
  if($result){

    $datos =mysqli_fetch_array($result);
    $mostrar=sizeof($datos);

    if($mostrar>0){
    
      if($datos['ESTADO'] === $ESTADO_CUENTA_ACTIVA){
        $mandar['mensaje'] = 'INICIO DE SESION EXITOSO';
        $mandar['numeroCuenta'] = $datos['NO_CUENTA_BANCARIA'];
        $mandar['tipoMetodoPago'] = 'CUENTA';
        $mandar['result'] = true;
        echo json_encode($mandar);
      }else{
        $error['mensaje'] = 'LA CUENTA ESTA INACTIVA, POR LO TANTO NO SE PUEDE ASOCIAR A UNA CUENTA DEL PORTAL DE PAGOS';
        $error['result'] = false;
        echo json_encode($error);
      }
    }else{
        $error['mensaje'] = 'NO COINCIDEN LOS DATOS POR FAVOR VERIFICALOS, POR LO TANTO NO SE PUEDE ASOCIAR A UNA CUENTA DEL PORTAL DE PAGOS';
        $error['result'] = false;
        echo json_encode($error);
    }

    
    
  }else{
    $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION, Detalles: '.mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }



}else if($metodoPago === $METODO_PAGO_TARJETA){
  $noTarjeta = $_POST['noTarjeta'];
  $dpi = $_POST['dpi'];
  $fechaVencimiento = $_POST['fechaVencimiento'];
  $codigoCVC = $_POST['codigoCVC'];
  $sql = "SELECT no_tarjeta, ESTADO FROM TARJETA WHERE NO_TARJETA='$noTarjeta' AND DPI_CUENTA_HABIENTE='$dpi' AND DATE_FORMAT(FECHA_VENCIMIENTO, '%Y-%m-%d')='$fechaVencimiento' AND CODIGOCVC='$codigoCVC';";
  $result= mysqli_query($bd,$sql);
  if($result){

    $datos =mysqli_fetch_array($result);
    $mostrar=sizeof($datos);

    if($mostrar>0){
    
      if($datos['ESTADO'] === $ESTADO_TARJETA_ACTIVA){
        $mandar['mensaje'] = 'INICIO DE SESION EXITOSO';
        $mandar['numeroCuenta'] = $datos['no_tarjeta'];
        $mandar['tipoMetodoPago'] = 'TARJETA';
        $mandar['result'] = true;
        echo json_encode($mandar);
      }else{
        $error['mensaje'] = 'LA TARJETA DE CREDITO ESTA INACTIVA, POR LO TANTO NO SE PUEDE ASOCIAR A UNA CUENTA DEL PORTAL DE PAGOS';
        $error['result'] = false;
        echo json_encode($error);
      }
    }else{
        $error['mensaje'] = 'NO COINCIDEN LOS DATOS POR FAVOR VERIFICALOS, POR LO TANTO NO SE PUEDE ASOCIAR A UNA TARJETA A LA CUENTA DEL PORTAL DE PAGOS';
        $error['result'] = false;
        echo json_encode($error);
    }

    
    
  }else{
    $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION, Detalles: '.mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }


  
  

}else{
    $noExiste['mensaje'] = 'NO EXISTE EL METODO DE PAGO POR '.$metodoPago.', NO ESTA SOPORTADO. ERROR: '.mysqli_error($bd);
    $noExiste['result'] = false;
    echo json_encode($noExiste);

}





 ?>


