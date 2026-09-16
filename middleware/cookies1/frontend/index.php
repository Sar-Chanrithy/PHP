<?php
require_once "../middleware/authMiddleware.php";
// Protect route: Ensure user is logged in
$user = checkAuth('../auth/login.php');

$successMsg = $_COOKIE['success'] ?? '';
$errorMsg   = $_COOKIE['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal - Dashboard</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10b981;
            --primary-hover: #059669;
            --bg-color: #0b0f19;
            --surface-color: rgba(17, 24, 39, 0.7);
            --surface-border: rgba(255, 255, 255, 0.08);
            --text-main: #f9fafb;
            --text-muted: #9ca3af;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(circle at 85% 15%, rgba(16, 185, 129, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 15% 85%, rgba(59, 130, 246, 0.1) 0%, transparent 40%);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* Navbar */
        .navbar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--surface-border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .brand-icon svg {
            width: 22px;
            height: 22px;
            color: #fff;
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .nav-user-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: #1e293b;
            border: 2px solid rgba(16, 185, 129, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: #a7f3d0;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #f3f4f6;
            display: block;
        }

        .user-role-tag {
            font-size: 11.5px;
            color: #34d399;
            font-weight: 500;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            border-color: #ef4444;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .logout-btn svg {
            width: 16px;
            height: 16px;
        }

        /* Container */
        .container {
            max-width: 1000px;
            margin: 36px auto;
            padding: 0 24px;
        }

        /* Alerts */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Hero banner */
        .welcome-hero {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.9));
            border: 1px solid var(--surface-border);
            border-radius: 20px;
            padding: 36px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .welcome-hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .welcome-hero p {
            color: var(--text-muted);
            font-size: 15px;
            max-width: 600px;
            line-height: 1.6;
        }

        /* Grid */
        .portal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .card {
            background: var(--surface-color);
            backdrop-filter: blur(14px);
            border: 1px solid var(--surface-border);
            border-radius: 18px;
            padding: 26px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .card-icon svg {
            width: 22px;
            height: 22px;
        }

        .card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 14px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-muted);
        }

        .detail-value {
            font-weight: 600;
            color: #f1f5f9;
        }

        .role-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 12px;
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 14px 18px;
            }
            .container {
                padding: 0 16px;
            }
            .welcome-hero {
                padding: 24px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <header class="navbar">
        <a href="index.php" class="nav-brand">
            <div class="brand-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <span class="brand-title">Client Portal</span>
            </div>
        </a>

        <div class="nav-user-actions">
            <div class="user-profile">
                <div class="avatar">
                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($user['username']) ?></span>
                    <span class="user-role-tag"><?= htmlspecialchars(ucfirst($user['role'])) ?></span>
                </div>
            </div>
            <a href="../auth/logout.php" class="logout-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </a>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container">

        <!-- Alerts -->
        <?php if (!empty($successMsg)): ?>
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span><?= htmlspecialchars($successMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-error">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span><?= htmlspecialchars($errorMsg) ?></span>
            </div>
        <?php endif; ?>

        <!-- Welcome Banner -->
        <div class="welcome-hero">
            <h1>Hello, <?= htmlspecialchars($user['username']) ?>!</h1>
            <p>Welcome to your Client Dashboard. Your session is authenticated using cookies, and route access is secured by the authentication middleware.</p>
        </div>

        <!-- Cards -->
        <div class="portal-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="card-title">Profile Information</h2>
                </div>
                <div class="detail-row">
                    <span class="detail-label">User ID:</span>
                    <span class="detail-value">#<?= htmlspecialchars($user['id']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['username']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Account Role:</span>
                    <span class="role-badge"><?= htmlspecialchars($user['role']) ?></span>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h2 class="card-title">Security & Middleware</h2>
                </div>
                <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px;">
                    This route is protected by <code>checkAuth()</code>. Non-authenticated guests will be redirected to the login page immediately.
                </p>
                <div class="detail-row">
                    <span class="detail-label">Cookie Status:</span>
                    <span class="detail-value" style="color: #34d399;">Valid & Active</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Admin Routes:</span>
                    <span class="detail-value" style="color: #f87171;">Protected / Restricted</span>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
