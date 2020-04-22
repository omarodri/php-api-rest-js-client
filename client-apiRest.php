<?php 

    $data = [
        'username'  => 'omar',
        'password'  => 'erwrw'
    ];

    $payLoad = json_decode($data); //el arreglo se codifica en JSON para enviar en el post

    $ch = curl_init('https://api.example.com/api/1.0/user/login'); //se inicia la conexiôn hacia el server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         //quiero que el resultado del server me sea devuelto
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);            //no me interesa ver los encabezados de la respuesta
    curl_setopt($ch, CURLOPT_POST, true);                   //Esta peticiôn se harâ con el mêtodo POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payLoad);         //se tranfiere la info estructurada en formato JSON

    curl_setopt($ch, CURLOPT_HTTPHEADER,[                   //se envîa con unos encabezados la servidor, para que el sepa que se envîa
        'Content-Type: application/json',                   //se indica el tipo de contenido
        'Content-Length: ' . strlen($payLoad)               //se envîa el tamagno del mensaje
    ]);

    $result = curl_exec($ch);                               //envîa el mensaje y toma la respuesta

    curl_close($ch);                                        //cierra la conexiôn

?>