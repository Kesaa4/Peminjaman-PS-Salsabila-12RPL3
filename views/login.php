<!-- Halaman login aplikasi peminjaman PS. -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman PS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 50%, #f9a8d4 100%);
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.2), transparent);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: pulse 4s ease-in-out infinite;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(244, 114, 182, 0.2), transparent);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            animation: pulse 4s ease-in-out infinite 2s;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        .login-container { 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 50px 45px; 
            border-radius: 30px; 
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            width: 100%; 
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h2 { 
            text-align: center; 
            background: linear-gradient(135deg, #ec4899, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 35px;
            font-size: 32px;
            font-weight: 700;
        }
        .form-group { margin-bottom: 25px; }
        label { 
            display: block; 
            margin-bottom: 10px; 
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
        }
        input { 
            width: 100%; 
            padding: 15px 20px; 
            border: 2px solid rgba(236, 72, 153, 0.2);
            border-radius: 15px; 
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }
        input:focus { 
            outline: none; 
            border-color: #ec4899;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
            transform: translateY(-2px);
        }
        button { 
            width: 100%; 
            padding: 16px; 
            background: linear-gradient(135deg, #ec4899, #f472b6);
            color: white; 
            border: none; 
            border-radius: 15px; 
            font-size: 16px; 
            cursor: pointer; 
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.3);
            position: relative;
            overflow: hidden;
        }
        button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        button:hover::before {
            width: 400px;
            height: 400px;
        }
        button:hover { 
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(236, 72, 153, 0.5);
        }
        .alert { 
            padding: 15px 20px; 
            margin-bottom: 25px; 
            border-radius: 15px;
            animation: shake 0.5s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .alert-error { 
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-left: 4px solid #b91c1c;
            font-weight: 500;
        }
        .logo {
            text-align: center;
            font-size: 60px;
            margin-bottom: 10px;
            animation: bounce 2s ease infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">🎮</div>
        <h2>Peminjaman PS</h2>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?page=login&action=process">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
