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

    public function getEmail(){
       return $this->email;
    }
    public function getFirstName(){
        return $this->first_name;
    }

    public function getDateOfBrith(){
        return $this->date_of_birth;
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
		$query = "SELECT * FROM user ORDER BY firstname;";
		// preparo la query
		$stmt = $this->conn->prepare($query); 
		// eseguo la query
		$stmt->execute(); // N.B. $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)

		return $stmt; 
	}
	
}
?>