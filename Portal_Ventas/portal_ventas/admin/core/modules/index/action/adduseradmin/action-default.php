<?php

if(count($_POST)>0){

	$user = new UserData();
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->username = $_POST["username"];
	$user->email = $_POST["email"];
	$user->password = sha1(md5($_POST["password"]));
	$user->is_admin="1";
	$usuarioPortalDePagos=$_POST["userportalpagos"];
	$contrasenaPortalDePagos = sha1(md5($_POST["passwordportaldepagos"]));
	#la url varia dependiendo el servidor donde se encuentre alojado

	$url = "http://localhost/Proyecto_Final_SS1/PortalPagos/WebServices/verificarCuenta.php?user=$usuarioPortalDePagos&pass=$contrasenaPortalDePagos";
	$data = json_decode(file_get_contents($url), true );

	//recorriendo el array devuelto
	$respuesta = "";
	foreach ($data as $res) {
		foreach ($res as $key => $value){
			switch ($key) {
				case 'respuesta':
					$respuesta = $value;
					break;
			}
		}	
		//echo "<h1>Respuesta: " . $respuesta . "</h1>";
	}
	



	//Buscando si el usuario esta disponible
	if(UserData::getByUser($user->username)!=null){
		print "<script>alert('EL NOMBRE DE USUARIO YA EXISTE, SELECCIONE OTRO');</script>";	
		print "<script>window.location='index.php?view=users';</script>";
	}else if(($userExist=UserData::getByEmail($user->email))!=null){
		print "<script>alert('EL CORREO YA ESTA ASOCIADO AL USUARIO:$userExist->username');</script>";	
		print "<script>window.location='index.php?view=users';</script>";	
	}else if($respuesta!="user_valido"){//Verificar si existe el usuario en el portal de pagos
		print "<script>alert('No se encontro tu cuenta en el portal de pagos, verifica los datos.');</script>";	
		print "<script>window.location='index.php?view=users';</script>";			
	}else{
		$user->add();
		print "<script>alert('USUARIO REGISTRADO CORRECTAMENTE');</script>";	
		print "<script>window.location='index.php?view=users';</script>";	
	}



	//Buscando si el correo ya esta registrado
	

	

}


?>