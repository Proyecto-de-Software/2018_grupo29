<?php

$returnArray = true;
$rawData = file_get_contents('php://input');
$response = json_decode($rawData, $returnArray);
$id_del_chat = $response['message']['chat']['id'];


// Obtener comando (y sus posibles parametros)
$regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';


$tmp = preg_match($regExp, $response['message']['text'], $aResults);

if (isset($aResults[1])) {
    $cmd = trim($aResults[1]);
    $cmd_params = trim($aResults[2]);
} else {
    $cmd = trim($response['message']['text']);
    $cmd_params = '';
}

$msg = array();
$msg['chat_id'] = $response['message']['chat']['id'];
$msg['text'] = null;
$msg['disable_web_page_preview'] = true;
$msg['reply_to_message_id'] = $response['message']['message_id'];
$msg['reply_markup'] = null;

switch ($cmd) {
    case '/start':
        $msg['text']  = 'Hola ' . $response['message']['from']['first_name'] . 
                   " Usuario: " . $response['message']['from']['username'] . '!' . PHP_EOL;
        $msg['text'] .= '¿Como puedo ayudarte? /help';
        $msg['reply_to_message_id'] = null;
        break;

    case '/help':
        $msg['text']  = 'Los comandos disponibles son estos:' . PHP_EOL;
        $msg['text'] .= '/start Inicializa el bot' . PHP_EOL;
        $msg['text'] .= '/instituciones muestra las instituciones disponibles' . PHP_EOL;
        $msg['text'] .= '/institucionesRegionSanitaria muestra las instituciones correspondientes a la region sanitaria' . PHP_EOL;
        $msg['text'] .= '/help Muestra la lista de comandos disponibles';
        $msg['reply_to_message_id'] = null;
        break;

    case '/instituciones':
        $instituciones = json_decode(file_get_contents("https://grupo29.proyecto2018.linti.unlp.edu.ar/Final/public/api/instituciones"));
        if (count($instituciones)==0) {
            $msg['text'] = 'No hay instituciones con ese parametro.';
        } else {
            $msg['text'] = 'Las instituciones disponibles son estas:' . PHP_EOL;
            $msg['text'] .= ''.PHP_EOL;
        }
        foreach ($instituciones as $institucion) {
            $msg['text'] .= 'Nombre de institucion: '.$institucion->name.PHP_EOL;
            $msg['text'] .= 'Director: '.$institucion->director.PHP_EOL;
            $msg['text'] .= 'Telefono: '.$institucion->phone_number.PHP_EOL;
            $msg['text'] .= ''.PHP_EOL;
        }
        $msg['reply_to_message_id'] = null;
        break;

    case '/institucionesRegionSanitaria':
        $instituciones = json_decode(file_get_contents("https://grupo29.proyecto2018.linti.unlp.edu.ar/Final/public/api/instituciones/region-sanitaria/".$cmd_params));
        if (count($instituciones)==0) {
            $msg['text'] = 'No hay instituciones con ese parametro.';
        } else {
            $msg['text']  = 'Las instituciones disponibles de la region sanitaria '.$cmd_params.' son estas:' . PHP_EOL;
            $msg['text'] .= ''.PHP_EOL;
        }
        foreach ($instituciones as $institucion) {
            $msg['text'] .= 'Nombre de institucion: '.$institucion->name.PHP_EOL;
            $msg['text'] .= 'Director: '.$institucion->director.PHP_EOL;
            $msg['text'] .= 'Telefono: '.$institucion->phone_number.PHP_EOL;
            $msg['text'] .= ''.PHP_EOL;
        }
        $msg['reply_to_message_id'] = null;
        break;

    default:
            $msg['text']  = 'Lo siento, no es un comando válido.' . PHP_EOL;
            $msg['text'] .= 'Prueba /help para ver la lista de comandos disponibles';
            break;
}

$url = 'https://api.telegram.org/bot689626573:AAHM_xehhC7H-EVA9FDiaS3WGe7OOBPtjoA/sendMessage';

    $options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($msg)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    exit(0);
