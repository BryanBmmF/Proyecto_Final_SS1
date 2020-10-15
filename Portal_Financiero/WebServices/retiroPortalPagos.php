<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
include("../conexion.php");

$bd = conectar();


$METODO_PAGO_CUENTA = 'CUENTA';
$METODO_PAGO_TARJETA = 'TARJETA';
$ESTADO_TARJETA_ACTIVA = 'ACTIVA';
$ESTADO_TARJETA_DESACTIVADA = 'DESACTIVADA';

$ESTADO_CUENTA_ACTIVA = 'activa';
$ESTADO_CUENTA_DESACTIVADA = 'desactivada';

$INGRESO = 'INGRESO';
$RETIRO = 'RETIRO';




$tipoMetodoPago = $_POST['tipoMetodoPago'];


if ($tipoMetodoPago === $METODO_PAGO_CUENTA) {
    $numeroCuenta = $_POST['numeroCuenta'];
    $tipoAccion = $_POST['tipoAccion'];
    $monto = $_POST['monto'];
    $correo = $_POST['correo'];

    $sql = "SELECT NO_CUENTA_BANCARIA, ESTADO, SALDO FROM CUENTA WHERE NO_CUENTA_BANCARIA='$numeroCuenta';";
    $result = mysqli_query($bd, $sql);
    if ($result) {

        $datos = mysqli_fetch_array($result);
        $mostrar = sizeof($datos);

        if ($mostrar > 0) {

            if ($datos['ESTADO'] === $ESTADO_CUENTA_ACTIVA) {

                if ($tipoAccion === $INGRESO) {
                    $tipo = 'DEBITO';
                    $saldoActual = $datos['SALDO'];

                    $saldoResultante = $saldoActual - $monto;
                    if ($saldoResultante >= 0) {
                        $sql2 = "CALL actualizarSaldoCuenta('$tipo',$monto,'$numeroCuenta');";
                        $result2 = mysqli_query($bd, $sql2);
                        if ($result2) {
                            //RETIRO DE DINERO HACIA CUENTA DEL PORTAL DE PAGOS
                            //RETIRO DE DINERO HACIA CUENTA: $correo DEL PORTAL DE PAGOS
                            $sql3 = "INSERT INTO MOVIMIENTO_MONETARIO (NO_CUENTA,MONTO,FECHA,TIPO,DESCRIPCION) VALUES('$numeroCuenta',$monto,now(),'$tipo','RETIRO DE DINERO HACIA CUENTA: $correo DEL PORTAL DE PAGOS');";
                            $result3 = mysqli_query($bd, $sql3);
                            if ($result3) {
                                $codigoTransaccion = $bd->insert_id;
                                $mandar['mensaje'] = 'SE REALIZO CON EXITO LA TRANSACCION ';
                                $mandar['codigoTransaccion'] = $codigoTransaccion;
                                $mandar['result'] = true;
                                echo json_encode($mandar);
                            } else {
                                $error['mensaje'] = 'SURGIO UN ERROR AL REGISTRAR EL MOVIMIENTO MONETARIO DE LA CUENTA: ' . $numeroCuenta . ', SI SE REALIZO LA ACCION EN LA CUENTA' . mysqli_error($bd);
                                $error['result'] =  false;
                                echo json_encode($error);
                            }
                        } else {
                            $error['mensaje'] = 'SURGIO UN ERROR AL ACTUALIZAR EL SALDO EN LA CUENTA: ' . $numeroCuenta . ' POR LO TANTO NO SE REALIZO LA ACCION';
                            $error['result'] =  false;
                            echo json_encode($error);
                        }
                    } else {
                        $error['mensaje'] = 'ERROR, EL SALDO  DE LA CUENTA ' . $numeroCuenta . ' ES INSUFICIENTE, POR LO TANTO NO SE REALIZO LA ACCION';
                        $error['result'] =  false;
                        echo json_encode($error);
                    }
                } else if ($tipoAccion === $RETIRO) {
                } else {
                    $error['mensaje'] = 'LA ACCION SOBRE LA CUENTA: ' . $tipoAccion . ' NO EXISTE, POR LO TANTO NO SE PUEDE REALIZAR NINGUNA ACCION';
                    $error['result'] =  false;
                    echo json_encode($error);
                }
            } else {
                $error['mensaje'] = 'LA CUENTA ESTA INACTIVA, POR LO TANTO NO SE PUEDE REALIZAR LA ACCION DE: ' . $tipoAccion . ' EN LA CUENTA';
                $error['result'] = false;
                echo json_encode($error);
            }
        } else {
            $error['mensaje'] = 'NO EXISTE LA CUENTA BANCARIA, POR FAVOR VERIFICA LOS DATOS.';
            $error['result'] = false;
            echo json_encode($error);
        }
    } else {
        $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION, Detalles: ' . mysqli_error($bd);
        $mandar['result'] = false;
        echo json_encode($mandar);
    }
} else if ($tipoMetodoPago === $METODO_PAGO_TARJETA) {
    $numeroTarjeta = $_POST['numeroTarjeta'];
    $tipoAccion = $_POST['tipoAccion'];
    $monto = $_POST['monto'];
    $correo = $_POST['correo'];

    $sql = "SELECT NO_TARJETA, ESTADO, DEUDA_ACTUAL,TASA_INTERES,LIMITE FROM TARJETA WHERE NO_TARJETA='$numeroTarjeta';";
    $result = mysqli_query($bd, $sql);
    if ($result) {
        $datos = mysqli_fetch_array($result);
        $mostrar = sizeof($datos);

        if ($mostrar > 0) {

            if ($datos['ESTADO'] === $ESTADO_TARJETA_ACTIVA) {
                if ($tipoAccion === $INGRESO) {
                    $tipo = 'DEBITO';
                    $deudaActual = $datos['DEUDA_ACTUAL'];
                    $limite = $datos['LIMITE'];
                    $tasaInteres = $datos['TASA_INTERES'];
                    $interes = ($monto*$tasaInteres);
                    $subtotal = $monto + $interes;
                    $deudaResultante = $deudaActual + $subtotal;
                    if($deudaResultante<=$limite){
                        //DDDDDDDDDDD
                        $sql2 = "UPDATE TARJETA SET DEUDA_ACTUAL=DEUDA_ACTUAL+$subtotal WHERE NO_TARJETA=$numeroTarjeta;";
                        $result2 = mysqli_query($bd, $sql2);
                        if ($result2) {
                            
                            $sql3 = "INSERT INTO TRANSACCION_TARJETA VALUES(null,'$numeroTarjeta',$monto,$interes,$subtotal,now());";
                            $result3 = mysqli_query($bd, $sql3);
                            if ($result3) {
                                $codigoTransaccion = $bd->insert_id;
                                $mandar['mensaje'] = 'SE REALIZO CON EXITO LA TRANSACCION DESDE LA TARJETA DE CREDITO:'.$numeroTarjeta;
                                $mandar['codigoTransaccion'] = $codigoTransaccion;
                                $mandar['result'] = true;
                                echo json_encode($mandar);
                            } else {
                                $error['mensaje'] = 'SURGIO UN ERROR AL REGISTRAR LA TRANSACCION DE LA TARJETA DE CREDITO: ' . $numeroTarjeta . ', SI SE REALIZO LA ACCION EN LA TARJETA DE CREDITO' . mysqli_error($bd);
                                $error['result'] =  false;
                                echo json_encode($error);
                            }
                        } else {
                            $error['mensaje'] = 'SURGIO UN ERROR AL ACTUALIZAR EL SALDO EN LA TARJETA DE CREDITO: ' . $numeroTarjeta . ' POR LO TANTO NO SE REALIZO LA ACCION';
                            $error['result'] =  false;
                            echo json_encode($error);
                        }
                        //DDDDDDDDD

                    } else {
                        $error['mensaje'] = 'ERROR, EL SALDO DE LA TARJETA DE CREDITO: ' . $numeroTarjeta . ' ES INSUFICIENTE, POR LO TANTO NO SE REALIZO LA ACCION';
                        $error['result'] =  false;
                        echo json_encode($error);
                    }

                }else if ($tipoAccion === $RETIRO) {

                } else {
                    $error['mensaje'] = 'LA ACCION SOBRE LA TARJETA DE CREDITO: ' . $tipoAccion . ' NO EXISTE, POR LO TANTO NO SE PUEDE REALIZAR NINGUNA ACCION';
                    $error['result'] =  false;
                    echo json_encode($error);
                }

            } else {
                $error['mensaje'] = 'LA TARJETA DE CREDITO ESTA INACTIVA, POR LO TANTO NO SE PUEDE REALIZAR LA ACCION DE: ' . $tipoAccion . ' EN LA CUENTA';
                $error['result'] = false;
                echo json_encode($error);
            }

        } else {
            $error['mensaje'] = 'NO EXISTE LA TARJETA DE CREDITO, POR FAVOR VERIFICA LOS DATOS.';
            $error['result'] = false;
            echo json_encode($error);
        }

    } else {
        $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION, Detalles: ' . mysqli_error($bd);
        $mandar['result'] = false;
        echo json_encode($mandar);
    }
} else {
    $noExiste['mensaje'] = 'NO EXISTE EL METODO DE PAGO POR ' . $tipoMetodoPago . ', NO ESTA SOPORTADO. ERROR: ' . mysqli_error($bd);
    $noExiste['result'] = false;
    echo json_encode($noExiste);
}
?>