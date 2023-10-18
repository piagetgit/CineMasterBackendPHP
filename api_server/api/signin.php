<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Accept, Content-Type');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-Type: application/json');
header('Accept: application/json');
 
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
    if($user->readUserByEmail()){
        if (!empty($user->password) && (strcmp($data->password,$user->password)==0)){
            http_response_code(200);
            $arr = array('message' => 'login success');
            $res = array('nome'=>$user->first_name,'cognome'=> $user->surname,'id' => $user->id,'dataNascita' => $user->date_of_birth, 'email' => $user->email);
            echo json_encode($res);
        }else{
            http_response_code(400);
            /*$arr = array('message' => 'Email or Password incorrect');
            echo json_encode($arr);*/
        }
    }
    
}else{
    http_response_code(400);
    /*$arr = array('message' => 'some fill are null or empty');
    echo json_encode($arr);*/
}

?>