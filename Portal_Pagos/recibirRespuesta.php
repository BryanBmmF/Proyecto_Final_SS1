
<?php

#links de ref:

/**
 * http://mialtoweb.es/leer-un-json-desde-una-url-externa-con-php/
 * https://parzibyte.me/blog/2019/04/05/enviar-recibir-json-php-curl/
 * https://parzibyte.me/blog/2019/08/21/peticion-http-php-json-formulario/
 * 
 * 
 */

 #ejemlo:
 # http://ppagoss1.com/recibirRespuesta.php

    #parametros a consultar
    $user = "bmmf";
    $pass = "a4a537d4b35b0ace7746a374cd3937e71af41117";

    $url = "http://ppagoss1.com/verificarCuenta.php?user=$user&pass=$pass";

    //$res = file_get_contents("http://ppagoss1.com/verificarCuenta.php?user=$user&pass=$pass");

    $data = json_decode(file_get_contents($url), true );
    //print_r($data);  //imprime el array completo del json

    //recorriendo el array devuelto
    foreach ($data as $res) {
        $respuesta = "";
        foreach ($res as $key => $value){
            switch ($key) {
                case 'respuesta':
                    $respuesta = $value;
                    break;
            }
        }
        echo "<h1>Respuesta: " . $respuesta . "</h1>";
        
    }

?>