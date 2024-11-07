<?php

class Order {
    private $idOrder;
    private $datetime;
    private $state;
    private $totalPrice;
    private $userID;
    private $orderLines = [];

    public function __construct($idOrder, $datetime, $state, $totalPrice, User $user,$orderLines = []) {
        $this->idOrder = $idOrder;
        $this->datetime = $datetime;
        $this->state = $state;
        $this->totalPrice = $totalPrice;
        $this->userID = $user->getUserID();
        $this->orderLines = $orderLines;
    }

    //GETTERS AND SETTERS
    public function getOrderLines() {
        return $this->orderLines;
    }
    
    public function addOrderLine(OrderLine $orderLine) {
        $this->orderLines[] = $orderLine;
    }
    public function getIdOrder() {
        return $this->idOrder;
    }

    
    public function setIdOrder($idOrder) {
        $this->idOrder = $idOrder;
    }
    
    public function getDatetime() {
        return $this->datetime;
    }
    
    public function setDatetime($datetime) {
        $this->datetime = $datetime;
    }
    
    public function getState() {
        return $this->state;
    }
    
    public function setState($state) {
        $this->state = $state;
    }
    
    public function getTotalPrice() {
        return $this->totalPrice;
    }
    
    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }
    
    public function getUserID() {
        return $this->userID;
    }
    
    public function setUserID($userID) {
        $this->userID = $userID;
    }

}