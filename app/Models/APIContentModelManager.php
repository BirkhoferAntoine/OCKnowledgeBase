<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Security;
use PDO;


class APIContentModelManager extends DatabaseModel
{
    private Security $_security;

    public function __construct(Security $security)
    {
        $this->_security = &$security;
    }

    private function _getContent()
    {
        $security   = &$this    -> _security;
        $get        = $security -> getFilteredGet();

        if ($get)
        {
            $sqlParams  = $security -> prepareSQLParameters($get);
            $sqlValues  = $security -> prepareSQLValues($get);

            $sql = 'SELECT * FROM `Content` WHERE ' . $sqlParams . 'ORDER BY `id`';
            $req = $this->run($sql, $sqlValues);
        }
        else {
            $sql = 'SELECT * FROM `Content` ORDER BY `id`';
            $req = $this->run($sql);
        }

        if (isset($req))
        {
            $req->setFetchMode(PDO::FETCH_OBJ);
            $contentTable = $req->fetchAll();
        }
        else {
            if (env('APP_DEBUG', false)) throw new PDOException('Aucun resultat');
        }

        $req->closeCursor();
        return $contentTable;
    }

    private function _getColumn($column)
    {
        $req = $this->run('SELECT `' . $column . '` FROM `Content`');
        if (isset($req))
        {
            $req->setFetchMode(PDO::FETCH_NAMED);
            $contentTable = $req->fetchAll(PDO::FETCH_COLUMN);
        } else {
            throw_when(false, 'Request failed');
        }
        $req->closeCursor();
        return $contentTable;
    }

    private function _addContent()
    {
        $post = $this->_security->getFilteredPost();

        if (!empty($post['title@api'] && $post['content@api'])) //todo add token check
        {
            $sql = 'INSERT INTO `Content` 
                        (`id`, `user_name`, `title`, `content`, `date`, `image`, `category`, `sub_category`) 
                    VALUES 
                        (NULL, :user_name, :title, :content, NULL, :image, :category, :sub_category)';

            $args = [
                'user_name'     => 'Admin',
                'title'         => $post['title@api'],
                'content'       => $post['content@api'],
                'image'         => $post['image@api'],
                'category'      => $post['category@api'],
                'sub_category'  => $post['sub_category@api']
            ];

            $req = $this->run($sql, $args);
            return $req;
        }
        else {
            return throw_when(false,'empty post data');
        }
    }

    public function getContent()
    {
        /*if ($content['column']) return $this->_getColumn($content['column']);*/
        return $this->_getContent();
    }

    public function addContent()
    {
        return $this->_addContent();
    }
}

