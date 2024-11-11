<?php

class RepoUser implements RepoCRUD {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // METODOS CRUD
    public function create($user) {
        $stmt = $this->conexion->prepare("INSERT INTO users (username, password, rol, email) VALUES (:username, :password, :rol, :email)");
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $stmt->execute(["username" => $user->getUsername(), "password" => $hashedPassword, "rol" => $user->getRol(), "email" => $user->getEmail()]);
        $userId = $this->conexion->lastInsertId();

        $addresses = $user->getAddresses();
        if (!empty($addresses)) {
            $stmtAddress = $this->conexion->prepare("INSERT INTO addresses (road_name, road_type, road_number, location) VALUES (:road_name, :road_type, :road_number, :location)");
            $stmtUserAddress = $this->conexion->prepare("INSERT INTO user_address (user_id, address_id) VALUES (:user_id, :address_id)");
            
            foreach ($addresses as $address) {
                $stmtAddress->execute(["road_name" => $address->getRoadName(),"road_type" => $address->getRoadType(),"road_number" => $address->getRoadNumber(),"location" => $address->getLocation()]);
                $addressId = $this->conexion->lastInsertId();
    
                // Insertar en la tabla intermedia user_address
                $stmtUserAddress->execute(["user_id" => $userId,"address_id" => $addressId]);
            }
        }
        return true;

        
    }

    public function update($id, $user) {    
        // Actualizar datos del usuario
        $stmt = $this->conexion->prepare("UPDATE users SET username = :username, password = :password, rol = :rol, email = :email WHERE id = :id");
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $stmt->execute(["id" => $id,"username" => $user->getUsername(),"password" => $hashedPassword,"rol" => $user->getRol(),"email" => $user->getEmail()]);
    
        // Eliminar las asociaciones existentes de direcciones
        $stmtDeleteUserAddress = $this->conexion->prepare("DELETE FROM user_address WHERE user_id = :user_id");
        $stmtDeleteUserAddress->execute(["user_id" => $id]);
    
        // Insertar las nuevas direcciones asociadas
        $addresses = $user->getAddresses();
        if (!empty($addresses)) {
            $stmtAddress = $this->conexion->prepare("INSERT INTO addresses (road_name, road_type, road_number, location) VALUES (:road_name, :road_type, :road_number, :location)");
            $stmtUserAddress = $this->conexion->prepare("INSERT INTO user_address (user_id, address_id) VALUES (:user_id, :address_id)");
            
            foreach ($addresses as $address) {
                // Verificar si la dirección ya existe
                $stmtCheckAddress = $this->conexion->prepare("SELECT id FROM addresses WHERE road_name = :road_name AND road_type = :road_type AND road_number = :road_number AND location = :location");
                $stmtCheckAddress->execute(["road_name" => $address->getRoadName(),"road_type" => $address->getRoadType(),"road_number" => $address->getRoadNumber(),"location" => $address->getLocation()]);
                $existingAddress = $stmtCheckAddress->fetch(PDO::FETCH_ASSOC);
    
                if ($existingAddress) {
                    $addressId = $existingAddress['id'];
                } else {
                    $stmtAddress->execute(["road_name" => $address->getRoadName(),"road_type" => $address->getRoadType(),"road_number" => $address->getRoadNumber(),"location" => $address->getLocation()]);
                    $addressId = $this->conexion->lastInsertId();
                }
    
                // Insertar en la tabla intermedia user_address
                $stmtUserAddress->execute(["user_id" => $id,"address_id" => $addressId]);
            }
        }
    
        return true;
    }

    public function delete($id) {
        // Eliminar asociaciones existentes de direcciones
        $stmtDeleteUserAddress = $this->conexion->prepare("DELETE FROM user_address WHERE user_id = :user_id");
        $stmtDeleteUserAddress->execute(["user_id" => $id]);
        
        // Eliminar el usuario
        $stmtDeleteUser = $this->conexion->prepare("DELETE FROM users WHERE id = :id");
        $stmtDeleteUser->execute(["id" => $id]);
        
        return true;
        
    }

    public function getById($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(["id" => $id]);
        
        if ($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new User($fila['id'], $fila['username'], $fila['password'], $fila['rol'], $fila['email']);
            
            // Obtener direcciones asociadas al usuario
            $stmtUserAddress = $this->conexion->prepare("SELECT a.* FROM addresses a INNER JOIN user_address ua ON a.id = ua.address_id WHERE ua.user_id = :user_id");
            $stmtUserAddress->execute(["user_id" => $id]);
            
            while ($fila = $stmtUserAddress->fetch(PDO::FETCH_ASSOC)) {
                $user->addAddress(new Address($fila['id'], $fila['road_name'], $fila['road_type'], $fila['road_number'], $fila['location']));
            }
            
            return $user;
        }
        
    }

    public function getAll() {
        // Obtener todos los usuarios
        $stmt = $this->conexion->prepare("SELECT * FROM users");
        $stmt->execute();
        
        $users = [];
        
        if ($stmt->rowCount() > 0) {
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($fila['id'], $fila['username'], $fila['password'], $fila['rol'], $fila['email']);
                
                // Obtener direcciones asociadas al usuario
                $stmtUserAddress = $this->conexion->prepare("
                    SELECT a.* 
                    FROM addresses a 
                    INNER JOIN user_address ua ON a.id = ua.address_id 
                    WHERE ua.user_id = :user_id
                ");
                $stmtUserAddress->execute(["user_id" => $fila['id']]);
                
                while ($filaAddress = $stmtUserAddress->fetch(PDO::FETCH_ASSOC)) {
                    $address = new Address(
                        $filaAddress['id'], 
                        $filaAddress['road_name'], 
                        $filaAddress['road_type'], 
                        $filaAddress['road_number'], 
                        $filaAddress['location']
                    );
                    $user->addAddress($address);
                }
                
                $users[] = $user;
            }
        }
        
        return $users;
    }

    public function find($criterio) {
        // Implementación del método find
        $stmt = $this->conexion->prepare("SELECT * FROM users WHERE username LIKE :criterio OR email LIKE :criterio");
        $stmt->execute(["criterio" => '%' . $criterio . '%']);
        
        
        if ($stmt->rowCount() > 0) {
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($fila['id'], $fila['username'], $fila['password'], $fila['rol'], $fila['email']);
                
                // Obtener direcciones asociadas al usuario
                $stmtUserAddress = $this->conexion->prepare("SELECT a.* FROM addresses a INNER JOIN user_address ua ON a.id = ua.address_id WHERE ua.user_id = :user_id");
                $stmtUserAddress->execute(["user_id" => $fila['id']]);
                
                while ($filaAddress = $stmtUserAddress->fetch(PDO::FETCH_ASSOC)) {
                    $address = new Address($filaAddress['id'], $filaAddress['road_name'], $filaAddress['road_type'], $filaAddress['road_number'], $filaAddress['location']);
                    $user->addAddress($address);                    
                }
            }
        }
        return $user;
    }

    public function count() {
        // Implementación del método count
        $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM users");
        $stmt->execute();
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['total'];
        // Devuelve el número total de usuarios
        
    }
}