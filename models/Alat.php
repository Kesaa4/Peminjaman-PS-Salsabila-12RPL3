<?php
// Alat = unit PS. Model ini adalah wrapper untuk tabel `ps`
// yang digunakan di fitur Kategori untuk mengelola PS per kategori.
class Alat {
    private $conn;
    private $table_name = "ps";

    public $id;
    public $kategori_id;
    public $nama_ps;
    public $tipe;
    public $status;
    public $harga_per_jam;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readByKategori() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table_name}
             WHERE kategori_id = :kategori_id ORDER BY nama_ps ASC"
        );
        $stmt->bindParam(':kategori_id', $this->kategori_id);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $stmt = $this->conn->prepare(
            "SELECT p.*, k.nama_kategori FROM {$this->table_name} p
             LEFT JOIN kategori k ON p.kategori_id = k.kategori_id
             WHERE p.id = :id LIMIT 1"
        );
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table_name} (kategori_id, nama_ps, tipe, status, harga_per_jam)
             VALUES (:kategori_id, :nama_ps, :tipe, 'tersedia', :harga_per_jam)"
        );
        $stmt->bindParam(':kategori_id',   $this->kategori_id);
        $stmt->bindParam(':nama_ps',       $this->nama_ps);
        $stmt->bindParam(':tipe',          $this->tipe);
        $stmt->bindParam(':harga_per_jam', $this->harga_per_jam);
        return $stmt->execute();
    }

    public function update() {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table_name}
             SET kategori_id = :kategori_id, nama_ps = :nama_ps, tipe = :tipe,
                 status = :status, harga_per_jam = :harga_per_jam
             WHERE id = :id"
        );
        $stmt->bindParam(':kategori_id',   $this->kategori_id);
        $stmt->bindParam(':nama_ps',       $this->nama_ps);
        $stmt->bindParam(':tipe',          $this->tipe);
        $stmt->bindParam(':status',        $this->status);
        $stmt->bindParam(':harga_per_jam', $this->harga_per_jam);
        $stmt->bindParam(':id',            $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table_name} WHERE id = :id"
        );
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
