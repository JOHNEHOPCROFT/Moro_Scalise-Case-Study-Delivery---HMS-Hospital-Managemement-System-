<?php

// SSE-SECURITY-FIX: centralized security helpers for input handling,
// password verification, output encoding and CSRF/session-related utilities.

if (!function_exists('sse_clean_input')) {
    function sse_clean_input($value)
    {
        return trim((string)$value);
    }
}

if (!function_exists('sse_verify_password_compat')) {
    function sse_verify_password_compat($plainPassword, $storedPassword)
    {
        if (!is_string($storedPassword) || $storedPassword === '') {
            return false;
        }

        if (password_get_info($storedPassword)['algo'] !== null) {
            return password_verify($plainPassword, $storedPassword);
        }

        // SSE-SECURITY-FIX: legacy compatibility for pre-existing plaintext records.
        return hash_equals($storedPassword, $plainPassword);
    }
}

if (!function_exists('sse_hash_password_if_needed')) {
    function sse_hash_password_if_needed($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

if (!function_exists('sse_e')) {
    function sse_e($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('sse_regenerate_session')) {
    function sse_regenerate_session()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}

if (!function_exists('sse_generate_csrf_token')) {
    function sse_generate_csrf_token()
    {
        if (empty($_SESSION['sse_csrf_token'])) {
            $_SESSION['sse_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['sse_csrf_token'];
    }
}

if (!function_exists('sse_verify_csrf_token')) {
    function sse_verify_csrf_token($token)
    {
        return isset($_SESSION['sse_csrf_token']) && is_string($token) && hash_equals($_SESSION['sse_csrf_token'], $token);
    }
}

if (!function_exists('sse_send_no_cache_headers')) {
    function sse_send_no_cache_headers()
    {
        if (!headers_sent()) {
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('Expires: 0');
        }
    }
}

if (!function_exists('sse_clear_session_data')) {
    function sse_clear_session_data()
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
        }
    }
}

if (!function_exists('sse_destroy_session')) {
    function sse_destroy_session()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return;
        }

        sse_clear_session_data();

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'] ?? '/',
                $params['domain'] ?? '',
                (bool) ($params['secure'] ?? false),
                (bool) ($params['httponly'] ?? true)
            );
        }

        session_destroy();
    }
}

if (!function_exists('sse_require_session_keys')) {
    function sse_require_session_keys(array $requiredKeys, $redirectTo = 'index.php')
    {
        sse_send_no_cache_headers();

        foreach ($requiredKeys as $key) {
            if (!isset($_SESSION[$key]) || $_SESSION[$key] === '') {
                sse_destroy_session();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if (!headers_sent()) {
                    header('Location: ' . $redirectTo);
                }
                exit;
            }
        }
    }
}

if (!function_exists('sse_require_authenticated_patient')) {
    function sse_require_authenticated_patient($redirectTo = 'index1.php')
    {
        sse_require_session_keys(['pid', 'username', 'email'], $redirectTo);
    }
}

if (!function_exists('sse_require_authenticated_doctor')) {
    function sse_require_authenticated_doctor($redirectTo = 'index.php')
    {
        sse_require_session_keys(['dname'], $redirectTo);
    }
}

if (!function_exists('sse_require_authenticated_admin')) {
    function sse_require_authenticated_admin($redirectTo = 'index.php')
    {
        sse_require_session_keys(['username'], $redirectTo);
    }
}