<?php
class Film {
	
	//connessione (inizializzata nel costruttore)
    private $conn;
 
    // proprietà dei prodotti
    public $id;
    public $description;
    public $price;
    public $category;
    public $publish_date;
    public $regista;
    public $duration;
    public $title;

    // il construttore inizializza la variabile per la connessione al DB
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getId() {
        return $this->id;
    }
    public function setTitle($title_par) {
        $this->id = $title_par;
    }
	public function setPrice($price_par) {
        $this->id = $price_par;
    }
	public function setCategory($category_par) {
        $this->id = $category_par;
    }
	public function setPublishDate($publish_date_par) {
        $this->id = $publish_date_par;
    }
	public function setRegista($regista_par) {
        $this->id = $regista_par;
    }
	public function setDuration($duration_par) {
        $this->id = $duration_par;
    }

    public function getTitle() {
        return $this->title;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getCategory(){
        return $this->category;
    }
	public function getPublishDate(){
        return $this->publish_date;
    }
	public function getRegista(){
        return $this->regista;
    }
	public function getDuration(){
        return $this->duration;
    }

	// servizio di lettura di tutti i film
	function read() {
		// estraggo tutti i prodotti 
		$query = "SELECT * FROM films  ORDER BY title;";
		// preparo la query
		$stmt = $this->conn->prepare($query); 
		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)

		return $stmt;
	}

	// servizio di lettura dei dati di un prodotto, dato il suo id
	function readOne() {
		// estraggo il prodotto con l'id indicato
		$query = "SELECT * FROM films WHERE films.id = ?;";
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
			$this->title = $row['title'];
			$this->price = $row['price'];
			$this->description = $row['description'];
			$this->category = $row['category'];
			$this->publish_date = $row['publish_date'];
			$this->regista = $row['regista'];
			$this->duration = $row['duration'];

		}
		else {
			// se non trovo il film, imposto i valori delle variabili d'istanza a null
			$this->title = null;
			$this->price = null;
			$this->description = null;
			$this->category = null;
			$this->publish_date = null;
			$this->regista = null;
			$this->duration = null;
		
		// la funzione readOne non restituisce un risultato, bensì modifica l'oggetto su cui viene invocata (cioè il prodotto)
	}

	// servizio di inserimento di un nuovo film
	function create() {
		// inserisco il nuovo film
		$query = "INSERT INTO films SET
				  tilte=:title, prezzo=:price, descrizione=:description, category=:category, publish_date=:publish_date, regista=:regista, duration=:duration;";
		// preparo la query
		$stmt = $this->conn->prepare($query);

		// invio i valori per i parametri (NB i valori del nuovo prodotto sono nelle variabili d'istanza!!)
		$stmt->bindParam(":title", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":category", $this->category);
		$stmt->bindParam(":publish_date", $this->publish_date);
		$stmt->bindParam(":regista", $this->regista);
		$stmt->bindParam(":duration", $this->duration);
 
		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query

		return $stmt;		
	}

	// servizio di aggiornamento dei dati di un film
	function update() {
		// aggiorno i dati del film con l'id indicato
		$query = "UPDATE prodotti SET
					title = :n,
					prezzo = :p,
					descrizione = :d,
					category = :c_id,
					publish_date = :n,
					regista = :r,
					duration = :duration
					WHERE
					id = :i;";
	
		// preparo la query
		$stmt = $this->conn->prepare($query);
 
		// invio i valori per i parametri (NB i nuovi valori del prodotto sono nelle variabili d'istanza!!)
		$stmt->bindParam(':n', $this->title);
		$stmt->bindParam(':p', $this->price);
		$stmt->bindParam(':d', $this->description);
		$stmt->bindParam(':c_id', $this->category);
		$stmt->bindParam(':i', $this->id);
		$stmt->bindParam(":publish_date", $this->publish_date);
		$stmt->bindParam(":r", $this->regista);
		$stmt->bindParam(":duration", $this->duration);
 
		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query

		return $stmt;
	}

	// servizio di cancellazione di un prodotto
	function delete() {
		// cancello il prodotto con l'id indicato
		$query = "DELETE FROM films WHERE id = ?;";
	
		// preparo la query
		$stmt = $this->conn->prepare($query);
	
		// invio il valore per il parametro
		$stmt->bindParam(1, $this->id);

		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query

		return $stmt;
	}

	// servizio di ricerca prodotti per keyword
	function search($keywords) {
		// cerco i prodotti 
		$query = "SELECT * FROM films
				  WHERE films.title LIKE ? OR films.descrizione LIKE ? OR films.category LIKE ?
				  ORDER BY films.nome;";
		
		// preparo la query
		$stmt = $this->conn->prepare($query); 

		// aggiungo % prima e dopo le keywords per estrarre i testi che CONTENGONO le keywords (rif. SQL)
		$keywords = "%{$keywords}%"; 
	
		// invio i valori per i parametri
		$stmt->bindParam(1, $keywords);
		$stmt->bindParam(2, $keywords);
		$stmt->bindParam(3, $keywords);
 
		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)
	
		return $stmt;
	}	
}
?>