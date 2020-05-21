<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Security;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;


class ContentModelManager extends DatabaseModel
{
    public $response;
    private $_security;

    public function __construct(ResponseFactoryInterface $factory, Security $security)
    {
        //$this->response = $factory->createResponse(200, 'Success');
        $this->_security = $security;

    }

    public function __invoke($sql = null, $args = [] || null)
    {
        if (!empty($sql)) {
            $data = $this->getContent($sql, $args);
        } else {
            $data = $this->getContentTable();
        }
        return $data;

        //$this->response->getBody()->write($payload);
        //return $this->response->withHeader('Content-Type', 'application/json');
        // TODO Security

    }

    private function getContentTable()
    {
        $req = $this->run('SELECT * FROM `Content`');
        if (isset($req)) {
            $req->setFetchMode(PDO::FETCH_OBJ);
            $contentTable = $req->fetchAll();
        } else {
            $contentTable = print_r('erreur');
        }
        $req->closeCursor();

        return $contentTable;
    }

    private function getContent($column, $args = [])
    {
        $req = $this->run('SELECT ' . $this->_filter($column) . ' FROM `Content`', $args);
        if (isset($req)) {
            $req->setFetchMode(PDO::FETCH_NAMED);
            $contentTable = $req->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $contentTable = print_r('erreur');
        }
        $req->closeCursor();

        return $contentTable;
    }

    private function _filter($keys)
    {
        $keyArray = explode(',', $keys);

        $allowed = ['id', 'user_name', 'title', 'content', 'date'];

        //$params = [];
        $setStr = "";

        foreach ($keyArray as $key) {
            if (in_array($key, $allowed)) {
                $setStr .= "`" . str_replace("`", "", $key) . "`,";
            }
        }
        return substr($setStr, 0, -1);
    }
}

