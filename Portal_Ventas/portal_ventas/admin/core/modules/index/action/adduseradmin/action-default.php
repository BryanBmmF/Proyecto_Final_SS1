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
	$contrasenaPortalDePagos=$_POST["passwordportaldepagos"];

	//Buscando si el usuario esta disponible
	if(UserData::getByUser($user->username)!=null){
		print "<script>alert('EL NOMBRE DE USUARIO YA EXISTE, SELECCIONE OTRO');</script>";	
		print "<script>window.location='index.php?view=users';</script>";
	}else if(($userExist=UserData::getByEmail($user->email))!=null){
		print "<script>alert('EL CORREO YA ESTA ASOCIADO AL USUARIO:$userExist->username');</script>";	
		print "<script>window.location='index.php?view=users';</script>";	
	}else{//Verificar si existe el usuario en el portal de pagos
		$user->add();
		print "<script>alert('USUARIO REGISTRADO CORRECTAMENTE');</script>";	
		print "<script>window.location='index.php?view=users';</script>";
	}

	//Buscando si el correo ya esta registrado
	

	

}


?>