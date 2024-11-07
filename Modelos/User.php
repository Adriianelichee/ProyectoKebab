<?php

class User {
    private $userID;
    private $username;
    private $password;
    private $rol;
    private $address;
    private $monedero;
    private $photo;
    private $email;
    private $cart;

    public function __construct($username, $password, $rol, $address, $monedero, $photo, $email, $cart) {
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
        $this->address = $address;
        $this->monedero = $monedero;
        $this->photo = $photo;
        $this->email = $email;
        $this->cart = $cart;
    }

    public function getUserID() {
        return $this->userID;
    }
    
    public function setUserID($userID) {
        $this->userID = $userID;
    }
    
    public function getUsername() {
        return $this->username;
    }

    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getRol() {
        return $this->rol;
    }
    
    public function setRol($rol) {
        $this->rol = $rol;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }
    
    public function getMonedero() {
        return $this->monedero;
    }
    
    public function setMonedero($monedero) {
        $this->monedero = $monedero;
    }
    
    public function getPhoto() {
        return $this->photo;
    }
    
    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getCart() {
        return $this->cart;
    }
    
    public function setCart($cart) {
        $this->cart = $cart;
    }
}
