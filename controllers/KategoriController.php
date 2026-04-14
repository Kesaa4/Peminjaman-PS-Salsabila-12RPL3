<?php
require_once 'models/Kategori.php';
require_once 'models/Alat.php';

class KategoriController {
    private $db;
    private $kategori;
    private $alat;

    public function __construct() {
        $database       = new Database();
        $this->db       = $database->getConnection();
        $this->kategori = new Kategori($this->db);
        $this->alat     = new Alat($this->db);
    }

    public function handleRequest($action) {
        AuthController::checkRole(['admin', 'petugas']);
        switch ($action) {
            case 'create':      $this->create();      break;
            case 'store':       $this->store();       break;
            case 'edit':        $this->edit();        break;
            case 'update':      $this->update();      break;
            case 'delete':      $this->delete();      break;
            case 'detail':      $this->detail();      break;
            case 'alat_create': $this->alatCreate();  break;
            case 'alat_store':  $this->alatStore();   break;
            case 'alat_edit':   $this->alatEdit();    break;
            case 'alat_update': $this->alatUpdate();  break;
            case 'alat_delete': $this->alatDelete();  break;
            default:            $this->index();       break;
        }
    }

    private function index() {
        $stmt = $this->kategori->read();
        require_once 'views/kategori/index.php';
    }

    private function create() {
        require_once 'views/kategori/create.php';
    }

    private function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->kategori->nama_kategori = $_POST['nama_kategori'];
        $this->kategori->deskripsi     = $_POST['deskripsi'];

        if ($this->kategori->create()) {
            $_SESSION['success'] = "Kategori berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan kategori!";
        }
        header('Location: index.php?page=kategori&action=index');
        exit();
    }

    private function edit() {
        $this->kategori->id = $_GET['id'];
        $stmt = $this->kategori->readOne();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        require_once 'views/kategori/edit.php';
    }

    private function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->kategori->id            = $_POST['id'];
        $this->kategori->nama_kategori = $_POST['nama_kategori'];
        $this->kategori->deskripsi     = $_POST['deskripsi'];

        if ($this->kategori->update()) {
            $_SESSION['success'] = "Kategori berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal mengupdate kategori!";
        }
        header('Location: index.php?page=kategori&action=index');
        exit();
    }

    private function delete() {
        $this->kategori->id = $_GET['id'];
        if ($this->kategori->delete()) {
            $_SESSION['success'] = "Kategori berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus kategori!";
        }
        header('Location: index.php?page=kategori&action=index');
        exit();
    }

    private function detail() {
        $this->kategori->id = $_GET['id'];
        $stmtKategori       = $this->kategori->readOne();
        $dataKategori       = $stmtKategori->fetch(PDO::FETCH_ASSOC);
        $this->alat->kategori_id = $_GET['id'];
        $stmtAlat           = $this->alat->readByKategori();
        require_once 'views/kategori/detail.php';
    }

    private function alatCreate() {
        $this->kategori->id = $_GET['kategori_id'];
        $stmtKategori       = $this->kategori->readOne();
        $dataKategori       = $stmtKategori->fetch(PDO::FETCH_ASSOC);
        require_once 'views/kategori/alat_create.php';
    }

    private function alatStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->alat->kategori_id   = $_POST['kategori_id'];
        $this->alat->nama_ps       = $_POST['nama_ps'];
        $this->alat->tipe          = $_POST['tipe'];
        $this->alat->harga_per_jam = $_POST['harga_per_jam'];

        if ($this->alat->create()) {
            $_SESSION['success'] = "PS berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan PS!";
        }
        header('Location: index.php?page=kategori&action=detail&id=' . $_POST['kategori_id']);
        exit();
    }

    private function alatEdit() {
        $this->alat->id = $_GET['id'];
        $stmtAlat       = $this->alat->readOne();
        $dataAlat       = $stmtAlat->fetch(PDO::FETCH_ASSOC);
        require_once 'views/kategori/alat_edit.php';
    }

    private function alatUpdate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->alat->id           = $_POST['id'];
        $this->alat->kategori_id  = $_POST['kategori_id'];
        $this->alat->nama_ps      = $_POST['nama_ps'];
        $this->alat->tipe         = $_POST['tipe'];
        $this->alat->status       = $_POST['status'];
        $this->alat->harga_per_jam = $_POST['harga_per_jam'];

        if ($this->alat->update()) {
            $_SESSION['success'] = "PS berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal mengupdate PS!";
        }
        header('Location: index.php?page=kategori&action=detail&id=' . $_POST['kategori_id']);
        exit();
    }

    private function alatDelete() {
        $this->alat->id = $_GET['id'];
        $kategori_id    = $_GET['kategori_id'];

        if ($this->alat->delete()) {
            $_SESSION['success'] = "PS berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus PS!";
        }
        header('Location: index.php?page=kategori&action=detail&id=' . $kategori_id);
        exit();
    }
}
