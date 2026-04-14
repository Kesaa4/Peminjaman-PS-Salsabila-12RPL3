<?php
require_once 'models/ActivityLog.php';

class ActivityLogController {
    private $db;
    private $activityLog;

    public function __construct() {
        $database          = new Database();
        $this->db          = $database->getConnection();
        $this->activityLog = new ActivityLog($this->db);
    }

    private function getFiltersFromRequest() {
        $filters = [];
        $keys = ['user_id', 'action', 'date_from', 'date_to'];
        foreach ($keys as $key) {
            if (!empty($_GET[$key])) {
                $filters[$key] = $_GET[$key];
            }
        }
        return $filters;
    }

    public function index() {
        AuthController::checkRole(['admin', 'petugas']);

        $filters = $this->getFiltersFromRequest();
        $logs    = $this->activityLog->read($filters)->fetchAll(PDO::FETCH_ASSOC);

        $user  = new User($this->db);
        $users = $user->read()->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/activity_log/index.php';
    }

    public function printReport($pdfMode = false) {
        AuthController::checkRole(['admin', 'petugas']);

        $filters   = $this->getFiltersFromRequest();
        $logs      = $this->activityLog->read($filters)->fetchAll(PDO::FETCH_ASSOC);
        $printMode = true;
        $pdfMode   = ($pdfMode === true);

        require_once 'views/activity_log/print.php';
    }

    public function stats() {
        AuthController::checkRole(['admin']);

        $date_from = $_GET['date_from'] ?? null;
        $date_to   = $_GET['date_to']   ?? null;
        $stats     = $this->activityLog->getStats($date_from, $date_to)->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/activity_log/stats.php';
    }

    public static function log($action, $description) {
        if (!isset($_SESSION['user_id'])) return false;

        $database    = new Database();
        $activityLog = new ActivityLog($database->getConnection());
        return $activityLog->log($_SESSION['user_id'], $action, $description);
    }
}
