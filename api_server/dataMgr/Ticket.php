<?php
class Ticket {

	//connessione (inizializzata nel costruttore)
    private $conn;

    // proprietà dei prodotti
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

    function writeOne() {
		// estraggo il biglietto con l'id indicato
		$query = "SELECT * FROM tickets WHERE Ticket.id = ?;";
		// preparo la query
		$stmt = $this->conn->prepare($query);
		// invio il valore per il parametro
		$stmt->bindParam(1, $this->id);
		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset con un solo elemento)

		// leggo la prima (e unica) riga del risultato della query
		$row = $stmt->fetch(PDO::FETCH_ASSOC); // la funzione fetch (libreria PDO) con parametro PDO::FETCH_ASSOC invocata su un PDOStatement, restituisce un record ($row), in particolare un array le cui chiavi sono i nomi delle colonne della tabella

		if ($row) {
			// inserisco i valori nelle variabili d'istanza
			$this->id = $row['id'];
			$this->filmId = $row['filmId'];
			$this->pagato = $row['pagato'];
			$this->userId = $row['userId'];
			$this->numeroPersone = $row['numeroPersone'];
			$this->numeroRidotti = $row['numeroRidotti'];
			$this->prezzoTotale = $row['prezzoTotale'];
			$this->dataOra = $row['dataOra'];
			$this->posti = $row['posti'];

		}
		else {
			// se non trovo il biglietto, imposto i valori delle variabili d'istanza a null
			$this->id = null;
			$this->filmId = null;
			$this->pagato = null;
			$this->userId = null;
			$this->numeroPersone = null;
			$this->numeroRidotti = null;
			$this->prezzoTotale = null;
			$this->dataOra = null;
            $this->posti = null;

		// la funzione readOne non restituisce un risultato, bensì modifica l'oggetto su cui viene invocata (cioè il prodotto)
	}
}
?>