<?php
require_once "../middleware/authMiddleware.php";
// If already logged in, redirect to respective dashboard
checkGuest();

$successMsg = $_COOKIE['success'] ?? '';
$errorMsg   = $_COOKIE['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Secure Portal</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.15);
            --bg-gradient: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.18) 0%, transparent 40%),
                           radial-gradient(circle at 90% 80%, rgba(236, 72, 153, 0.15) 0%, transparent 40%),
                           #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.75);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-main: #f9fafb;
            --text-muted: #9ca3af;
            --input-bg: rgba(31, 41, 55, 0.6);
            --input-border: rgba(75, 85, 99, 0.4);
            --input-focus: #818cf8;
            --success-bg: rgba(16, 185, 129, 0.15);
            --success-border: rgba(16, 185, 129, 0.3);
            --success-text: #34d399;
            --error-bg: rgba(239, 68, 68, 0.15);
            --error-border: rgba(239, 68, 68, 0.3);
            --error-text: #f87171;
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            background-color: #0b0f19;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient background glow */
        .ambient-glow {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            pointer-events: none;
        }
        .glow-1 {
            top: 10%;
            left: 15%;
            background: rgba(99, 102, 241, 0.25);
        }
        .glow-2 {
            bottom: 10%;
            right: 15%;
            background: rgba(236, 72, 153, 0.2);
        }

        .auth-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 38px 34px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
                        0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-icon-badge {
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
        }

        .auth-icon-badge svg {
            width: 26px;
            height: 26px;
            color: #ffffff;
        }

        .auth-header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 25px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Alert notifications */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }

        .alert-error {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--error-text);
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #e5e7eb;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper svg.field-icon {
            position: absolute;
            left: 14px;
            width: 19px;
            height: 19px;
            color: #6b7280;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-input, .form-select {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 12px;
            padding: 12px 14px 12px 44px;
            color: var(--text-main);
            font-size: 14.5px;
            outline: none;
            transition: all 0.25s ease;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            cursor: pointer;
        }

        .form-select option {
            background: #1f2937;
            color: #f9fafb;
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--input-focus);
            background: rgba(31, 41, 55, 0.85);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .input-wrapper:focus-within svg.field-icon {
            color: var(--input-focus);
        }

        .toggle-pwd-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .toggle-pwd-btn:hover {
            color: #d1d5db;
        }

        .toggle-pwd-btn svg {
            width: 19px;
            height: 19px;
        }

        .role-hint {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 6px;
            display: block;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
            transition: all 0.25s ease;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -5px rgba(16, 185, 129, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .auth-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: #34d399;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
            margin-left: 4px;
        }

        .auth-footer a:hover {
            color: #6ee7b7;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="auth-header">
                <div class="auth-icon-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h1>Create an Account</h1>
                <p>Register a new account with your role</p>
            </div>

            <!-- Feedback Alert Messages -->
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

            <form action="../controller/authController.php" method="POST">
                <div class="form-group">
                    <label class="form-label" for="name">Full Name / Username</label>
                    <div class="input-wrapper">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" id="name" name="name" class="form-input" 
                               placeholder="e.g. John Doe" required autocomplete="name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-wrapper">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                        </svg>
                        <input type="email" id="email" name="email" class="form-input" 
                               placeholder="you@example.com" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="pwd">Password</label>
                    <div class="input-wrapper">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" id="pwd" name="pwd" class="form-input" 
                               placeholder="Minimum 4 characters" required minlength="4">
                        <button type="button" class="toggle-pwd-btn" id="togglePwd" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Select Role</label>
                    <div class="input-wrapper">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <select name="role" id="role" class="form-select">
                            <option value="client">Client (Default User)</option>
                            <option value="admin">Administrator (Backend Panel)</option>
                        </select>
                    </div>
                    <span class="role-hint">Admins will have access to the Backend dashboard; Clients to the Frontend portal.</span>
                </div>

                <button type="submit" name="register" class="submit-btn">
                    <span>Create Account</span>
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <div class="auth-footer">
                Already have an account? 
                <a href="login.php">Sign In</a>
            </div>

        </div>
    </div>

    <script>
        // Password toggle script
        const toggleBtn = document.getElementById('togglePwd');
        const pwdInput = document.getElementById('pwd');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = pwdInput.type === 'password';
            pwdInput.type = isPassword ? 'text' : 'password';
            eyeIcon.innerHTML = isPassword 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        });
    </script>
</body>
</html>