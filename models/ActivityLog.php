<?php
class ActivityLog {
    private $conn;
    private $table_name = "activity_logs";

    public $id;
    public $user_id;
    public $action;
    public $description;
    public $ip_address;
    public $user_agent;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function log($user_id, $action, $description) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table_name} (user_id, action, description, ip_address, user_agent)
             VALUES (:user_id, :action, :description, :ip_address, :user_agent)"
        );
        $ip         = $_SERVER['REMOTE_ADDR']     ?? 'Unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        $stmt->bindParam(':user_id',     $user_id);
        $stmt->bindParam(':action',      $action);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':ip_address',  $ip);
        $stmt->bindParam(':user_agent',  $user_agent);
        return $stmt->execute();
    }

    public function read($filters = []) {
        $query = "SELECT al.*, u.username, u.nama
                  FROM {$this->table_name} al
                  LEFT JOIN users u ON al.user_id = u.id
                  WHERE 1=1";

        if (!empty($filters['user_id']))   $query .= " AND al.user_id = :user_id";
        if (!empty($filters['action']))    $query .= " AND al.action = :action";
        if (!empty($filters['date_from'])) $query .= " AND DATE(al.created_at) >= :date_from";
        if (!empty($filters['date_to']))   $query .= " AND DATE(al.created_at) <= :date_to";

        $query .= " ORDER BY al.created_at DESC";

        if (!empty($filters['limit'])) $query .= " LIMIT :limit";

        $stmt = $this->conn->prepare($query);

        if (!empty($filters['user_id']))   $stmt->bindParam(':user_id',   $filters['user_id']);
        if (!empty($filters['action']))    $stmt->bindParam(':action',    $filters['action']);
        if (!empty($filters['date_from'])) $stmt->bindParam(':date_from', $filters['date_from']);
        if (!empty($filters['date_to']))   $stmt->bindParam(':date_to',   $filters['date_to']);
        if (!empty($filters['limit']))     $stmt->bindParam(':limit',     $filters['limit'], PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    public function getStats($date_from = null, $date_to = null) {
        $query = "SELECT action, COUNT(*) as count FROM {$this->table_name} WHERE 1=1";

        if ($date_from) $query .= " AND DATE(created_at) >= :date_from";
        if ($date_to)   $query .= " AND DATE(created_at) <= :date_to";

        $query .= " GROUP BY action ORDER BY count DESC";

        $stmt = $this->conn->prepare($query);
        if ($date_from) $stmt->bindParam(':date_from', $date_from);
        if ($date_to)   $stmt->bindParam(':date_to',   $date_to);

        $stmt->execute();
        return $stmt;
    }

    public function deleteOldLogs($days = 90) {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table_name} WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)"
        );
        $stmt->bindParam(':days', $days, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
