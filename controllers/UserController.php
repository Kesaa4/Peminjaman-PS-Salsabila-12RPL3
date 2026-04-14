<?php
require_once 'models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database   = new Database();
        $this->db   = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function handleRequest($action) {
        AuthController::checkRole(['admin']);
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
        $stmt = $this->user->read();
        require_once 'views/user/index.php';
    }

    private function create() {
        require_once 'views/user/create.php';
    }

    private function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $isPetugas = ($_POST['role'] ?? '') === 'petugas';
        $this->user->username = $_POST['username'];
        $this->user->password = $_POST['password'];
        $this->user->nama     = $isPetugas ? $_POST['username'] : trim($_POST['nama'] ?? '');
        $this->user->role     = $_POST['role'];

        if ($this->user->create()) {
            ActivityLogController::log('create', 'Menambahkan user baru: ' . $this->user->nama . ' (' . $this->user->username . ')');
            $_SESSION['success'] = "User berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan user!";
        }
        header('Location: index.php?page=user&action=index');
        exit();
    }

    private function edit() {
        $this->user->id = $_GET['id'];
        $stmt = $this->user->readOne();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        require_once 'views/user/edit.php';
    }

    private function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $isPetugas = ($_POST['role'] ?? '') === 'petugas';
        $this->user->id       = $_POST['id'];
        $this->user->username = $_POST['username'];
        $this->user->password = $_POST['password'];
        $this->user->nama     = $isPetugas ? $_POST['username'] : trim($_POST['nama'] ?? '');
        $this->user->role     = $_POST['role'];

        if ($this->user->update()) {
            ActivityLogController::log('update', 'Mengupdate user: ' . $this->user->nama . ' (' . $this->user->username . ')');
            $_SESSION['success'] = "User berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal mengupdate user!";
        }
        header('Location: index.php?page=user&action=index');
        exit();
    }

    private function delete() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=user&action=index');
            exit();
        }

        if ($_GET['id'] == $_SESSION['user_id']) {
            $_SESSION['error'] = "Tidak bisa menghapus akun sendiri!";
            header('Location: index.php?page=user&action=index');
            exit();
        }

        $this->user->id = $_GET['id'];
        if ($this->user->delete()) {
            ActivityLogController::log('delete', 'Menghapus user id: ' . $_GET['id']);
            $_SESSION['success'] = "User berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus user!";
        }
        header('Location: index.php?page=user&action=index');
        exit();
    }
}
