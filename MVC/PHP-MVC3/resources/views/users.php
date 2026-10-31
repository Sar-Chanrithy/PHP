<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Users') ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }
        h2 {
            margin: 0;
            color: #1e293b;
        }
        a.back-btn {
            text-decoration: none;
            color: #2563eb;
            font-weight: 600;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        .badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="./" class="back-btn">⬅️ ត្រឡប់ទៅ Home</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ឈ្មោះ</th>
                <th>អ៊ីមែល</th>
                <th>តួនាទី</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><strong><?= htmlspecialchars($user['name']) ?></strong></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($user['role'] ?? 'User') ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #94a3b8;">ពុំមានទិន្នន័យឡើយ</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
