<?php 
    /* consulta de talleres */
    //include("../../../../../conexion.php");

    /*prepare querycon formato de fecha 
         $result = $conexion->prepare("SELECT bp.id as Opercion,c.name as Nombre_Cliente,c.lastname as Apellido_Cliente,
    p.name as Producto,p.price as Precio,bp.q as cantidad,ca.name as Categoria,
    pr.nombre as Proveedor, pm.name as Metodo_Pago, b.created_at as Fecha from product p join
        buy_product bp on p.id=bp.id	join
        buy b on bp.buy_id = b.id	   	join
        client c on b.client_id = c.id 	join
        category ca on ca.id = p.category_id 	join
        provider pr on pr.id = p.provider_id 	join
        paymethod pm on pm.id = b.paymethod_id 	join
        user u on u.id= p.user_id 
        where u.id = ?");	
    // Execute si existe el valor consulta
    if (isset($_POST['consulta'])) {
        # code...
        $filtro = $_POST['consulta'];
        $var = "%".$filtro."%";

        $result = $conexion->prepare("SELECT bp.id as Opercion,c.name as Nombre_Cliente,c.lastname as Apellido_Cliente,
        p.name as Producto,p.price as Precio,bp.q as cantidad,ca.name as Categoria,
        pr.nombre as Proveedor, pm.name as Metodo_Pago, b.created_at as Fecha from product p join
            buy_product bp on p.id=bp.id	join
            buy b on bp.buy_id = b.id	   	join
            client c on b.client_id = c.id 	join
            category ca on ca.id = p.category_id 	join
            provider pr on pr.id = p.provider_id 	join
            paymethod pm on pm.id = b.paymethod_id 	join
            user u on u.id= p.user_id 
            where p.name like ? OR p.code like ? OR p.description like ? AND
            ca.id= ? AND pr.id = ? AND u.id=?");    
        if (!$result->execute(array($var, $var, $var,$_POST['category_id'],$_POST['provider_id'],$_SESSION['admin_id']))) {
            echo "An error occurred.\n";
            exit;
        }

    } else {
        //si no se especifica un filtro verifica consulta de todos los productos segun id admin
        if (!$result->execute(array($_SESSION['admin_id']))) {
            echo "An error occurred.\n";
            exit;
        }

    }
    */
   

    /* Encabezado de Tabla */  
    echo "
    <table class=\"table table-bordered\">
    <thead>
      <th></th>
      <th>Operacion</th>
      <th>Cliente</th>
      <th>Producto</th>
      <th>Precio</th>
      <th>Cantidad</th>
      <th>Categoria</th>
      <th>Proveedor</th>
      <th>Metodo de pago</th>
      <th>Fecha</th>
    </thead>
    
    ";
    
    /*Llenar Tabla 
    $correlativo = 1;
    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
        
        echo "
        <tr>
        <td><strong>".$correlativo."</strong></td>
        <td id='id_operacion' data-id_operacion='".$row[Operacion]."'><strong>#".$row[Operacion]."</strong></td>
        <td id='id_cliente' data-id_cliente='".$row[Operacion]."'><strong>".$row[Nombre_Cliente]." ".$row[Apellido_Cliente]."</strong></td>
        <td id='id_producto' data-id_producto='".$row[Operacion]."'><strong>".$row[Producto]."</strong></td>
        <td id='id_precio' data-id_precio='".$row[Operacion]."'><strong>".$row[Precio]."</strong></td>
        <td id='id_cantidad' data-id_cantidad='".$row[Operacion]."'><strong>".$row[cantidad]."</strong></td>
        <td id='id_categoria' data-id_categoria='".$row[Operacion]."'><strong>".$row[Categoria]."</strong></td>
        <td id='id_proveedor' data-id_proveedor='".$row[Operacion]."'><strong>".$row[Proveedor]."</strong></td>
        <td id='id_mpago' data-id_mpago='".$row[Operacion]."'><strong>".$row[Metodo_Pago]."</strong></td>
        <td id='id_fecha' data-id_fecha='".$row[Operacion]."'><strong>".$row[Fecha]."</strong></td>
        
        </tr>
        ";

        $correlativo = $correlativo+1;
    }

    */
    
    /*Fin tabla */
    echo "
	</table> 
    ";

?>