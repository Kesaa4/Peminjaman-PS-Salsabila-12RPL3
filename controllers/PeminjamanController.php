<?php
require_once 'models/Peminjaman.php';
require_once 'models/PS.php';

class PeminjamanController {
    private $db;
    private $peminjaman;
    private $ps;

    const DENDA_PER_JAM = 5000;

    public function __construct() {
        $database         = new Database();
        $this->db         = $database->getConnection();
        $this->peminjaman = new Peminjaman($this->db);
        $this->ps         = new PS($this->db);
    }

    public function handleRequest($action) {
        AuthController::checkAuth();
        switch ($action) {
            case 'create':             $this->create();            break;
            case 'store':              $this->store();             break;
            case 'edit':               $this->edit();              break;
            case 'update':             $this->update();            break;
            case 'approve':            $this->approve();           break;
            case 'reject':             $this->reject();            break;
            case 'selesai':            $this->selesai();           break;
            case 'pengembalian':       $this->pengembalian();      break;
            case 'proses_pengembalian': $this->prosesPengembalian(); break;
            default:                   $this->index();             break;
        }
    }

    private function index() {
        if ($_SESSION['role'] === 'peminjam') {
            $this->peminjaman->user_id = $_SESSION['user_id'];
            $stmt = $this->peminjaman->readByUser();
        } else {
            $stmt = $this->peminjaman->read();
        }
        require_once 'views/peminjaman/index.php';
    }

    private function create() {
        AuthController::checkRole(['peminjam']);
        $stmt = $this->ps->readAvailable();
        require_once 'views/peminjaman/create.php';
    }

