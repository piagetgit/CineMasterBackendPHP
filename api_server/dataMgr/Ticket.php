<?php
class Ticket {

	//connessione (inizializzata nel costruttore)
    private $conn;

    // proprietà dei tickets
    private $id;
    private $filmId;
    private $pagato;
    private $userId;
    private $numeroPersone;
    private $numeroRidotti;
    private $prezzoTotale;
    private $dataOra;
    private $posti;

    // il construttore inizializza la variabile per la connessione al DB
    public function __construct($db){
        $this->conn = $db;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id_par){
        $this->id = $id_par;
    }
    public function getFilmId(){
        return $this->filmId;
    }
    public function setFilmId($film_par){
        $this->filmId = $film_par;
    }
    public function getPagato(){
        return $this->pagato;
    }
    public function setPagato($pag_par){
        $this->pagato = $pag_par;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($user_par){
        $this->userId = $user_par;
    }
    public function getNumPersone(){
        return $this->numeroPersone;
    }
    public function setNumPersone($pers_par){
        $this->numeroPersone = $pers_par;
    }
    public function getNumRidotti(){
        return $this->numeroRidotti;
    }
    public function setNumRidotti($rid_par){
        $this->numeroRidotti = $rid_par;
    }
    public function getPrezzoTot(){
        return $this->prezzoTotale;
    }
    public function setPrezzoTot($price_par){
        $this->prezzoTotale = $price_par;
    }
    public function getDataOra(){
        return $this->dataOra;
    }
    public function setDataOra($date_par){
        $this->dataOra = $date_par;
    }
    public function getPlace(){
        return $this->posti;
    }
    public function setPlace($place_par){
        $this->posti = $place_par;
    }

    function createTicket() {
    		// inserisco il nuovo biglietto
    		$query = "INSERT INTO tickets SET
    				  id=:id, filmId=:filmId, pagato=:pagato, userId=:userId, numeroPersone=:numeroPersone, numeroRidotti=:numeroRidotti, prezzoTotale=:prezzoTotale, dataOra=:dataOra, posti=:posti";
    		// preparo la query
    		$stmt = $this->conn->prepare($query);

    		// invio i valori per i parametri (NB i valori del nuovo biglietto sono nelle variabili d'istanza!!)
    		$stmt->bindParam(":id", $this->id);
    		$stmt->bindParam(":filmId", $this->filmId);
    		$stmt->bindParam(":pagato", $this->pagato);
    		$stmt->bindParam(":userId", $this->userId);
    		$stmt->bindParam(":numeroPersone", $this->numeroPersone);
    		$stmt->bindParam(":numeroRidotti", $this->numeroRidotti);
    		$stmt->bindParam(":prezzoTotale", $this->prezzoTotale);
    		$stmt->bindParam(":dataOra", $this->dataOra);
    		$stmt->bindParam(":posti", $this->posti);

    		// eseguo la query
    		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query
    		return $stmt;
    }

    function readTicketsByUser() {
    		// estraggo tutti i biglietti
    		$query = "SELECT * FROM tickets WHERE tickets.userId =:idUser ORDER BY id;";
    		// preparo la query
    		$stmt = $this->conn->prepare($query);
    		// invio il parametro dell'utente
    		$stmt->bindParam(":idUser", $this->userId);
    		// eseguo la query
    		$stmt->execute(); // N.B. $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)
    		return $stmt;
    	}
}
?>