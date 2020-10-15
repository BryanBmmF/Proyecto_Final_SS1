<?php

$cat = ProviderData::getById($_GET["provider_id"]);
$cat->del();

Core::redir("index.php?view=providers");
?>
