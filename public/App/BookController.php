<?php

$autoloadPath = dirname(__DIR__).'/../vendor/autoload.php';
$databasePath = dirname(__DIR__).'/App/DatabaseConnection.php';

try {
    if (file_exists($autoloadPath)) {
        require $autoloadPath;
    } else {
        throw new Exception("O arquivo autoload.php não existe no caminho especificado: $autoloadPath\n");
    }

    if (file_exists($databasePath)) {
        require $databasePath;
    } else {
        throw new Exception("O arquivo DatabaseConnection.php não existe no caminho especificado: $databasePath\n");
    }
} catch (Exception $e) {
    echo '<pre>';
    print_r('Exceção capturada: '.$e->getMessage());
    echo '</pre>';
    exit;
}

class BookController
{
    private static $instance;
    private $db;

    private function __construct()
    {
        $this->db = \App\DatabaseConnection::getInstance();
        try {
        } catch (Exception $e) {
            echo '<pre>';
            print_r('Exceção capturada ao obter a instância: '.$e->getMessage());
            echo '</pre>';
            exit;
        }

        try {
            $this->db->connect();
        } catch (Exception $e) {
            echo '<pre>';
            print_r('Exceção capturada ao conectar: '.$e->getMessage());
            echo '</pre>';
            exit;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new BookController();
        }

        return self::$instance;
    }

    public function getBooks()
    {
        try {
            $result = $this->db->query('SELECT * FROM books');

            return $result;
        } catch (Exception $e) {
            echo '<pre>';
            print_r('Exceção capturada: '.$e->getMessage());
            echo '</pre>';
            exit;
        }
    }
}
