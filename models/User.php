<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $nama;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $stmt = $this->conn->prepare(
            "SELECT id, username, password, nama, role FROM {$this->table_name}
             WHERE username = :username LIMIT 1"
        );
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table_name} (username, password, nama, role)
             VALUES (:username, :password, :nama, :role)"
        );
        $hashed = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':nama',     $this->nama);
        $stmt->bindParam(':role',     $this->role);
        return $stmt->execute();
    }

    public function read() {
        $stmt = $this->conn->prepare(
            "SELECT id, username, nama, role, created_at FROM {$this->table_name} ORDER BY created_at DESC"
        );
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $stmt = $this->conn->prepare(
            "SELECT id, username, nama, role FROM {$this->table_name} WHERE id = :id LIMIT 1"
        );
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE {$this->table_name} SET username = :username, nama = :nama, role = :role";
        if (!empty($this->password)) {
            $query .= ", password = :password";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':nama',     $this->nama);
        $stmt->bindParam(':role',     $this->role);
        $stmt->bindParam(':id',       $this->id);

        if (!empty($this->password)) {
            $hashed = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashed);
        }
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
