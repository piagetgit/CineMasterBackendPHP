<?php
// rendo accessibile questo endpoint a tutti (CORS)
header("Access-Control-Allow-Origin: *");
// definisco il metodo consentito per la request (CORS)
header("Access-Control-Allow-Methods: DELETE");
// definisco la validità massima dell'autorizzazione in secondi (CORS)
header("Access-Control-Max-Age: 3600");
// definisco i tipi di header consentiti (CORS)
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// specifico il formato della risposta (JSON)
header("Content-Type: application/json; charset=UTF-8");
 
// includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/User.php';

// creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
// creo un'istanza di Prodotto
$user = new User($db);

// leggo i dati nel body della request (metodo POST)
$data = json_decode(file_get_contents("php://input"));


if(!empty($data->email) && !empty($data->password)){
    $user->setEmail($data->email);
    $user->readUserByEmail();
    if (!empty($user->password) && (strcmp($data->password,$user->password)==0)){
        http_response_code(200);
        $arr = array('message' => 'login success');
        echo json_encode($arr);
    }else{
        http_response_code(400);
    echo "some fill are null or empty";
    }
}else{
    http_response_code(400);
    echo "some fill are null or empty";
}

?>