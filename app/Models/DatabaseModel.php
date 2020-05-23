<?php

declare(strict_types=1);
namespace App\Models;

// Utilisation de la classe de gestion des mots de passe
use App\Models\PasswordManager;
use PDO;
use PDOException;

// Classe abstraite car sert de point d'accès pour la BDD des utilisateurs
abstract class DatabaseModel
{
    // Variable contenant la base de données
    private static $_dbConnection;

    // Connection à la BDD suivant les directives du server
    /**
     *
     */
    private static function setDbConnection()
    {
        try {
            self::$_dbConnection = new PDO(
                'mysql:host=' . env('DB_HOST', '127.0.0.1') . '; dbname=' . env('DB_NAME', 'dbs372914') . '; charset=' .
                CHARSET . ';',
                env('DB_USERNAME', 'root'), env('DB_PASSWORD', ''),
                DBOPTIONS);
        }
            catch (PDOException $e)
        {
            if (env('APP_DEBUG', false)) throw new PDOException($e);
        }
    }

    // Vérifie si la connection est établie, se connecte si null et renvoie le resultat
    /**
     * @return mixed
     */
    protected function getDbConnection()
    {
        if (self::$_dbConnection === null)
        {
            self::setDbConnection();
        }
        return self::$_dbConnection;
    }

    protected function filter($key) { // TODO Implement https://phpdelusions.net/pdo/pdo_wrapper#dependency_injection

        $setStr = "";
        {
            if ($key !== 'id')
            {
                $setStr .= "`" . str_replace("`", "``", $key) . "`";
            }
        }
        $setStr = rtrim($setStr, ",");
        return $setStr;
    }

    protected function run($sql, $args = [])
    {
        try {
            if (!$args)
            {
                return $this->getDbConnection()->query($sql);
            }
            $stmt = $this->getDbConnection()->prepare($sql);
            $stmt->execute($args);

            return $stmt;
        } catch (PDOException $e) {
            if (env('APP_DEBUG', false))
                return array('response' => false, 'sql' => $sql, 'args' => $args, 'error' => $e->getMessage());
        }
    }

    protected function transaction($sql, $args = []) {
        $stmt = $this->getDbConnection()->prepare($sql);
        try {
            $this->getDbConnection()->beginTransaction();
            foreach ($args as $row)
            {
                $stmt->execute($row);
            }
            $this->getDbConnection()->commit();
        }catch (Exception $e){
            $this->getDbConnection()->rollback();
            throw $e;
        }
    }
/**/
}