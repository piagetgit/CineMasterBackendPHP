<?php
class User {
	
	//connessione (inizializzata nel costruttore)
    private $conn;
 
    // proprietà dei prodotti
    public $id;
    public $first_name;
    public $surname;

    public $password;
    public $is_logged;

    public $email;
    public $date_of_birth;
    public $role;
  
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
        return $this->nom;
    }

    public function getEmail(){
       return $this->email;
    }
    public function getFirstName(){
        return $this->first_name;
    }

    public function getDateOfBrith(){
        return $this->first_name;
    }

    public function setFirstName($first_name_par){
        $this->name = $first_name_par;
    }

    public function setSurname($surname_par){
        $this->name = $surname_par;
    }

    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description_par){
        $this->description = $description_par;
    }
    
    public function setEmail($email_par){
        $this->email = $email_par;
    }

    public function setDateOfBirth($date_of_birth_parm){
        $this->date_of_birth = $date_of_birth_parm;
    }

	
	function read() {
		// estraggo tutti film 
		$query = "SELECT * FROM user_table ORDER BY firstname;";
		// preparo la query
		$stmt = $this->conn->prepare($query); 
		// eseguo la query
		$stmt->execute(); // N.B. $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)

		return $stmt; 
	}

    function readUserByEmail() {
		$query = "SELECT * FROM user_table
                  WHERE user_table.email=:email;";
		// preparo la query
		$stmt = $this->conn->prepare($query); 
        $stmt->bindParam(":email", $this->email);
		// eseguo la query
		$stmt->execute(); // N.B. $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // la funzione fetch (libreria PDO) con parametro PDO::FETCH_ASSOC invocata su un PDOStatement, restituisce un record ($row), in particolare un array le cui chiavi sono i nomi delle colonne della tabella 
 
		if ($row) {
			// inserisco i valori nelle variabili d'istanza 
			$this->name = $row['name'];
			$this->surname = $row['surname'];
			$this->password = $row['password'];
		}
		return $stmt; 
	}
	
}
?>