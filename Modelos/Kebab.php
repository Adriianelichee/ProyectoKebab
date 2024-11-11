<?php

class Kebab {
    private $idKebab;
    private $name;
    private $photo;
    private $basePrice;
    private $ingredients = [];

    //Constructor
    public function __construct($idKebab, $name, $photo, $basePrice) {
        $this->idKebab = $idKebab;
        $this->name = $name;
        $this->photo = $photo;
        $this->basePrice = $basePrice;
    }
    //Getters and Setters
    public function getIngredients() {
        return $this->ingredients;
    }

    
    public function addIngredient($ingredient) {
        $this->ingredients[] = $ingredient;
    }
    public function getIdKebab() {
        return $this->idKebab;
    }
    
    public function setIdKebab($idKebab) {
        $this->idKebab = $idKebab;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getPhoto() {
        return $this->photo;
    }
    
    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    
    public function getBasePrice() {
        return $this->basePrice;
    }
    
    public function setBasePrice($basePrice) {
        $this->basePrice = $basePrice;
    }

    //Json
    public function generateJSON() {
        $data = ["idKebab" => $this->idKebab,'name' => $this->name,"ingredients" => []];

        foreach ($this->ingredients as $ingredient) {
            $data['ingredients'][] = ['id' => $ingredient->getIdIngredient(),'name' => $ingredient->getName(), 'price' => $ingredient->getPrice()];
        }
        return json_encode($data);
    }
    
}