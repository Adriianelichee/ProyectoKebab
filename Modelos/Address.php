<?php
class Address {
    private $id;
    private $roadName;
    private $roadType;
    private $roadNumber;
    private $floor;
    private $door;
    private $location;

    // Constructor
    public function __construct($id, $roadName, $roadType, $roadNumber, $location) {
        $this->id = $id;
        $this->roadName = $roadName;
        $this->roadType = $roadType;
        $this->roadNumber = $roadNumber;
        $this->location = $location;
    }
    
    // Getters and Setters
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
    
    public function setFloor($floor) {
        $this->floor = $floor;
    }
    
    public function setDoor($door) {
        $this->door = $door;
    }
    
    public function setLocation($location) {
        $this->location = $location;
    }
    public function setRoadName($roadName) {
        $this->roadName = $roadName;
    }
    
    public function setRoadType($roadType) {
        $this->roadType = $roadType;
    }
    
    public function setRoadNumber($roadNumber) {
        $this->roadNumber = $roadNumber;
    }

}