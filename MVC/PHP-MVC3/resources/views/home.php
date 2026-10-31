<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'PHP MVC') ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px 40px;
            max-width: 650px;
            width: 100%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-top: 5px solid #2563eb;
        }
        h1 {
            color: #1e293b;
            margin-top: 0;
        }
        p {
            color: #475569;
            line-height: 1.6;
            font-size: 16px;
        }
        .badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .links {
            margin-top: 25px;
            display: flex;
            gap: 15px;
        }
        .btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-outline {
            border: 1px solid #cbd5e1;
            color: #334155;
        }
        .btn-outline:hover {
            background: #f8fafc;
        }
    </style>
</head>
<body>

    <div class="container">
        <span class="badge">PHP MVC Architecture</span>
        <h1><?= htmlspecialchars($title ?? 'Home') ?></h1>
        <p><?= htmlspecialchars($message ?? 'Welcome to PHP MVC!') ?></p>

        <div class="links">
            <a href="users" class="btn btn-primary">មើលបញ្ជី Users (/users)</a>
        </div>
    </div>

</body>
</html>
