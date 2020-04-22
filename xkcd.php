<?php 

    // echo file_get_contents('https://xkcd.com/info.0.json').PHP_EOL;

    $json = file_get_contents('https://xkcd.com/info.0.json');

    $data = json_decode( $json, false);

    echo $data->img;

?>