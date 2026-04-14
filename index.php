<?php
ob_start();
session_start();

require_once 'config/Database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/PeminjamanController.php';
require_once 'controllers/PSController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ActivityLogController.php';
require_once 'controllers/KategoriController.php';

$page   = $_GET['page']   ?? 'login';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'login':
        $controller = new AuthController();
        if ($action === 'process') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'dashboard':
        require_once 'views/dashboard.php';
        break;

    case 'peminjaman':
        (new PeminjamanController())->handleRequest($action);
        break;

    case 'ps':
        (new PSController())->handleRequest($action);
        break;

    case 'user':
        (new UserController())->handleRequest($action);
        break;

    case 'activity_log':
        $controller = new ActivityLogController();
        if ($action === 'stats') {
            $controller->stats();
        } elseif (isset($_GET['mode']) && $_GET['mode'] === 'print') {
            $controller->printReport();
        } elseif (isset($_GET['mode']) && $_GET['mode'] === 'pdf') {
            $controller->printReport(true);
        } else {
            $controller->index();
        }
        break;

    case 'kategori':
        (new KategoriController())->handleRequest($action);
        break;

    default:
        header('Location: index.php?page=login');
        break;
}
