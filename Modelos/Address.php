<?php
class Address {
    private $id;
    private $roadName;
    private $roadType;
    private $roadNumber;
    private $floor;
    private $door;
    private $location;
    private $json;

    // Constructor
    public function __construct($roadName, $roadType, $roadNumber, $location, $floor = null, $door = null) {
        $this->roadName = $roadName;
        $this->roadType = $roadType;
        $this->roadNumber = $roadNumber;
        $this->location = $location;
        $this->floor = $floor;
        $this->door = $door;
        $this->updateJson();
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getRoadName() {
        return $this->roadName;
    }
    
    public function getRoadType() {
        return $this->roadType;
    }
    
    public function getRoadNumber() {
        return $this->roadNumber;
    }
    
    public function getFloor() {
        return $this->floor;
    }
    
    public function getDoor() {
        return $this->door;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function getJson() {
        return $this->json;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
        $this->updateJson();
    }

    public function setRoadName($roadName) {
        $this->roadName = $roadName;
        $this->updateJson();
    }
    
    public function setRoadType($roadType) {
        $this->roadType = $roadType;
        $this->updateJson();
    }
    
    public function setRoadNumber($roadNumber) {
        $this->roadNumber = $roadNumber;
        $this->updateJson();
    }

    public function setFloor($floor) {
        $this->floor = $floor;
        $this->updateJson();
    }
    
    public function setDoor($door) {
        $this->door = $door;
        $this->updateJson();
    }
    
    public function setLocation($location) {
        $this->location = $location;
        $this->updateJson();
    }

    // Método privado para actualizar el JSON
    private function updateJson() {
        $this->json = json_encode([
            'id' => $this->id,
            'roadName' => $this->roadName,
            'roadType' => $this->roadType,
            'roadNumber' => $this->roadNumber,
            'floor' => $this->floor,
            'door' => $this->door,
            'location' => $this->location
        ]);
    }
}