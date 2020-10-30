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
$usuarioEmisor = $_GET['comprador'];
$usuarioReceptor = $_GET['vendedor'];
$descripcion = $_GET['descripcion'];


$banderaUsuarioReceptor = false;
//$banderaUsuarioEmisor = false;

#evalumaos disponibilidad de la cuenta del receptor
$sql = "SELECT estado FROM CUENTA WHERE correo='$usuarioReceptor' ;";
$result = mysqli_query($bd, $sql);
if ($result) {
    $datos = mysqli_fetch_array($result);
    $mostrar = sizeof($datos);
    if ($mostrar > 0) {
        if ($datos['estado'] === $ESTADO_ACTIVO) {
            $banderaUsuarioReceptor = true;
        } else {
            $mandar['mensaje'] = 'ESTADO DEL CORREO RECEPTOR: ' . $usuarioReceptor . ' NO VALIDO. SU ESTADO ACTUAL ES:' . $datos['estado'];
            $mandar['result'] = false;
            $producto[] = array_map('utf8_encode', $mandar); 
            echo json_encode($producto);
        }
    } else {
        $mandar['mensaje'] = 'EL CORREO RECEPTOR: ' . $usuarioReceptor . ' NO EXISTE' . mysqli_error($bd);
        $mandar['result'] = false;
        $producto[] = array_map('utf8_encode', $mandar); 
        echo json_encode($producto);
    }
} else {
    $mandar['mensaje'] = 'PROBLEMAS PARA CONECTAR A LA BASE DE DATOS, DETALLES: ' . mysqli_error($bd);
    $mandar['result'] = false;
    $producto[] = array_map('utf8_encode', $mandar); 
    echo json_encode($producto);
}

#si la cuenta del receptor no tiene ningun problema procedemos a realizar la transaccion
if ($banderaUsuarioReceptor) {
    $bd->autocommit(FALSE);
    $sql = "UPDATE CUENTA SET SALDO=SALDO-$total WHERE correo='$usuarioEmisor' ;";
    $result = mysqli_query($bd, $sql);
    if ($result) {
        $sql = "UPDATE CUENTA SET SALDO=SALDO+$total WHERE correo='$usuarioReceptor' ;";
        $result = mysqli_query($bd, $sql);
        if ($result) {
            $sql = "INSERT INTO TRANSACCION_INTERNA VALUES(null,$total,'$usuarioEmisor','$usuarioReceptor','$descripcion',now());";
            $result = mysqli_query($bd, $sql);
            $codigoTransaccionInterna = $bd->insert_id;
            if ($result) {
                if (!$bd->commit()) {
                    $mandar['mensaje'] = 'NO SE PUDO REGISTRAR LA TRANSACCION INTERNA DEL PORTAL DE VENTAS';
                    $mandar['result'] = false;
                    $producto[] = array_map('utf8_encode', $mandar); 
                    echo json_encode($producto);
                } else {
                    $bd->rollback();
                    $mandar['mensaje'] = 'TRANSACCION REALIZADA CON EXITO, ID DE LA TRANSACCION INTERNA: ' . $codigoTransaccionInterna;
                    $mandar['result'] = true;
                    $producto[] = array_map('utf8_encode', $mandar); 
                    echo json_encode($producto);
                }
            } else {
                $bd->rollback();
                $mandar['mensaje'] = 'NO SE PUDO REGISTRAR LA TRANSACCION INTERNA, PERO SI SE REALIZO EL MOVIMIENTO DEL DINERO';
                $mandar['result'] = false;
                $producto[] = array_map('utf8_encode', $mandar); 
                echo json_encode($producto);
            }
        } else {
            $bd->rollback();
            $mandar['mensaje'] = 'NO SE PUDO ACTUALIZAR EL SALDO EN LA CUENTA DEL VENDEDOR: ' . $usuarioEmisor;
            $mandar['result'] = false;
            $producto[] = array_map('utf8_encode', $mandar); 
            echo json_encode($producto);
        }
    } else {
        $bd->rollback();
        $mandar['mensaje'] = 'NO SE PUDO ACTUALIZAR EL SALDO EN LA CUENTA DEL COMPRADOR: ' . $usuarioEmisor;
        $mandar['result'] = false;
        $producto[] = array_map('utf8_encode', $mandar); 
        echo json_encode($producto);
    }
}
$bd->autocommit(TRUE);
