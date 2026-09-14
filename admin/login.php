<?php

session_start();

require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {

        $error = 'Username dan password wajib diisi.';

    } else {

        $stmt = $pdo->prepare("
            SELECT id, username, password
            FROM users
            WHERE username = ?
            LIMIT 1
        ");

        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $secret = getenv('ADMIN_AUTH_SECRET');

            if (!$secret) {
                die('Authentication configuration is missing.');
            }

            $payload = base64_encode(json_encode([
                'id' => (int) $user['id'],
                'username' => $user['username']
            ]));

            $signature = hash_hmac(
                'sha256',
                $payload,
                $secret
            );

            $token = $payload . '.' . $signature;

            setcookie(
                'admin_auth',
                $token,
                [
                    'expires' => time() + (60 * 60 * 24 * 7),
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );

            header("Location: dashboard.php");
            exit;

        } else {

            $error = 'Username atau password salah.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Login | Portfolio</title>

    <link
        rel="stylesheet"
        href="../assets/css/admin.css"
    >

</head>

<body>

<div class="login-page">

    <div class="login-container">

        <div class="login-brand">

            <h1>Portfolio</h1>

            <p>Administrator Panel</p>

        </div>

        <div class="login-card">

            <h2 style="margin-bottom: 8px;">
                Welcome back
            </h2>

            <p style="color: #6b7280; font-size: 14px; margin-bottom: 25px;">
                Sign in to manage your portfolio.
            </p>

            <?php if ($error): ?>

                <div class="alert alert-danger">
                    <?= htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        autocomplete="username"
                        placeholder="Enter your username"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-full"
                >
                    Sign In
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>