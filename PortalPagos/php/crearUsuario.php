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


$tipoMetodoPago = $_POST['tipoMetodoPago'];
$numeroMetodoPago = $_POST['numeroMetodoPago'];
$contrasena = $_POST['contrasena'];
$nombre = $_POST['nombre'];
$empresa = $_POST['empresa'];
$usuario = $_POST['usuario'];
$tipoUsuario = $_POST['tipoUsuario'];
$contrasenaHash = md5($contrasena);
$codigoEmpresa = '';

if ($tipoUsuario === $TIPO_USUARIO_EMPRESA) {

  $sql = "SELECT codigo_empresa FROM EMPRESA WHERE nombre_empresa='$empresa' ;";
  $result = mysqli_query($bd, $sql);
  if ($result) {
    $datos = mysqli_fetch_array($result);
    $mostrar = sizeof($datos);
    if ($mostrar > 0) {
      $codigoEmpresa = $datos['codigo_empresa'];
    } else {
      $sql2 = "INSERT INTO EMPRESA(nombre_empresa) VALUES('$empresa') ;";
      $result2 = mysqli_query($bd, $sql2);
      $codigoEmpresa = $bd->insert_id;
    }

    $correo = $usuario . '.' . $codigoEmpresa . '@' . $empresa . '.com';
    if ($tipoMetodoPago === $METODO_PAGO_CUENTA) {
      $sql = "INSERT INTO CUENTA VALUES('$correo','$numeroMetodoPago',null,'$contrasenaHash','$nombre',$codigoEmpresa,'$empresa','$usuario',$SALDO_INICIAL,now(),now(),'$tipoUsuario','$ESTADO_ACTIVO');";
    } else {
      $sql = "INSERT INTO CUENTA VALUES('$correo',null,$numeroMetodoPago,'$contrasenaHash','$nombre',$codigoEmpresa,'$empresa','$usuario',$SALDO_INICIAL,now(),now(),'$tipoUsuario','$ESTADO_ACTIVO');";
    }
    $result = mysqli_query($bd, $sql);
    if ($result) {
      $mandar['mensaje'] = 'SE CREO CON EXITO LA CUENTA EN EL PORTAL DE PAGOS';
      $mandar['correo'] = $correo;
      $mandar['result'] = true;
      echo json_encode($mandar);
    } else {
      $mandar['mensaje'] = 'NO SE PUDO CREAR LA CUENTA, Detalles: ' . mysqli_error($bd);
      $mandar['result'] = false;
      echo json_encode($mandar);
    }
  } else {
    $mandar['mensaje'] = 'NO SE PUDO CREAR LA EMPRESA, Detalles: ' . mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }
} else if ($tipoUsuario === $TIPO_USUARIO_ADMINISTRADOR) {
  $sql = "SELECT codigo_empresa FROM EMPRESA WHERE nombre_empresa='$empresa' ;";
  $result = mysqli_query($bd, $sql);
  if ($result) {
    $datos = mysqli_fetch_array($result);
    $mostrar = sizeof($datos);
    if ($mostrar > 0) {
      $codigoEmpresa = $datos['codigo_empresa'];
    } else {
      $sql2 = "INSERT INTO EMPRESA(nombre_empresa) VALUES('$empresa') ;";
      $result2 = mysqli_query($bd, $sql2);
      $codigoEmpresa = $bd->insert_id;
    }

    $correo = $usuario . '.' . $codigoEmpresa . '@' . $empresa . '.com';
    
    $sql = "INSERT INTO CUENTA VALUES('$correo',null,null,'$contrasenaHash','$nombre',$codigoEmpresa,'$empresa','$usuario',$SALDO_INICIAL,now(),now(),'$tipoUsuario','$ESTADO_ACTIVO');";
    
    $result = mysqli_query($bd, $sql);
    if ($result) {
      $mandar['mensaje'] = 'SE CREO CON EXITO LA CUENTA DE ADMINSITRADOR EN EL PORTAL DE PAGOS';
      $mandar['correo'] = $correo;
      $mandar['result'] = true;
      echo json_encode($mandar);
    } else {
      $mandar['mensaje'] = 'NO SE PUDO CREAR LA CUENTA, Detalles: ' . mysqli_error($bd);
      $mandar['result'] = false;
      echo json_encode($mandar);
    }
  } else {
    $mandar['mensaje'] = 'NO SE PUDO CREAR LA EMPRESA, Detalles: ' . mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }
}








/* $sql = "INSERT INTO usuario(Usuario,Contrasena,NombreCompleto,FechaNacimiento,CorreoELectronico,ImagenPerfil,NivelConfianza,TipoUsuario,Estado) VALUES ('$usuario','$contrasenaHash','$nombreCompleto','$fechaNacimiento','$correo','$imagenPerfil',$nivelConfianza,$tipo,1)";
$resultado= mysqli_query($bd,$sql);

if($resultado){
$mandar['mensaje'] = "Se creo correctamente el usuario";
$mandar['result'] = true;
 echo json_encode($mandar);
}else{
  $mandar['mensaje'] = mysqli_error($bd);
  $mandar['result'] = false;
  echo json_encode($mandar);
} */
