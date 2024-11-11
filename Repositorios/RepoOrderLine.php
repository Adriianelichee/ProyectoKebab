<?php

class RepoOrderLine implements RepoCrud{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }
    public function create($OrderLine) {    
        // Verificar que el OrderLine tiene un OrderID válido
        if (!$OrderLine->getOrderID()) {
            echo ("El OrderLine debe tener un OrderID válido antes de ser creado.");
        }
    
        // Insertar la línea de pedido principal
        $stmt = $this->conexion->prepare("INSERT INTO OrderLine (orderID, stringJson, quantity, price) VALUES (:orderID, :stringJson, :quantity, :price)");
    
        $stmt->execute(["orderID" => $OrderLine->getOrderID(),"stringJson" => $OrderLine->getStringJson(),"quantity" => $OrderLine->getQuantity(),"price" => $OrderLine->getPrice()]);
    
        $orderLineId = $this->conexion->lastInsertId();
        $OrderLine->setOrderLineID($orderLineId);
    
        // Insertar los kebabs asociados a esta línea de pedido
        $kebabs = $OrderLine->getKebabs();
        $stmtKebab = $this->conexion->prepare("INSERT INTO OrderLineKebab (orderLineId, kebabId) VALUES (:orderLineId, :kebabId)");
    
        foreach ($kebabs as $kebab) {
            $stmtKebab->execute(["orderLineId" => $orderLineId,"kebabId" => $kebab->getId()]);
        }
    
        return $OrderLine;
    }

    public function update($id, $obj) {
        // Implementación del método update

    }

    public function delete($id) {
        // Implementación del método delete
        $stmt = $this->conexion->prepare("DELETE FROM OrderLine WHERE orderLineID = :orderLineID");
        $stmt->execute(["orderLineID" => $id]);
        $stmtKebab = $this->conexion->prepare("DELETE FROM OrderLineKebab WHERE orderLineId = :orderLineID");
        $stmtKebab->execute(["orderLineID" => $id]);
        return true;
    }

    public function getById($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM OrderLine WHERE orderLineID = :orderLineID");
        $stmt->execute(["orderLineID" => $id]);
        
        if ($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $OrderLine = new OrderLine($fila['orderLineID'], $fila['orderID'], $fila['stringJson'], $fila['quantity'], $fila['price']);
    
            // Obtener los kebabs asociados a esta línea de pedido
            $stmtKebab = $this->conexion->prepare("SELECT k.* FROM OrderLineKebab olk JOIN Kebab k ON olk.kebabId = k.kebabId WHERE olk.orderLineId = :orderLineID");
            $stmtKebab->execute(["orderLineID" => $id]);
            
            while ($filaKebab = $stmtKebab->fetch(PDO::FETCH_ASSOC)) {
                $kebab = new Kebab($filaKebab['kebabId'],$filaKebab['name'],$filaKebab['description'],$filaKebab['price']);
                $OrderLine->addKebab($kebab);
            }
            return $OrderLine;
        }
    
        return null; // Devuelve null si no se encuentra la OrderLine
    }

    public function getAll() {
        $stmt = $this->conexion->prepare("SELECT * FROM OrderLine");
        $stmt->execute();
        
        $OrderLines = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $OrderLine = new OrderLine($fila['orderLineID'], $fila['orderID'], $fila['stringJson'], $fila['quantity'], $fila['price']);
            
            // Obtener los kebabs asociados a esta línea de pedido
            $stmtKebab = $this->conexion->prepare("SELECT k.* FROM OrderLineKebab olk JOIN Kebab k ON olk.kebabId = k.kebabId WHERE olk.orderLineId = :orderLineID");
            $stmtKebab->execute(["orderLineID" => $fila['orderLineID']]);
            
            while ($filaKebab = $stmtKebab->fetch(PDO::FETCH_ASSOC)) {
                $kebab = new Kebab($filaKebab['kebabId'],$filaKebab['name'],$filaKebab['description'],$filaKebab['price']);
                $OrderLine->addKebab($kebab);
            }
            
            $OrderLines[] = $OrderLine;
        }
        
        return $OrderLines;
    }

    public function find($criterio) {
        
    }

    public function count() {
        // Implementación del método count
        $stmt = $this->conexion->prepare("SELECT COUNT(*) as total FROM OrderLine");
        $stmt->execute();
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['total'];
        // Devuelve el número total de OrderLines
    }
}
