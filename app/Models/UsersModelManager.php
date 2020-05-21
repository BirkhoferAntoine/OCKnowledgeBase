<?php


namespace App\Models;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;


class UsersModelManager extends DatabaseModel
{
    public $response;

    public function __construct(ResponseFactoryInterface $factory)
    {
        $this->response = $factory->createResponse(200, 'Success');
    }

    public function __invoke()
    {
        // TODO Security
        return $this->getUsersTable();
        //return $this->response;
    }

    protected function getUsersTable()
    {
        $req = $this->run('SELECT * FROM `Users`');
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