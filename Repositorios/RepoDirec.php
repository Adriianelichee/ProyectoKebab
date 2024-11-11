<?php

class RepoDirec implements RepoCrud{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }
    public function create($address) {
        // Preparar la consulta SQL
        $stmt = $this->conexion->prepare("INSERT INTO Address (roadName, roadType, roadNumber, floor, door, location, addressJson) VALUES (:roadName, :roadType, :roadNumber, :floor, :door, :location, :addressJson)");
    
        // Ejecutar la consulta
        $stmt->execute(["roadName" => $address->getRoadName(),"roadType" => $address->getRoadType(),"roadNumber" => $address->getRoadNumber(),"floor" => $address->getFloor(),"door" => $address->getDoor(),"location" => $address->getLocation(),"addressJson" => $address->getJson()]);
    
        // Obtener el id del nuevo registro
        $id = $this->conexion->lastInsertId();
    
        // Asignar el id al objeto Address
        $address->setId($id);
    
        return $address;
    }

    public function update($id, $addr) {
        // Asegurarse de que el id del objeto Address está actualizado
        $addr->setId($id);
    
        // Preparar la consulta SQL
        $stmt = $this->conexion->prepare("UPDATE Address SET roadName = :roadName, roadType = :roadType, roadNumber = :roadNumber, floor = :floor, door = :door, location = :location, addressJson = :addressJson WHERE id = :id");
    
        // Ejecutar la consulta
        $result = $stmt->execute(["roadName" => $addr->getRoadName(),"roadType" => $addr->getRoadType(),"roadNumber" => $addr->getRoadNumber(),"floor" => $addr->getFloor(),"door" => $addr->getDoor(),"location" => $addr->getLocation(),"addressJson" => $addr->getJson(),"id" => $id]);
    
        // Devolver true si la actualización fue exitosa, false en caso contrario
        return $result;
    }

    public function delete($id) {
        // Implementación del método delete
        $stmt = $this->conexion->prepare("DELETE FROM Address WHERE id = :id");
        $stmt->execute(["id" => $id]);
        return true;

    }

    public function getById($id) {
        // Implementación del método getById
        $stmt = $this->conexion->prepare("SELECT * FROM Address WHERE id = :id");
        $stmt->execute(["id" => $id]);
        
        if ($stmt->rowCount() > 0) {
    
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Address($fila['id'],$fila['roadName'], $fila['roadType'], $fila['roadNumber'], $fila['floor'], $fila['door'], $fila['location'], $fila['addressJson']);
        }

    }

    public function getAll() {
        // Implementación del método getAll
        $stmt = $this->conexion->prepare("SELECT * FROM Address");
        $stmt->execute();
        
        $direcciones = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $direcciones[] = new Address($fila['id'], $fila['roadName'], $fila['roadType'], $fila['roadNumber'], $fila['floor'], $fila['door'], $fila['location']);
        }
        return $direcciones;
    }
    public function getAddressesByUserId($userId) {

            // Preparar la consulta SQL
            $stmt = $this->conexion->prepare("SELECT a.* FROM Address a INNER JOIN user_address ua ON a.id = ua.address_id WHERE ua.user_id = :userId");
            
            // Ejecutar la consulta
            $stmt->execute(["userId" => $userId]);
            
            $direcciones = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $direcciones[] = new Address($fila['id'],$fila['roadName'],$fila['roadType'],$fila['roadNumber'],$fila['floor'],$fila['door'],$fila['location'],$fila['addressJson']);
            }
            return $direcciones;
    }

    public function find($criterio) {
        // Implementación del método find

    }

    public function count() {
        // Implementación del método count
        $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM Address");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['total'];
    }
}
