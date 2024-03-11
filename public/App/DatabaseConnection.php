<?php

namespace App;

use Dotenv\Dotenv;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private ?string $dsn = null;
    private ?string $username = null;
    private ?string $password = null;
    private array $options = [];
    private ?\PDO $pdo = null;

    private function __construct()
    {
        $this->loadEnv();
        $this->connect();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    private function loadEnv(): void
    {
        try {
            $envPath = __DIR__.'/../../.env';

            if (file_exists($envPath)) {
                $dotenv = Dotenv::createImmutable(dirname($envPath));
                $dotenv->load();
            } else {
                echo "O arquivo .env não existe no caminho especificado: $envPath\n";
            }

            $dotenv->load();

            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $database = $_ENV['DB_DATABASE'];
            $this->username = $_ENV['DB_USERNAME'];
            $this->password = $_ENV['DB_PASSWORD'];

            $this->dsn = "mysql:host={$host};port={$port};dbname={$database}";
            $this->options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => true,
            ];
        } catch (\Exception $e) {
            error_log('Exceção capturada durante a carga do ambiente: '.$e->getMessage());
            throw new \Exception('Erro ao carregar o ambiente', 0, $e);
        }
    }

    public function connect(): void
    {
        try {
            $this->pdo = new \PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (\PDOException $e) {
            error_log('Connection failed: '.$e->getMessage());
            throw new \PDOException('Erro ao conectar ao banco de dados', 0, $e);
        }
    }

    public function query(string $sql): ?\PDOStatement
    {
        if ($this->pdo === null) {
            throw new \Exception('Connection failed: No PDO instance available');
        }

        try {
            return $this->pdo->query($sql);
        } catch (\PDOException $e) {
            error_log('Exceção capturada durante a execução da consulta SQL: '.$e->getMessage());
            throw new \Exception('Erro ao executar a consulta SQL', 0, $e);
        }
    }
}
