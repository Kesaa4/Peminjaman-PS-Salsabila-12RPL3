<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman PS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 50%, #f9a8d4 100%);
            min-height: 100vh;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(236,72,153,0.1)"/></svg>');
            pointer-events: none;
            z-index: 0;
        }
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            color: #ec4899;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 30px rgba(236,72,153,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 2px solid rgba(236,72,153,0.2);
        }
        .navbar h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #ec4899, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(236,72,153,0.3);
        }
        .navbar-menu { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .navbar-menu a {
            color: #ec4899;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }
        .navbar-menu a::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(236,72,153,0.1), transparent);
            transition: left 0.5s;
        }
        .navbar-menu a:hover::before { left: 100%; }
        .navbar-menu a:hover { background: rgba(236,72,153,0.1); transform: translateY(-2px); }
        .navbar-menu span {
            padding: 10px 20px;
            background: linear-gradient(135deg, #ec4899, #f472b6);
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            color: white;
        }
        .content {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 30px;
            position: relative;
            z-index: 1;
        }
        .content h1 {
            color: white;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .alert {
            padding: 18px 24px;
            margin-bottom: 25px;
            border-radius: 15px;
            font-weight: 500;
            animation: slideDown 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-left: 4px solid #047857;
        }
        .alert-error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-left: 4px solid #b91c1c;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #ec4899, #f472b6);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(236,72,153,0.3);
            position: relative;
            overflow: hidden;
            min-height: 48px;
            white-space: nowrap;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn:hover::before { width: 300px; height: 300px; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 6px 25px rgba(236,72,153,0.5); }
        .btn-primary   { background: linear-gradient(135deg, #ec4899, #f472b6); }
        .btn-secondary { background: linear-gradient(135deg, #64748b, #94a3b8); }
        .btn-success   { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 15px rgba(16,185,129,0.3); }
        .btn-success:hover { box-shadow: 0 6px 25px rgba(16,185,129,0.5); }
        .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); box-shadow: 0 4px 15px rgba(239,68,68,0.3); }
        .btn-danger:hover  { box-shadow: 0 6px 25px rgba(239,68,68,0.5); }
        .btn-warning   { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 15px rgba(245,158,11,0.3); color: white; }
        .btn-warning:hover { box-shadow: 0 6px 25px rgba(245,158,11,0.5); }
        .btn-info      { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 4px 15px rgba(59,130,246,0.3); color: white; }
        .btn-sm        { padding: 8px 16px; font-size: 13px; }
        .button-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-top: 10px;
        }
        .button-row .btn { margin: 0; }
        .button-row .btn:not(.btn-primary) { min-width: 140px; }
        table {
            width: 100%;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-collapse: collapse;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            border-radius: 20px;
            overflow: hidden;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }
        th, td { padding: 16px; text-align: left; border-bottom: 1px solid rgba(236,72,153,0.1); }
        th {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tr { transition: all 0.3s ease; }
        tr:hover {
            background: linear-gradient(90deg, rgba(236,72,153,0.05), rgba(244,114,182,0.05));
            transform: scale(1.01);
        }
        .form-group { margin-bottom: 24px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(236,72,153,0.2);
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ec4899;
            box-shadow: 0 0 0 4px rgba(236,72,153,0.1);
            transform: translateY(-2px);
        }
        .form-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            max-width: 700px;
            animation: fadeIn 0.5s ease;
        }
        .welcome-box {
            background: linear-gradient(135deg, rgba(236,72,153,0.9), rgba(244,114,182,0.9));
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(236,72,153,0.3);
            margin-bottom: 40px;
            color: white;
            animation: fadeIn 0.5s ease;
        }
        .welcome-box h2 { margin-bottom: 10px; font-size: 32px; }
        .welcome-box p  { font-size: 16px; opacity: 0.95; }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
        }
        .card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(236,72,153,0.15);
            transition: all 0.4s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 4px;
            background: linear-gradient(90deg, #ec4899, #f472b6);
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 48px rgba(236,72,153,0.3);
            border-color: rgba(236,72,153,0.3);
        }
        .card h3 {
            margin-bottom: 12px;
            background: linear-gradient(135deg, #ec4899, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 24px;
        }
        .card p { margin-bottom: 24px; color: #64748b; line-height: 1.6; }
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-pending    { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
        .badge-disetujui  { background: linear-gradient(135deg, #34d399, #10b981); color: white; }
        .badge-ditolak    { background: linear-gradient(135deg, #f87171, #ef4444); color: white; }
        .badge-selesai    { background: linear-gradient(135deg, #94a3b8, #64748b); color: white; }
        .badge-tersedia   { background: linear-gradient(135deg, #34d399, #10b981); color: white; }
        .badge-dipinjam   { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
        .badge-baik       { background: linear-gradient(135deg, #34d399, #10b981); color: white; }
        .badge-rusak      { background: linear-gradient(135deg, #f87171, #ef4444); color: white; }
        .badge-perbaikan  { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
        footer {
            text-align: center;
            padding: 30px;
            color: rgba(255,255,255,0.8);
            margin-top: 60px;
            font-size: 14px;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 20px;
        }
        .table-responsive table {
            min-width: 600px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🎮 Peminjaman PS</h1>
        <div class="navbar-menu">
            <a href="index.php?page=dashboard">Dashboard</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="index.php?page=user&action=index">User</a>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas'): ?>
                <a href="index.php?page=ps&action=index">PS</a>
                <a href="index.php?page=kategori&action=index">Kategori</a>
            <?php endif; ?>
            <a href="index.php?page=peminjaman&action=index">Peminjaman</a>
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas'): ?>
                <a href="index.php?page=activity_log">Log Aktivitas</a>
            <?php endif; ?>
            <span><?php echo htmlspecialchars($_SESSION['nama']); ?> (<?php echo ucfirst($_SESSION['role']); ?>)</span>
            <a href="index.php?page=logout" style="background: rgba(239,68,68,0.2);">Logout</a>
        </div>
    </nav>
