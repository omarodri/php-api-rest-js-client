<?php 

    // ------------PRIMERA FORMA DE AUTH -----------------------
    // $user = array_key_exists('PHP_AUTH_USER', $_SERVER) ? $_SERVER['PHP_AUTH_USER'] : '';
    // $password = array_key_exists('PHP_AUTH_PW', $_SERVER) ? $_SERVER['PHP_AUTH_PW'] : '';
    
    // if($user !== 'omar' || $password !== '1234') die;
    


    // ------------SEGUNDA FORMA DE AUTH -----------------------
    // AUTENTICACIÔN A TRAVÊS HMAC
    // if( !array_key_exists('HTTP_X_HASH', $_SERVER) ||
    //     !array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) ||
    //     !array_key_exists('HTTP_X_UID', $_SERVER)
    // ) die; 

    // list( $hash, $uid, $timestamp) = [
    //     $_SERVER['HTTP_X_HASH'],
    //     $_SERVER['HTTP_X_UID'],
    //     $_SERVER['HTTP_X_TIMESTAMP']
    // ];

    // $secret = 'Sh!! No se lo cuentes a nadie!';

    // $myHash = sha1($uid.$timestamp.$secret);

    // if($myHash != $hash) die;

    // ------------SEGUNDA FORMA DE AUTH -----------------------
    // Pendiente

    // Definimos los recusos disponibles
    $alloedResourceType = [ //Simulo una base de tados de una librerîa
        'books',
        'authors',
        'genres'
    ];

    // Evalûo el mêtodo utilizado en el que me estân solicitando la info ()mayuscula
    $resourceType = $_GET['resourceType'];
    
    if (!in_array($resourceType, $alloedResourceType)) {
        http_response_code ( 400 ); //Manejo de errores
        die;
    }

    // Defino los recursos
    $books = [
        1 => [  'titulo'    => 'lo que el viendo se llevô',
                'id_author' => 2,
                'id_genero' => 1
            ],
        2 => [  'titulo'    => 'La odisea',
                'id_author' => 1,
                'id_genero' => 1
        ],
        3 => [  'titulo'    => 'la Iliada',
                'id_author' => 1,
                'id_genero' => 1
            ]
    ];

    // Evalûo si me estân preguntando por un ele,mento de la colecciôn en particular
    $id = array_key_exists('id', $_GET) ? $_GET['id'] : '';


    
    // evalûio que los recursos estên disponibles
    switch (strtoupper($_SERVER['REQUEST_METHOD'])) { 
        case 'GET':
            header('Content-Type: application/json');
            if( empty($id) )
                echo json_encode( $books );
            else if(array_key_exists( $id, $books ))
                    echo json_encode( $books[$id] );
                else
                    // echo json_encode(array('msg' => 'No existe el libro'));
                    http_response_code ( 404 ); //Manejo de errores


                //  Del lado del cliente hago el siguiente llamado: lînea de comandos
                //  curl "http://localhost:8000/books/2" | jq
            break;

        case 'POST':
            
            $json = file_get_contents('php://input'); //Post en crudo
            $books[] = json_decode($json, true); //se incluye el libro en el arreglo

            // echo array_keys( $books )[ count($books) - 1 ];
            echo json_encode($books);
            
            //  Del lado del cliente hago el siguiente llamado: lînea de comandos
            //  >> curl -H "Content-Type: application/json" -X POST -d "{ \"titulo\":\"Nuevo Libro\",\"id_autor\": 1,\"genero\": 2}" http://localhost:8000/books

        break;

            
        case 'PUT':
            header('Content-Type: application/json');

            // validamos que el recurso buscado exista
            if( !empty($id) && array_key_exists($id, $books) ){
                
                $json = file_get_contents('php://input');   //Obtengo el PUT en crudo
                $books[$id] = json_decode($json, true);     // DEcodifico el json como arreglo y lo cambio en la posiciôn $id
                echo json_encode($books);                   // Codifico y regreso toda la collection
            }

            //  Del lado del cliente hago el siguiente llamado: lînea de comandos
            // >>> curl -H "Content-Type: application/json" -X PUT -d "{ \"titulo\":\"el codigo quebec\",\"id_author\": 5,\"id_genero\": 2}" http://localhost:8000/books/1 | jq
            
        break;            
        case 'DELETE':
            //  Validamnos que el recurso exista
            if( !empty($id) && array_key_exists($id, $books) ){
                unset($books[$id]);
            }
            echo json_encode($books);                   // Codifico y regreso toda la collection
            
            //  Del lado del cliente hago el siguiente llamado: lînea de comandos
            //  >>>> curl  -X DELETE localhost:8000/books/1 | jq
            break;
    }

?>