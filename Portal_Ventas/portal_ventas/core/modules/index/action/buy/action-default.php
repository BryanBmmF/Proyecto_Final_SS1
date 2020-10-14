<?php
// print_r($_SESSION);
session_start(); // para jalar datos de sesion
include("admin/conexion.php");

if(!empty($_POST) && isset($_SESSION["client_id"])){
$buy = new BuyData();

$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
$code = "";
$k = "";
for($i=0;$i<11;$i++){
    $code .= $alphabeth[rand(0,strlen($alphabeth)-1)];
    $k .= $alphabeth[rand(0,strlen($alphabeth)-1)];
}

$buy->k = $k;
$buy->code = $code;
$buy->coupon_id = isset($_SESSION["coupon"])?$_SESSION["coupon"]:"NULL";
$buy->client_id = $_SESSION["client_id"];
$buy->paymethod_id= $_POST["paymethod_id"];
$buy->status_id= 1;


/**
 * Antes hacer cualquier registro de compra se deben comprobar los pasos siguientes, al igual que las consultas
 * 	1. Recuprerar correo del usurio que esta loguedo haciendo la compra
 * 	2. consultar saldo del usuario que esta haciendo la compra y si le alcanza para el total a pagar
 * 	3. si no hay ningun problema con el usuario que esta haciendo la compra
 * 		3.1 recorrer el carrito y consultar los datos asociados al producto como su vendedor
 * 		3.2 hacer una transaccion por cada producto ya que son diferentes vendedores
 * 		3.3 media vez se recorre todo el carrito y no hay ningun fallo se prosigue con el flujo normal
 * 		3.4 si hay algun falo se para toda operacion con un exit en este archivo php
 */

$result = $conexion->prepare("SELECT * FROM client WHERE id = ?");
if (!$result->execute(array($_SESSION['client_id']))) {
	echo "An error occurred.\n";
	print "<script>alert('Error en consulta del usuario del portal de pagos del cliente');</script>";
	exit;
} else {
	#si todo va bien recuperamos los datos del usuario logueado junto al usuario ppagos a consultar
	$row = $result->fetch(PDO::FETCH_BOTH);
	$user_ppagos = $row[username_pp];

	#calculamos el total de toda la compra
	foreach($_SESSION["cart"] as $s):
		$p = ProductData::getById($s["product_id"]);
		$total += $s["q"]*$p->price;
	endforeach;

	#ahora consultamos a la webservice si el usuario cuenta con saldo suficiente
	$url = "http://localhost/Proyecto_Final_SS1/PortalPagos/WebServices/verificarEstadoCliente.php?comprador=$user_ppagos&total=$total";
	$data = json_decode(file_get_contents($url), true );

	//recorriendo el array devuelto
	$respuesta = "";
	$result = "";
	foreach ($data as $res) {
		foreach ($res as $key => $value){
			switch ($key) {
				case 'mensaje':
					$respuesta = $value;
					break;
				case 'result':
					$result = $value;
					break;
			}
		}	
	}

	if ($result) {
		# No hay ningun problema en hacer la transaccion
		
		#recorremos el carrito de transacciones para registrar las transferencias en el portal de pagos
		foreach($_SESSION["cart"] as $s):
			$p = ProductData::getById($s["product_id"]);
			#hacemos cada transaccion de cada producto
			$codigo = $p->code;
			$nombre_producto = $p->name;
			$cantidad = $s["q"];
			$precio = $p->price;
			$total = $s["q"]*$p->price;

			#recuperamos primero el usario_ppagos del vendedor del producto en cuestion a quien se le acreditara el valor de su producto
			$result = $conexion->prepare("SELECT * FROM product p join user u on p.user_id = u.id WHERE p.id = ?");
			$result->execute(array($s["product_id"]));
			$row = $result->fetch(PDO::FETCH_BOTH);
			$vendedor_ppagos = $row[username_pp];

			#$descripcion = "Compra del Producto ".$nombre_producto." con codigo: ".$codigo." cantidad: ".$cantidad." precio/u: ".$precio." total-pago: ".$total;
			$descripcion = "Nueva-Compra-Venta";

			#ahora consultamos a la webservice para registrar la transaccion de cada producto dentro del carrito de compras
			$url = "http://localhost/Proyecto_Final_SS1/PortalPagos/WebServices/realizarPagoPortalVentas.php?comprador=$user_ppagos&vendedor=$vendedor_ppagos&descripcion=$descripcion&total=$total";
			$data = json_decode(file_get_contents($url), true );

			//recorriendo el array devuelto
			$respuesta = "";
			$result = "";
			foreach ($data as $res) {
				foreach ($res as $key => $value){
					switch ($key) {
						case 'mensaje':
							$respuesta = $value;
							break;
						case 'result':
							$result = $value;
							break;
					}
				}	
			}

			if ($result) {
				# si todo salio bien en la transaccion
				print "<script>alert('".$respuesta."');</script>";
			} else {
				# hay problemas en realizar la transaccion
				print "<script>alert('".$respuesta."');</script>";
				Core::redir("index.php?view=mycart");
				exit;
			}

		endforeach;

	} else {
		# hay problemas en realizar la transaccion
		print "<script>alert('".$respuesta."');</script>";
		Core::redir("index.php?view=mycart");
		exit;
	}

}

#Se sigue el flujo normal
$b = $buy->add();

foreach ($_SESSION["cart"] as $c) {
	$p = new BuyProductData();
	$p->buy_id = $b[1];
	$p->product_id = $c["product_id"];
	$p->q = $c["q"];
	$p->add();
}


/////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Emailing
$client = ClientData::getById($_SESSION["client_id"]);
$adminemail = 	$paypal_business = ConfigurationData::getByPreffix("general_main_email")->val;


$replymessage = '
<meta content="es-mx" http-equiv="Content-Language" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<h2>Tienda en Linea</h2>
<h3>Compra Pendiente</h3>
<p><span class="style3"><strong>Estimado '. $client->getFullname() .'</strong></span></p>
<p>Se a agregado una compra a tu lista de pendientes, te invitamos a seguir el procedimiento de pago correspondiente para recibir tus productos.</p>
<p>Gracias por tu compra.</p>
<hr>
<p>Powered By <a href="http://evilnapsis.com/product/katana/" target="_blank"> Katana PRO</a></p>
</body>';

$products = BuyProductData::getAllByBuyId($b[1]);
$data = "";
$total = 0;
foreach ($products as $px) {
	$product = $px->getProduct();
	$data .= "<tr>";
	$data .= "<td>$px->q</td>";
	$data .= "<td>$product->name</td>";
	$data .= "<td> $".number_format($product->price,2,".",",")."</td>";
	$data .= "<td> $".number_format($px->q*$product->price,2,".",",")."</td></tr>";
	$total+= $px->q*$product->price;
}

$themessage = '
<meta content="es-mx" http-equiv="Content-Language" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<h1>Tienda en linea</h1>
<h3>Nueva compra pendiente</h3>
<h4>Cliente: '.$client->getFullname().'</h4>
<table align="center" border=1 cellspacing="4" class="style2" style="width: 700">
	<tr>
		<td>Cant.</td><td>Producto</td><td>P.U</td><td>Total</td>
	</tr>
	'.$data.'
</table>
<h3>Total = $ '.number_format($total,2,".",",").' </h3>
<hr>
<p>Powered By <a href="http://evilnapsis.com/product/katana/" target="_blank"> Katana </a></p>
</body>';

mail("$adminemail",
     "Nueva compra Pendiente",
     "$themessage",
	 "From: $adminemail\nReply-To: $adminemail\nContent-Type: text/html; charset=ISO-8859-1");

mail("$client->email",
     "Nueva compra Pendiente",
     "$replymessage",
	 "From: $adminemail\nReply-To: $adminemail\nContent-Type: text/html; charset=ISO-8859-1");

/////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////



unset($_SESSION["cart"]);
unset($_SESSION["coupon"]);

Core::redir("index.php?view=client");
}
?>