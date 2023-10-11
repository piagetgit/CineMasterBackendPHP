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

    public function getPassword(){
        return $this->password;
    }

    public function setFirstName($first_name_par){
        $this->first_name = $first_name_par;
    }

    public function setSurname($surname_par){
        $this->surname = $surname_par;
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

    public function setPassword($password_par){
        $this->password = $password_par;
    }

    public function setIsLogger($is_logged_par){
        $this->is_logged = $is_logged_par;
    }

    public function setRole($role_par){
        $this->role_par = $role_par;
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
			$this->first_name = $row['first_name'];
			$this->surname = $row['surname'];
			$this->password = $row['password'];
		}
        else{
            $arr = array('message' => 'User ' .$this->email. ' not found');
            echo json_encode($arr);
            http_response_code(404);
        }
	}

    function createUser() {
		// inserisco il nuovo user
		$query = "INSERT INTO user_table SET
				  first_name=:first_name, surname=:surname, password=:password, role=:role, email=:email, date_of_birth=:date_of_birth, is_logged=:logged;";
		// preparo la query
		$stmt = $this->conn->prepare($query);
		// invio i valori per i parametri (NB i valori del nuovo prodotto sono nelle variabili d'istanza!!)
		$stmt->bindParam(":first_name", $this->first_name);
		$stmt->bindParam(":surname", $this->surname);
		$stmt->bindParam(":password", $password);
		$stmt->bindParam(":role", $this->role);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":date_of_birth", $this->date_of_birth);
		$stmt->bindParam(":logged", $this->is_logged);
 
		// eseguo la query
		$stmt->execute(); // NB $stmt conterrà il risultato dell'esecuzione della query

		return $stmt;		
	}

	
}
?>