<?php
class Category {
	
	//connessione (inizializzata nel costruttore)
    private $conn;
 
    // proprietà dei prodotti
    public $id;
    public $name;
    public $description;
  
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
    public function getName(){
        return $this->name;
    }
    public function setName($name_par){
        $this->name = $name_par;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description_par){
        $this->description = $description_par;
    }
 
	// servizio di lettura di tutte le categorie
	function read() {
		// estraggo tutte le categorie 
		$query = "SELECT * FROM categorie ORDER BY nomecat;";
		// preparo la query
		$stmt = $this->conn->prepare($query); 
		// eseguo la query
		$stmt->execute(); // N.B. $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)

		return $stmt; 
	}
	
}
?>