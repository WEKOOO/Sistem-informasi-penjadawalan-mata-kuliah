<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjadwalan Mata Kuliah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #f0f8ff, #e0f2f1, #f5f5f5);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .login-container {
            background-color: #fff;
            border: 1px solid #e0f2f1;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 32px;
            width: 100%;
            max-width: 400px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .header .calendar-icon {
            font-size: 48px;
            color: #1e88e5;
            animation: pulse 2s infinite;
        }

        .header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #0d47a1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .header p {
            color: #546e7a;
            font-size: 14px;
        }

        .form-group {
            position: relative;
            margin-bottom: 16px;
        }

        .form-group .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #90a4ae;
            transition: color 0.3s;
        }

        .form-group input {
            width: 100%;
            padding: 12px 40px;
            font-size: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f5f5f5;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1e88e5;
            background-color: #fff;
        }

        .form-group input:focus + .icon {
            color: #1e88e5;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
        }

        .form-actions label {
            color: #546e7a;
            font-size: 14px;
        }

        .form-actions a {
            color: #1e88e5;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .form-actions a:hover {
            color: #0d47a1;
        }

        .submit-button {
            background-color: #1e88e5;
            color: #fff;
            margin: 1vh 5vh 1vh 10vh;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .submit-button:hover {
            background-color: #0d47a1;
            transform: scale(1.05);
        }

        .submit-button .icon {
            margin-left: 8px;
            animation: rotate 2s infinite linear;
        }

        .footer {
            text-align: center;
            color: #90a4ae;
            font-size: 12px;
            margin-top: 16px;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header">
            <div class="calendar-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h2>
                <i class="fas fa-clock"></i>
                Sistem Penjadwalan
            </h2>
            <p>Portal Jadwal Mata Kuliah</p>
        </div>

        @yield('content')

        <div class="footer">
            © 2024 Sistem Informasi Penjadwalan Mata Kuliah
        </div>
    </div>
</body>
</html>