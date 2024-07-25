<?php

/**
 * Class ServiceRegistry
 *
 * This class implements the Service Registry Design Pattern.
 */
class ServiceRegistry
{
    /**
     * @var ServiceRegistry|null The single instance of the ServiceRegistry.
     */
    private static ?ServiceRegistry $instance = null;

    /**
     * @var array An associative array holding the registered services.
     */
    private array $services = [];

    /**
     * Private constructor to prevent creating a new instance outside of this class.
     */
    private function __construct() {}

    /**
     * Get the single instance of the ServiceRegistry.
     *
     * @return ServiceRegistry The instance of the ServiceRegistry.
     */
    public static function getInstance(): ServiceRegistry
    {
        if (self::$instance === null) {
            self::$instance = new ServiceRegistry();
        }
        return self::$instance;
    }

    /**
     * Register a service with the given key.
     *
     * @param string $key The key to identify the service.
     * @param mixed $service The service to register.
     */
    public function register(string $key, mixed $service): void
    {
        $this->services[$key] = $service;
    }

    /**
     * Get a registered service by key.
     *
     * @param string $key The key identifying the service.
     * @return mixed The registered service.
     * @throws Exception If the service is not found.
     */
    public function get(string $key): mixed
    {
        if (!isset($this->services[$key])) {
            throw new Exception("Service not found: " . $key);
        }
        return $this->services[$key];
    }
}

