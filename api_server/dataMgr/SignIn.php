<?php
class SignIn {
	
	//connessione (inizializzata nel costruttore)
    private $conn;

    public $password;
    public $email;
  
    // il construttore inizializza la variabile per la connessione al DB
    public function __construct($db){
        $this->conn = $db;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email_par){
        $this->id = $email_par;
    }
    public function getPassword(){
        return $this->password;
    }
	
	function signin() {
		// estraggo tutti film 
		$query = "SELECT * FROM users
                  WHERE users.email = :email;";
		// preparo la query
		$stmt = $this->conn->prepare($query); 
        $stmt->bindParam(":email", $this->email);
		// eseguo la query
		$stmt->execute(); // N.B. $stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset)

		return $stmt; 
	}
	
}
?>