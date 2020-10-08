<?php
$hostname='localhost';
$database='portal_pagos';
$username='admindb';
$password='admindb';

$conexion=new mysqli($hostname,$username,$password,$database);
if($conexion->connect_errno){
    echo "El servidor de Base de Datos está experimentado problemas";
}
?>
