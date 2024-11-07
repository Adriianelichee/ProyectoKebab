<?php

class Ingredient {
    private $idIngredient;
    private $name;
    private $price;
    private $kebabs = [];
    private $allergens = [];

    //Constructor
    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }
    
    //Getters and setters
    public function getAllergens() {
        return $this->allergens;
    }
    
    public function addAllergen($allergen) {
        $this->allergens[] = $allergen;
    }
    public function getIdIngredient() {
        return $this->idIngredient;
    }
    
    public function getKebabs() {
        return $this->kebabs;
    }
    
    public function addKebab($kebab) {
        $this->kebabs[] = $kebab;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function setIdIngredient($idIngredient) {
        $this->idIngredient = $idIngredient;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setPrice($price) {
        $this->price = $price;
    }

}