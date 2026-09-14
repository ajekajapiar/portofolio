<?php

session_start();

if (!isset($_COOKIE['admin_auth'])) {
    header("Location: login.php");
    exit;
}

$token = $_COOKIE['admin_auth'];

$parts = explode('.', $token, 2);

if (count($parts) !== 2) {
    setcookie('admin_auth', '', time() - 3600, '/');
    header("Location: login.php");
    exit;
}

$payload = $parts[0];
$signature = $parts[1];

$secret = getenv('ADMIN_AUTH_SECRET');

if (!$secret) {
    die('Authentication configuration is missing.');
}

$expectedSignature = hash_hmac(
    'sha256',
    $payload,
    $secret
);

if (!hash_equals($expectedSignature, $signature)) {
    setcookie('admin_auth', '', time() - 3600, '/');
    header("Location: login.php");
    exit;
}

$data = json_decode(
    base64_decode($payload),
    true
);

if (
    !is_array($data) ||
    !isset($data['id']) ||
    !isset($data['username'])
) {
    setcookie('admin_auth', '', time() - 3600, '/');
    header("Location: login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Restore admin information for the current request
|--------------------------------------------------------------------------
*/

$_SESSION['admin_id'] = (int) $data['id'];
$_SESSION['admin_username'] = $data['username'];