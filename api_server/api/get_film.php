<?php
//stabilisco i permessi di lettura del file (anyone)
header("Access-Control-Allow-Origin: *");
// definisco il formato della risposta (json)
header("Content-Type: application/json; charset=UTF-8");

// includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Category.php';
 
// creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
// creo un'istanza di Prodotto
$category = new Category($db);
 
// invoco il metodo read() che restituisce l'elenco dei prodotti
$stmt = $category->read(); // NB $stmt è un recordset!

if($stmt) { // se ci sono dei prodotti...
    // creo una coppia products: [lista-di-prodotti]
    $categories_list = array();
    $categories_list["categories"] = array();

    foreach ($stmt as $row) { // la funzione fetch (libreria PDO) con parametro PDO::FETCH_ASSOC invocata su un PDOStatement, restituisce un record ($row), in particolare un array le cui chiavi sono i nomi delle colonne della tabella 
		// costruisco un array associativo ($product_item) che rappresenta ogni singolo prodotto...
        $category_item = array(
            "id" => $row['idcat'],
            "name" => $row['nomecat'],
            "description" => html_entity_decode($row['descrizionecat'])
        );
		// ... e lo aggiungo al fondo di lista-di-categorie
        array_push($categories_list["categories"], $category_item); // la funzione array_push inserisce al fondo di un array ($categories_list["categories"]) i parametri che seguono l'array ($category_item)
    }
 
    http_response_code(200); // response code 200 = tutto ok

	// trasformo la coppia products: [lista-di-prodotti] in un oggetto JSON vero e proprio e lo invio in HTTP response
    echo json_encode($categories_list);
}
else { // se NON ci sono  categorie...
    http_response_code(404); // response code 404 = Not found
    // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "No categories found"));
}
?>