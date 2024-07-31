<?php

namespace Filip\Bookstore\Infrastructure\Utility;

use PDO;
use PDOException;

/**
 * Class DatabaseConnection
 *
 * Manages a single instance of the PDO connection using the Singleton pattern.
 */
class DatabaseConnection extends Singleton
{
    private ?PDO $connection = null;

    protected function __construct()
    {
        parent::__construct();
        try {
            $dbHost = $_ENV['DB_HOST'];
            $dbPort = $_ENV['DB_PORT'];
            $dbDatabase = $_ENV['DB_DATABASE'];
            $dbUsername = $_ENV['DB_USERNAME'];
            $dbPassword = $_ENV['DB_PASSWORD'];

            $this->connection = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbDatabase", $dbUsername, $dbPassword);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
