<?php

class OrderLine {
    private $orderLineID;
    private $orderID;
    private $stringJson;
    private $kebabs = [];
    private $quantity;
    private $price;

    //Constructor
    public function __construct($orderLineID, $orderID,$stringJson, $quantity, $price) {
        $this->orderLineID = $orderLineID;
        $this->orderID = $orderID;
        $this->stringJson = $stringJson;
        $this->quantity = $quantity;
        $this->price = $price;
    }
    
    //GETTERS AND SETTERS
    public function getOrderLineID() {
        return $this->orderLineID;
    }
    
    public function setOrderLineID($orderLineID) {
        $this->orderLineID = $orderLineID;
    }
    
    public function getOrderID() {
        return $this->orderID;
    }
    
    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }
    
    public function getStringJson() {
        return $this->stringJson;
    }
    
    public function setStringJson($stringJson) {
        $this->stringJson = $stringJson;
    }
    
    public function getKebabs() {
        return $this->kebabs;
    }
    
    public function addKebab(Kebab $kebab) {
        $this->kebabs[] = $kebab;
    }
    
    public function getQuantity() {
        return $this->quantity;
    }
    
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function setPrice($price) {
        $this->price = $price;
    }


}