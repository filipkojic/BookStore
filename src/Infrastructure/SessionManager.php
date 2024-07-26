<?php

/**
 * Class SessionManager
 *
 * Singleton class to manage PHP sessions.
 */
class SessionManager {
    /**
     * @var SessionManager|null The single instance of the class.
     */
    private static $instance = null;

    /**
     * Private constructor to prevent multiple instances.
     */
    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get the single instance of the class.
     *
     * @return SessionManager The single instance of the class.
     */
    public static function getInstance(): SessionManager {
        if (self::$instance == null) {
            self::$instance = new SessionManager();
        }
        return self::$instance;
    }

    /**
     * Get a value from the session.
     *
     * @param string $key The key to retrieve.
     * @return mixed|null The value associated with the key, or null if not set.
     */
    public function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Set a value in the session.
     *
     * @param string $key The key to set.
     * @param mixed $value The value to set.
     */
    public function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    /**
     * Unset a value in the session.
     *
     * @param string $key The key to unset.
     */
    public function unset(string $key): void {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy the session.
     */
    public function destroy(): void {
        session_unset();
        session_destroy();
        self::$instance = null;
    }
}
