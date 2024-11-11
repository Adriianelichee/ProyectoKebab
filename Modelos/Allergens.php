<?php
class Allergens {
    private $idAllergens;
    private $name;
    private $photo;


    //Constructor
    public function __construct($name, $photo) {
        $this->name = $name;
        $this->photo = $photo;
    }

   //Getters and Setters
    public function getIdAllergens() {
        return $this->idAllergens;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getPhoto() {
        return $this->photo;
    }
    
    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    public function setName($name){
        $this->name = $name;
    }
    
}