<?php
require_once "../middleware/authMiddleware.php";
// Restrict to Admin only. Redirect clients to frontend and guests to login.
$admin = checkAdmin('../frontend/index.php', '../auth/login.php');

require_once "../config/db.php";

// Fetch statistics
$totalUsersResult = $conn->query("SELECT COUNT(*) as count FROM users");
$totalUsers = $totalUsersResult ? $totalUsersResult->fetch_assoc()['count'] : 0;

$adminCountResult = $conn->query("SELECT COUNT(*) as count FROM users WHERE roles = 'admin'");
$totalAdmins = $adminCountResult ? $adminCountResult->fetch_assoc()['count'] : 0;

$clientCountResult = $conn->query("SELECT COUNT(*) as count FROM users WHERE roles = 'client'");
$totalClients = $clientCountResult ? $clientCountResult->fetch_assoc()['count'] : 0;

// Fetch all registered users
$usersResult = $conn->query("SELECT id, username, email, roles, created_at FROM users ORDER BY id DESC");

$successMsg = $_COOKIE['success'] ?? '';
$errorMsg   = $_COOKIE['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Management Console</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-color: #090d16;
            --surface-color: rgba(17, 24, 39, 0.7);
            --surface-border: rgba(255, 255, 255, 0.08);
            --text-main: #f9fafb;
            --text-muted: #9ca3af;
            --accent-purple: #8b5cf6;
            --accent-green: #10b981;
            --accent-blue: #3b82f6;
            --accent-rose: #f43f5e;
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
                radial-gradient(circle at 15% 15%, rgba(99, 102, 241, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(139, 92, 246, 0.12) 0%, transparent 40%);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* Top Navbar */
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
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

        .brand-badge {
            font-size: 11px;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.4);
            border-radius: 6px;
            padding: 2px 8px;
            font-weight: 600;
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
            border: 2px solid rgba(99, 102, 241, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: #c7d2fe;
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
            color: #a78bfa;
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
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 24px;
        }

        /* Hero Banner */
        .dashboard-hero {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.85));
            border: 1px solid var(--surface-border);
            border-radius: 18px;
            padding: 28px 32px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .hero-text h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #ffffff;
        }

        .hero-text p {
            color: var(--text-muted);
            font-size: 14.5px;
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

        /* Metrics grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface-color);
            backdrop-filter: blur(14px);
            border: 1px solid var(--surface-border);
            border-radius: 16px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon.purple {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
        }

        .stat-icon.emerald {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .stat-icon.sky {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-info .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 4px;
            font-weight: 500;
        }

        .stat-info .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
        }

        /* Users Table Card */
        .table-card {
            background: var(--surface-color);
            backdrop-filter: blur(14px);
            border: 1px solid var(--surface-border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        .table-header {
            padding: 22px 28px;
            border-bottom: 1px solid var(--surface-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        .table-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: rgba(15, 23, 42, 0.6);
            padding: 14px 28px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            border-bottom: 1px solid var(--surface-border);
        }

        td {
            padding: 16px 28px;
            font-size: 14px;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .role-pill.admin {
            background: rgba(139, 92, 246, 0.15);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .role-pill.client {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .role-pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .role-pill.admin .role-pill-dot {
            background: #a78bfa;
        }

        .role-pill.client .role-pill-dot {
            background: #34d399;
        }

        .empty-row {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 14px 18px;
            }
            .container {
                padding: 0 16px;
            }
            .dashboard-hero {
                padding: 20px;
            }
            th, td {
                padding: 12px 16px;
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
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <span class="brand-title">Admin Console</span>
                <span class="brand-badge">PRO</span>
            </div>
        </a>

        <div class="nav-user-actions">
            <div class="user-profile">
                <div class="avatar">
                    <?= strtoupper(substr($admin['username'], 0, 1)) ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($admin['username']) ?></span>
                    <span class="user-role-tag">Administrator</span>
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
        
        <!-- Feedback Notifications -->
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

        <!-- Hero Header -->
        <div class="dashboard-hero">
            <div class="hero-text">
                <h2>Welcome to System Administration, <?= htmlspecialchars($admin['username']) ?>!</h2>
                <p>This backend panel is protected by cookie-based <code>checkAdmin()</code> middleware.</p>
            </div>
            <div>
                <span style="font-size: 13px; color: #94a3b8; background: rgba(255,255,255,0.05); padding: 8px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08);">
                    Auth Session: Active (Cookies)
                </span>
            </div>
        </div>

        <!-- Metrics Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Registered Users</div>
                    <div class="stat-value"><?= number_format($totalUsers) ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon emerald">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Administrators</div>
                    <div class="stat-value"><?= number_format($totalAdmins) ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon sky">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Clients</div>
                    <div class="stat-value"><?= number_format($totalClients) ?></div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-card">
            <div class="table-header">
                <div>
                    <h3 class="table-title">System User Directory</h3>
                    <p class="table-subtitle">All users registered in <code>db_auth_cookies.users</code></p>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name / Username</th>
                            <th>Email Address</th>
                            <th>Assigned Role</th>
                            <th>Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($usersResult && $usersResult->num_rows > 0): ?>
                            <?php while ($row = $usersResult->fetch_assoc()): ?>
                                <tr>
                                    <td><span style="font-family: monospace; color: #94a3b8;">#<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?></span></td>
                                    <td><strong style="color: #f8fafc;"><?= htmlspecialchars($row['username']) ?></strong></td>
                                    <td><span style="color: #cbd5e1;"><?= htmlspecialchars($row['email']) ?></span></td>
                                    <td>
                                        <span class="role-pill <?= htmlspecialchars($row['roles']) ?>">
                                            <span class="role-pill-dot"></span>
                                            <?= htmlspecialchars($row['roles']) ?>
                                        </span>
                                    </td>
                                    <td><span style="color: #94a3b8; font-size: 13px;"><?= htmlspecialchars($row['created_at']) ?></span></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-row">No users registered yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
