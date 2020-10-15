
<?php

include("../conexion.php");

$bd = conectar();

$USUARIO_ADMINISTRACION='ADMINISTRACION';
$usuario = $_POST['usuario'];
$tipo =  $_POST['tipo'];

 if($tipo == 'dashboardAdminFiltros'){


    $patron =  $_POST['nombre'];
    $fechaInicio =  $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $usuarioTipo = $_POST['usuarioTipo'];

    $filtros = ' ';


    if($patron !='' && $patron !='null'){
      $filtros = $filtros." AND  CORREO LIKE '%$patron%' ";
    }
    if($usuarioTipo !='' && $usuarioTipo !='null'){
      if($usuarioTipo==$USUARIO_ADMINISTRACION){
      $filtros = $filtros." AND  tipo='$usuarioTipo'";
      }else{
        $filtros = $filtros." AND  tipo='$usuarioTipo'";
      }

    }
    if($fechaInicio!='' && $fechaFin == ''){
      $filtros = $filtros." AND Fecha_Creacion>'$fechaInicio' ";
    }else if($fechaInicio=='' && $fechaFin != ''){
      $filtros = $filtros." AND Fecha_Creacion<'$fechaFin' ";
    }else if($fechaInicio!='' && $fechaFin != ''){
      $filtros = $filtros." AND Fecha_Creacion BETWEEN '$fechaInicio' AND '$fechaFin' ";
    }


    $sql = "SELECT
    correo,cuenta_financiera,tarjeta_credito,nombre_completo,codigo_empresa,empresa,usuario,fecha_creacion,tipo,estado ,saldo
    FROM
    CUENTA
    WHERE usuario=usuario AND usuario!='admin'  $filtros ORDER BY Usuario ASC";
    $result= mysqli_query($bd,$sql);

    if($result){
      $mandar['mensaje'] = 'Consulta Exitosa';
      $mandar['datos'] =  $result->fetch_all(MYSQLI_ASSOC);
      $mandar['result'] = true;
      echo json_encode($mandar);
    }else{
      $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION, Detalles: '.mysqli_error($bd);
      $mandar['result'] = false;
      echo json_encode($mandar);
    }
}else if($tipo == 'dashboardAdmin'){
  $sql = "SELECT
  correo,cuenta_financiera,tarjeta_credito,nombre_completo,codigo_empresa,empresa,usuario,fecha_creacion,tipo,estado,saldo
  FROM
  CUENTA
  WHERE Usuario!='admin'
   ORDER BY Usuario ASC";
  $result= mysqli_query($bd,$sql);
  if($result){
    $mandar['mensaje'] = 'Consulta Exitosa';
    $mandar['datos'] =  $result->fetch_all(MYSQLI_ASSOC);
    $mandar['result'] = true;
    echo json_encode($mandar);
  }else{
    $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION, Detalles: '.mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }





}else if($tipo =='habilitar'){
  $id =  $_POST['id'];

  $sql = "UPDATE CUENTA Set Estado='ACTIVO' WHERE CORREO='$id'";
  $result= mysqli_query($bd,$sql);

  if($result){
    $mandar['mensaje'] = 'SE HABILITO CON EXITO EL USUARIO: '.$id;
    $mandar['result'] = true;
     echo json_encode($mandar);
  }else{
    $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION DE HABILIITAR EL USUARIO, Detalles: '.mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }

}else if($tipo =='deshabilitar'){
  $id =  $_POST['id'];

  $sql = "UPDATE CUENTA Set Estado='INACTIVO' WHERE CORREO='$id'";
  $result= mysqli_query($bd,$sql);

  if($result){
    $mandar['mensaje'] = 'SE DESHABILITO CON EXITO EL USUARIO: '.$id;
    $mandar['result'] = true;
     echo json_encode($mandar);
  }else{
    $mandar['mensaje'] = 'ERROR, EXISTIERON PROBLEMAS AL PROCESAR LA PETICION DE DESHABILITACION DEL USUARIO, Detalles: '.mysqli_error($bd);
    $mandar['result'] = false;
    echo json_encode($mandar);
  }

}else{
  $mandar['mensaje'] = 'ERROR, TIPO DE ACCION INCORRECTA';
  $mandar['result'] = false;
  echo json_encode($mandar);
}




exit;

?>
