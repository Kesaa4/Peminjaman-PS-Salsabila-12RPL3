<?php
require_once 'models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database   = new Database();
        $this->db   = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=dashboard');
            exit();
        }
        require_once 'views/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->user->username = $_POST['username'];
        $stmt = $this->user->login();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($_POST['password'], $row['password'])) {
                $_SESSION['user_id']  = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['nama']     = $row['nama'];
                $_SESSION['role']     = $row['role'];

                ActivityLogController::log('login', 'User login ke sistem');

                header('Location: index.php?page=dashboard');
                exit();
            }
            $_SESSION['error'] = "Password salah!";
        } else {
            $_SESSION['error'] = "Username tidak ditemukan!";
        }
        header('Location: index.php?page=login');
        exit();
    }

    public function logout() {
        ActivityLogController::log('logout', 'User logout dari sistem');
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }

    public static function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }
    }

    public static function checkRole(array $allowed_roles) {
        self::checkAuth();
        if (!in_array($_SESSION['role'], $allowed_roles)) {
            $_SESSION['error'] = "Anda tidak memiliki akses ke halaman ini!";
            header('Location: index.php?page=dashboard');
            exit();
        }
    }
}
