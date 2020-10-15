<?php

$cat =  new ProviderData();
$cat->name = $_POST["name"];
$cat->address = $_POST["address"];
$cat->phone = $_POST["phone"];
if(isset($_POST["is_active"])){ $cat->is_active=1;}else{$cat->is_active=0;}
$cat->add();

Core::redir("index.php?view=providers");

?>
