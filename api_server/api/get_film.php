<?php
/*// rendo accessibile questo endpoint a tutti (CORS)
header("Access-Control-Allow-Origin: *");
// definisco il metodo consentito per la request (CORS)
header("Access-Control-Allow-Methods: DELETE");
// definisco la validità massima dell'autorizzazione in secondi (CORS)
header("Access-Control-Max-Age: 3600");
// definisco i tipi di header consentiti (CORS)
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// specifico il formato della risposta (JSON)
header("Content-Type: application/json; charset=UTF-8");*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Accept, Content-Type');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-Type: application/json');
header('Accept: application/json');
// includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Film.php';

// creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
// creo un'istanza di Prodotto
$film = new Film($db);

// leggo i dati nel body della request (metodo POST)
$data = json_decode(file_get_contents("php://input"));


if(!empty($data->id_film)){

/*$film->setId($data->id_film);*/
if($film->find_film($data->id_film)){
    
        http_response_code(200);
        $res = array('id'=>$film->id, 'description'=>$film->description, 'price'=>$film->price, 'category'=>$film->category, 'publish_date'=>$film->publish_date, 'regista'=>$film->regista, 'duration'=>$film->duration, 'title'=>$film->title, 'img'=>$film->img);
        echo json_encode($res);
    
}
}else{

    if($res=$film->lista()){
    
        http_response_code(200);
        
        echo json_encode($res);
    
    }else{

        http_response_code(400); 
    }
    
}



?>