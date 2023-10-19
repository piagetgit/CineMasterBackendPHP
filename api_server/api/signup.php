<?php
// rendo accessibile questo endpoint a tutti (CORS)
header("Access-Control-Allow-Origin: *");
// definisco il metodo consentito per la request (CORS)
header("Access-Control-Allow-Methods: POST");
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
 
// controllo che i dati ci siano...
if(
    !empty($data->first_name) &&
    !empty($data->surname) &&
    !empty($data->password) &&
    !empty($data->email) &&
    !empty($data->date_of_birth)
) {
 
        // inserisco i valori nelle variabili d'istanza dell'oggetto $product
        $user->setFirstName($data->first_name);
        $user->setSurname($data->surname);
        $user->setPassword($data->password);
        //$user->setPassword("password");
        $user->setEmail($data->email);
        $user->setDateOfBirth($data->date_of_birth);
        $user->setRole("utente");
        
        if ($user->existUserByEmail()){
            http_response_code(403);
            // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
            echo json_encode(array("message" => "User Already exits with the email". $data->email));
            return;
        }
        else if($user->createUser()){ // se va a buon fine...
                http_response_code(201); // response code 201 = created
        
                // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
                echo json_encode(array("message" => "User has been created","code"=>"2002"));
        }
        else{ // se la creazione è fallita...
            http_response_code(503); // response code 503 = service unavailable
        
            // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
                echo json_encode(array("message" => "Unable to create product"));
        }
    }
    else { // se i dati sono incompleti
        http_response_code(400); // response code 400 = bad request
        // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
        // uso l’operatore ternario con empty() per evitare l’errore sulla stampa di un valore inesistente
        echo json_encode(array("message" => "Unable to create User. Data is incomplete:"
            . " firstname=" . (empty($data->first_name) ? "null" : $data->first_name) . " surname=" . (empty($data->surname) ? "null" : $data->surname) . " password=" . (empty($data->password) ? "null" : "*****") . " email=" . (empty($data->email) ? "null" : $data->email) . " date_of_birth=" . (empty($data->date_of_birth) ? "null" : $data->date_of_birth)));
}
?>