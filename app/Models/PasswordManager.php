<?php

namespace App\Models;

// Classe gestion des mots de passe
abstract class PasswordManager extends DatabaseModel
{
    private const SALT_BYTES = 32;
    private const ALGORITHM = 'sha3-512';
    private const ITERATIONS = 10000;

    /**
     * Génère un salt "aléatoire"
     *
     * @return string
     * @throws Exception
     */
    private function _salter() {
        try {
            return bin2hex(random_bytes(self::SALT_BYTES));
        } catch (PDOException $e) {
            echo 'Erreur!: ' . $e->getMessage() . '<br/>';
            die();
            // TODO PSR7 ERROR HANDLER;
        }
    }

    /**
     * Construit le mot de passe et utilise les arguments de l'utilisateur et de la BDD si c'est une connexion
     *
     * @param $password
     * @param $salt
     * @param $iterations
     * @return array
     * @throws Exception
     */
    protected function passwordBuilder($password, $salt, $iterations) {

        $hashSalt = $salt ?? $this->_salter();
        $hashIteration = $iterations ?? self::ITERATIONS;
        $hashPassword = hash(self::ALGORITHM, $password, false);
        $finalPassword = hash_pbkdf2(self::ALGORITHM, $hashPassword, $hashSalt, $hashIteration);

        return array('iteration' => $hashIteration, 'salt' => $hashSalt, 'password' => $finalPassword);
    }
}