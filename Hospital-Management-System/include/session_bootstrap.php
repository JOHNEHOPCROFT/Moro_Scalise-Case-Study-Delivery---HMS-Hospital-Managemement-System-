<?php

// SSE-SECURITY-FIX: centralized session hardening bootstrap.
if (session_status() === PHP_SESSION_NONE) {
    // SSE-SECURITY-FIX: enable Secure cookies only when the application is actually served over HTTPS.
    // This keeps the hardened behavior for the final secure deployment while allowing localhost/XAMPP
    // testing over plain HTTP without breaking the PHP session and CSRF token lifecycle.
    $secure = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    );
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_secure', $secure ? '1' : '0');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_lifetime', '0');
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    } else {
        session_set_cookie_params(0, '/; samesite=Lax', '', $secure, true);
    }
    session_start();

    // SSE-SECURITY-FIX: bind a lightweight session fingerprint and inactivity timeout.
    if (!isset($_SESSION['sse_user_agent'])) {
        $_SESSION['sse_user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    } elseif ($_SESSION['sse_user_agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown')) {
        session_unset();
        session_destroy();
        session_start();
    }

    $now = time();
    $timeoutSeconds = 1800;
    if (isset($_SESSION['sse_last_activity']) && ($now - (int) $_SESSION['sse_last_activity']) > $timeoutSeconds) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['sse_last_activity'] = $now;
}
