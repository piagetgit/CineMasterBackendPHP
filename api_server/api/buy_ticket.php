  <?php
  //stabilisco i permessi di lettura del file (anyone)
  header("Access-Control-Allow-Origin: *");
  // dichiaro il formato della risposta (json)
  header("Content-Type: application/json; charset=UTF-8");
  header('Accept: application/json');
  // definisco i tipi di header consentiti (CORS)
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  // dichiaro il metodo consentito per la request
  header("Access-Control-Allow-Methods: POST");

  // includo le classi per la gestione dei dati
  include_once '../dataMgr/Database.php';
  include_once '../dataMgr/Ticket.php';

  // creo una connessione al DBMS
  $database = new Database();
  $db = $database->getConnection();

  // creo un'istanza di biglietto
  $ticket = new Ticket($db);

  // leggo i dati nel body della request (metodo POST)
  $data = json_decode(file_get_contents("php://input"));

  // controllo che i dati ci siano...
  if(!empty($data->filmId) && !empty($data->pagato) && !empty($data->userId) && !empty($data->numeroPersone) && !empty($data->numeroRidotti) && !empty($data->prezzoTotale) && !empty($data->dataOra) && !empty($data->posti)) {
      // inserisco i valori nelle variabili di istanza dell'oggetto $ticket
      $ticket->setFilmId($data->filmId);
      $ticket->setPagato($data->pagato);
      $ticket->setUserId($data->userId);
      $ticket->setNumPersone($data->numeroPersone);
      $ticket->setNumRidotti($data->numeroRidotti);
      $ticket->setPrezzoTot($data->prezzoTotale);
      $ticket->setDataOra($data->dataOra);
      $ticket->setPlace($data->posti);
      // invoco il metodo createTicket() che crea un nuovo biglietto
      if ($ticket->createTicket()) { // se va a buon fine...
          http_response_code(201); // response code 201 = created
          // creo un oggetto JSON costituito dalla coppia message: testo-msg
          echo json_encode(array("message" => "Ticket was created"));
      }else { // se la creazione è fallita...
          http_response_code(503); // response code 503 = service unavailable
          // creo un oggetto JSON costituito dalla coppia message: testo-msg
          echo json_encode(array("message" => "Unable to create ticket"));
      }
  }else { // se i dati sono incompleti
      http_response_code(400); // response code 400 = bad request
      // creo un oggetto JSON costituito dalla coppia message: testo-msg
      // uso l’operatore ternario con empty() per evitare l’errore sulla stampa di un valore inesistente
      echo json_encode(array("message" => "Unable to create ticket.
      Data is incomplete:" .
      " Film Id=" . (empty($data->filmId) ? "null" : $data->filmId) .
      " Pagato=" . (empty($data->pagato) ? "null" : $data->pagato) .
      " User Id=" . (empty($data->userId) ? "null" : $data->userId) .
      " Numero Persone=" . (empty($data->numeroPersone) ? "null" : $data->numeroPersone) .
      " Numero Ridotti=" . (empty($data->numeroRidotti) ? "null" : $data->numeroRidotti) .
      " Totale=" . (empty($data->prezzoTotale) ? "null" : $data->prezzoTotale) .
      " Data&Ora=" . (empty($data->dataOra) ? "null" : $data->dataOra) .
      " Posti=" . (empty($data->posti) ? "null" : $data->posti)));
  }
  ?>