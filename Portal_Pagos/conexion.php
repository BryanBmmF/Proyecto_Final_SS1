<?php
$hostname='localhost';
$database='portal_pagos';
$username='root';
$password='Password1!';

$conexion=new mysqli($hostname,$username,$password,$database);
if($conexion->connect_errno){
    echo "El servidor de Base de Datos está experimentado problemas";
}
?>
