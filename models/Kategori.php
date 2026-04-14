<?php
class Kategori {
    private $conn;
    private $table_name = "kategori";

    // Primary key di tabel adalah kategori_id
    public $id;
    public $nama_kategori;
    public $deskripsi;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table_name} (nama_kategori, deskripsi, created_at)
             VALUES (:nama_kategori, :deskripsi, NOW())"
        );
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        $stmt->bindParam(':deskripsi',     $this->deskripsi);
        return $stmt->execute();
    }

    public function read() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table_name} ORDER BY created_at DESC"
        );
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table_name} WHERE kategori_id = :id LIMIT 1"
        );
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table_name}
             SET nama_kategori = :nama_kategori, deskripsi = :deskripsi
             WHERE kategori_id = :id"
        );
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        $stmt->bindParam(':deskripsi',     $this->deskripsi);
        $stmt->bindParam(':id',            $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table_name} WHERE kategori_id = :id"
        );
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
