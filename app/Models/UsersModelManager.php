<?php


namespace App\Models;

use App\Support\Security;
use PDO;


class UsersModelManager extends DatabaseModel
{
    private $_security;

    public function __construct(Security $security)
    {
        $this->_security = $security;
    }

    public function __invoke()
    {
        return $this->getUsersTable();
    }

    private function getUsersTable()
    {
        $sql = 'SELECT * FROM `users` WHERE `users`.`password` = :password';
        $req = $this->run('SELECT * FROM `users` WHERE `users`.`password` = :password');
        if (isset($req))
        {
            $req->setFetchMode(PDO::FETCH_OBJ);
            $usersTable = $req->fetchAll();
        } else {
            $usersTable = print_r('erreur');
        }
        $req->closeCursor();

        return $usersTable;
    }
}
/*
session_name
HTTP_USER_AGENT
session_regenerate_id
session_destroy*/