<?php
class Category {

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
}
?>