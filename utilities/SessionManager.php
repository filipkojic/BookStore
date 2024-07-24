<?php

class SessionManager {
    private static $instance = null;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new SessionManager();
        }
        return self::$instance;
    }

    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function unset($key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_unset();
        session_destroy();
        self::$instance = null;
    }
}
?>
