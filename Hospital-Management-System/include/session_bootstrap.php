<?php

// SSE-SECURITY-FIX: centralized session hardening bootstrap.
if (session_status() === PHP_SESSION_NONE) {
    // SSE-SECURITY-FIX: enforce Secure cookies for the target hardened deployment.
    // NOTE: this assumes HTTPS in the final secure environment used for assessment/presentation.
    $secure = true;
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_secure', '1');
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
