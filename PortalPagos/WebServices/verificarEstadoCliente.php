<?php

include("../conexion.php");

$bd = conectar();

$TIPO_USUARIO_EMPRESA = 'EMPRESA';
$TIPO_USUARIO_ADMINISTRADOR = 'ADMINISTRACION';
$ESTADO_ACTIVO = 'ACTIVO';
$ESTADO_INACTIVO = 'INACTIVO';
$SALDO_INICIAL = 0;
$METODO_PAGO_CUENTA = 'CUENTA';
$METODO_PAGO_TARJETA = 'TARJETA';


$total = $_GET['total'];
$usuarioEmisor = $_GET['comprador']; //correo del comprador

#Evaluamos la dispinibilidad de saldo y la cuenta
$sql = "SELECT estado,saldo FROM CUENTA WHERE correo='$usuarioEmisor' ;";
$result = mysqli_query($bd, $sql);
if ($result) {
    $datos = mysqli_fetch_array($result);
    $mostrar = sizeof($datos);
    if ($mostrar > 0) {
        if ($datos['estado'] === $ESTADO_ACTIVO) {
            if ($datos['saldo'] >= $total) {
                $mandar['mensaje'] = 'SI TIENE SALDO';
                $mandar['result'] = true;
                $producto[] = array_map('utf8_encode', $mandar); 
                echo json_encode($producto);
            } else {
                $mandar['mensaje'] = 'SALDO INSUFICIENTE, POR FAVOR RECARGA FONDOS ANTES DE REALIZAR EL PAGO';
                $mandar['result'] = false;
                $producto[] = array_map('utf8_encode', $mandar); 
                echo json_encode($producto);
            }
        } else {
            $mandar['mensaje'] = 'Es posible que tus datos hayan sido actualizados, porfavor revisa tus credenciales' . $datos['estado'];
            $mandar['result'] = false;
            $producto[] = array_map('utf8_encode', $mandar); 
            echo json_encode($producto);
        }
    } else {
        $mandar['mensaje'] = 'Ocurrió un error al hacer la transacción, porfavor intente mas tarde' . mysqli_error($bd);
        $mandar['result'] = false;
        $producto[] = array_map('utf8_encode', $mandar); 
        echo json_encode($producto);
    }
} else {
    $mandar['mensaje'] = 'PROBLEMAS EN EL SERVIDOR, DETALLES ' . mysqli_error($bd);
    $mandar['result'] = false;
    $producto[] = array_map('utf8_encode', $mandar); 
    echo json_encode($producto);
}



?>