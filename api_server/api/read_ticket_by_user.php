  <?php
  //stabilisco i permessi di lettura del file (anyone)
  header("Access-Control-Allow-Origin: *");
  // dichiaro il formato della risposta (json)
  header("Content-Type: application/json; charset=UTF-8");
  // definisco i tipi di header consentiti (CORS)
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  // dichiaro il metodo consentito per la request
  header("Access-Control-Allow-Methods: GET");

  // includo le classi per la gestione dei dati
  include_once '../dataMgr/Database.php';
  include_once '../dataMgr/Ticket.php';

  // creo una connessione al DBMS
  $database = new Database();
  $db = $database->getConnection();

  // creo un'istanza di biglietto
  $ticket = new Ticket($db);

  // leggo l'id nella richiesta (GET) e lo inserisco nella variabile di istanza userId dell'oggetto $ticket
  $userId_toRead = isset($_GET['userId']) ? $_GET['userId'] : die();
  $ticket->setUserId($userId_toRead);

  // invoco il metodo readTicketsByUser() che restituisce le info dei biglietti su cui viene invocato (l'id è già nella variabile id di $ticket!)
  $stmt = $ticket->readTicketsByUser();
  if ($stmt){   // se ci sono dei biglietti sul profilo
    $tickets_list = array();
    //$tickets_list["tickets"] = array();
    foreach ($stmt as $row) {
        // costruisco un array associativo che rappresenta i singoli biglietti
        $ticket_item = array(
        "id" => $row['id'],
        "filmId" => $row['filmId'],
        "pagato" => $row['pagato'],
        "userId" => $row['userId'],
        "numeroPersone" => $row['numeroPersone'],
        "numeroRidotti" => $row['numeroRidotti'],
        "prezzoTotale" => $row['prezzoTotale'],
        "dataOra" => $row['dataOra'],
        "posti" => $row['posti']
        );
        // ... e lo aggiungo al fondo di lista di ticket
        array_push($tickets_list, $ticket_item);
    }
    http_response_code(200);   // dico che è tutto ok
    echo json_encode($tickets_list);   // trasformo l'array di biglietti in un JSON
  }else{
    http_response_code(404);   // dico che quanto richiesto non è stato trovato
    echo json_encode(array("message" => "No tickets available"));   // e lo comunico al client
   }
  ?>