    private function store() {
        AuthController::checkRole(['peminjam']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (empty($_POST['ps_id']) || empty($_POST['tanggal_pinjam']) ||
            empty($_POST['durasi_jam']) || empty($_POST['total_harga']) ||
            empty($_POST['no_ktp']) || empty($_POST['no_telepon'])) {
            $_SESSION['error'] = "Semua field harus diisi!";
            header('Location: index.php?page=peminjaman&action=create');
            exit();
        }

        $this->peminjaman->user_id       = $_SESSION['user_id'];
        $this->peminjaman->no_ktp        = $_POST['no_ktp'];
        $this->peminjaman->no_telepon    = $_POST['no_telepon'];
        $this->peminjaman->ps_id         = $_POST['ps_id'];
        $this->peminjaman->tanggal_pinjam = $_POST['tanggal_pinjam'];
        $this->peminjaman->durasi_jam    = $_POST['durasi_jam'];
        $this->peminjaman->total_harga   = $_POST['total_harga'];
        $this->peminjaman->status        = 'pending';

        try {
            if ($this->peminjaman->create()) {
                $this->ps->id     = $_POST['ps_id'];
                $this->ps->status = 'dipinjam';
                $this->ps->updateStatus();

                $ps_data = $this->ps->readOne()->fetch(PDO::FETCH_ASSOC);
                ActivityLogController::log('create', 'Mengajukan peminjaman PS: ' . $ps_data['nama_ps'] . ' untuk ' . $_POST['durasi_jam'] . ' jam');

                $_SESSION['success'] = "Peminjaman berhasil diajukan!";
            } else {
                $_SESSION['error'] = "Gagal mengajukan peminjaman!";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
        header('Location: index.php?page=peminjaman&action=index');
        exit();
    }

    private function edit() {
        $this->peminjaman->id = $_GET['id'];
        $data = $this->peminjaman->readOne()->fetch(PDO::FETCH_ASSOC);

        if ($_SESSION['role'] === 'peminjam') {
            if ($data['user_id'] != $_SESSION['user_id'] || $data['status'] !== 'pending') {
                $_SESSION['error'] = "Anda tidak dapat mengedit peminjaman ini!";
                header('Location: index.php?page=peminjaman&action=index');
                exit();
            }
        }

        $ps_stmt = $this->ps->readAvailable();
        require_once 'views/peminjaman/edit.php';
    }

    private function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->peminjaman->id            = $_POST['id'];
        $this->peminjaman->ps_id         = $_POST['ps_id'];
        $this->peminjaman->tanggal_pinjam = $_POST['tanggal_pinjam'];
        $this->peminjaman->durasi_jam    = $_POST['durasi_jam'];
        $this->peminjaman->total_harga   = $_POST['total_harga'];

        if ($this->peminjaman->update()) {
            $_SESSION['success'] = "Peminjaman berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal mengupdate peminjaman!";
        }
        header('Location: index.php?page=peminjaman&action=index');
        exit();
    }

    private function approve() {
        AuthController::checkRole(['admin', 'petugas']);

        $this->peminjaman->id = $_GET['id'];
        $data = $this->peminjaman->readOne()->fetch(PDO::FETCH_ASSOC);

        $this->peminjaman->status      = 'disetujui';
        $this->peminjaman->approved_by = $_SESSION['user_id'];

        if ($this->peminjaman->updateStatus()) {
            ActivityLogController::log('approve', 'Menyetujui peminjaman ID #' . $_GET['id'] . ' oleh ' . $data['nama_peminjam']);
            $_SESSION['success'] = "Peminjaman berhasil disetujui oleh " . $_SESSION['nama'] . "!";
        } else {
            $_SESSION['error'] = "Gagal menyetujui peminjaman!";
        }
        header('Location: index.php?page=peminjaman&action=index');
        exit();
    }

    private function reject() {
        AuthController::checkRole(['admin', 'petugas']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->peminjaman->id = $_POST['id'];
            $data = $this->peminjaman->readOne()->fetch(PDO::FETCH_ASSOC);

            $alasan = trim($_POST['alasan_tolak'] ?? '');
            if (empty($alasan)) {
                $_SESSION['error'] = "Alasan penolakan harus diisi!";
                header('Location: index.php?page=peminjaman&action=index');
                exit();
            }

            $this->peminjaman->status       = 'ditolak';
            $this->peminjaman->approved_by  = $_SESSION['user_id'];
            $this->peminjaman->alasan_tolak = $alasan;

            if ($this->peminjaman->updateStatus()) {
                $this->ps->id     = $data['ps_id'];
                $this->ps->status = 'tersedia';
                $this->ps->updateStatus();

                ActivityLogController::log('reject', 'Menolak peminjaman ID #' . $_POST['id'] . ' - Alasan: ' . $alasan);
                $_SESSION['success'] = "Peminjaman berhasil ditolak!";
            } else {
                $_SESSION['error'] = "Gagal menolak peminjaman!";
            }
            header('Location: index.php?page=peminjaman&action=index');
            exit();
        }

        $this->peminjaman->id = $_GET['id'];
        $data = $this->peminjaman->readOne()->fetch(PDO::FETCH_ASSOC);
        require_once 'views/peminjaman/reject.php';
    }

    private function selesai() {
        AuthController::checkRole(['admin', 'petugas']);
        header('Location: index.php?page=peminjaman&action=pengembalian&id=' . $_GET['id']);
        exit();
    }

    private function pengembalian() {
        AuthController::checkRole(['admin', 'petugas']);
        $this->peminjaman->id = $_GET['id'];
        $data = $this->peminjaman->readOne()->fetch(PDO::FETCH_ASSOC);
        require_once 'views/peminjaman/pengembalian.php';
    }

    private function prosesPengembalian() {
        AuthController::checkRole(['admin', 'petugas']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->peminjaman->id = $_POST['id'];
        $data = $this->peminjaman->readOne()->fetch(PDO::FETCH_ASSOC);

        $this->peminjaman->kondisi_ps = $_POST['kondisi_ps'];
        $this->peminjaman->keterangan = $_POST['keterangan'] ?? '';
        $this->peminjaman->denda      = ($_POST['kondisi_ps'] === 'rusak')
            ? self::DENDA_PER_JAM * $data['durasi_jam']
            : 0;

        if ($this->peminjaman->updatePengembalian()) {
            $this->ps->id     = $data['ps_id'];
            $this->ps->status = 'tersedia';
            $this->ps->updateStatus();

            $denda_text = $this->peminjaman->denda > 0
                ? ' dengan denda Rp ' . number_format($this->peminjaman->denda, 0, ',', '.')
                : ' tanpa denda';
            ActivityLogController::log('return', 'Memproses pengembalian PS ID #' . $_POST['id'] . ' kondisi ' . $_POST['kondisi_ps'] . $denda_text);

            $_SESSION['success'] = $this->peminjaman->denda > 0
                ? "Pengembalian berhasil diproses! Denda: Rp " . number_format($this->peminjaman->denda, 0, ',', '.')
                : "Pengembalian berhasil diproses tanpa denda!";
        } else {
            $_SESSION['error'] = "Gagal memproses pengembalian!";
        }
        header('Location: index.php?page=peminjaman&action=index');
        exit();
    }
}
