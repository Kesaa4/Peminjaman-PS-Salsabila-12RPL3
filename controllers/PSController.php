<?php
require_once 'models/PS.php';
require_once 'models/Kategori.php';

class PSController {
    private $db;
    private $ps;
    private $kategori;

    public function __construct() {
        $database       = new Database();
        $this->db       = $database->getConnection();
        $this->ps       = new PS($this->db);
        $this->kategori = new Kategori($this->db);
    }

    public function handleRequest($action) {
        AuthController::checkRole(['admin', 'petugas']);
        switch ($action) {
            case 'create': $this->create(); break;
            case 'store':  $this->store();  break;
            case 'edit':   $this->edit();   break;
            case 'update': $this->update(); break;
            case 'delete': $this->delete(); break;
            default:       $this->index();  break;
        }
    }

    private function index() {
        $stmt = $this->ps->read();
        require_once 'views/ps/index.php';
    }

    private function create() {
        $stmtKategori = $this->kategori->read();
        $kategoriList = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/ps/create.php';
    }

    private function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->ps->kategori_id   = $_POST['kategori_id'] ?: null;
        $this->ps->nama_ps       = $_POST['nama_ps'];
        $this->ps->tipe          = $_POST['tipe'];
        $this->ps->status        = $_POST['status'];
        $this->ps->harga_per_jam = $_POST['harga_per_jam'];

        if ($this->ps->create()) {
            ActivityLogController::log('create', 'Menambahkan PS baru: ' . $_POST['nama_ps'] . ' (' . $_POST['tipe'] . ')');
            $_SESSION['success'] = "PS berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan PS!";
        }
        header('Location: index.php?page=ps&action=index');
        exit();
    }

    private function edit() {
        $this->ps->id = $_GET['id'];
        $data = $this->ps->readOne()->fetch(PDO::FETCH_ASSOC);

        $stmtKategori = $this->kategori->read();
        $kategoriList = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/ps/edit.php';
    }

    private function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->ps->id            = $_POST['id'];
        $this->ps->kategori_id   = $_POST['kategori_id'] ?: null;
        $this->ps->nama_ps       = $_POST['nama_ps'];
        $this->ps->tipe          = $_POST['tipe'];
        $this->ps->status        = $_POST['status'];
        $this->ps->harga_per_jam = $_POST['harga_per_jam'];

        if ($this->ps->update()) {
            ActivityLogController::log('update', 'Mengupdate PS: ' . $_POST['nama_ps'] . ' (' . $_POST['tipe'] . ')');
            $_SESSION['success'] = "PS berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal mengupdate PS!";
        }
        header('Location: index.php?page=ps&action=index');
        exit();
    }

    private function delete() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=ps&action=index');
            exit();
        }

        $this->ps->id = $_GET['id'];
        $data = $this->ps->readOne()->fetch(PDO::FETCH_ASSOC);

        if ($data && $data['status'] === 'dipinjam') {
            $_SESSION['error'] = "PS tidak bisa dihapus karena sedang dipinjam!";
            header('Location: index.php?page=ps&action=index');
            exit();
        }

        if ($this->ps->delete()) {
            ActivityLogController::log('delete', 'Menghapus PS id: ' . $_GET['id']);
            $_SESSION['success'] = "PS berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus PS!";
        }
        header('Location: index.php?page=ps&action=index');
        exit();
    }
}
