<?php
// kvstore API url
$url = 'http://nris.comercial.ws/Futurofone/GravarLigacao';
// Collection object
$data =json_decode('{
    "uniqueid": "000002.02",
    "uuid": "000001.02",
    "direcao": "entrada",
    "src": "11981081011",
    "dst": "1142106262",
    "calldate": "2020-04-08 12:00:00",
    "calldateend": "2020-04-08 12:01:00",
    "status": "answer",
    "ura": "Principal,Agendamento",
    "fila": "principal",
    "classificacao": "Normal",
    "cpf": "19119119100",
    "src_cidade": "São Paulo",
    "src_uf": "SP",
    "src_ramal": "0001",
    "src_agente": "2001",
    "dst_ramal": "0002",
    "dst_agente": "2002"
    }');
//echo json_decode($data);
//$data = [
//  'collection' => 'RapidAPI'
//];
// Initializes a new cURL session
$curl = curl_init($url);
// Set the CURLOPT_RETURNTRANSFER option to true
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// Set the CURLOPT_POST option to true for POST request
curl_setopt($curl, CURLOPT_POST, true);
// Set the request data as JSON using json_encode function
curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));

// Set custom headers for RapidAPI Auth and Content-Type header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'X-API-Host: http://nris.comercial.ws',
  'X-API-Key: a',
  'Content-Type: application/json'
]);
// Execute cURL request with all previous settings
$response = curl_exec($curl);
// Close cURL session
curl_close($curl);
echo $response . PHP_EOL;

?>