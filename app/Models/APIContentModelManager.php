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

    private function _get()
    {
        $security   = &$this    -> _security;
        $get        = $security -> getFilteredGet();

        if ($get)
        {
            if ($get['categories'] === 'true')
            {
                $sql = 'SELECT * FROM `categories` ORDER BY `id`';
                $req = $this->run($sql);
            }
            else {
            $sqlParams  = $security -> prepareSQLParameters($get);
            $sqlValues  = $security -> prepareSQLValues($get);

            $sql = 'SELECT * FROM `content` WHERE ' . $sqlParams . 'ORDER BY `id`';
            $req = $this->run($sql, $sqlValues);
            }
        }
        else {
            $sql = 'SELECT * FROM `content` ORDER BY `id`';
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

    private function _add($params)
    {
        $security           = &$this    -> _security;
        $post               = $security -> getFilteredParams($params);
        $post['user_name']  = 'Admin';

        if (!empty($post['title'] && $post['content'])) //todo add token check
        {
            $sql = "INSERT INTO `content` 
                        (`id`, `user_name`, `title`, `content`, `date`, `image`, `category`, `sub_category`) 
                    VALUES 
                        (NULL, :user_name , :title , :content , NOW() , :image , :category , :sub_category)";


            return $this->run($sql, $post);
        }
        else {
            throw new Exception('Erreur, requête incorrecte');
        }
    }

    private function _update($params)
    {
        $security           = &$this    -> _security;
        $put                = $security -> getFilteredParams($params);
        $put['user_name']   = 'Admin';

        if ($put['id']) {
            $sql = "UPDATE `content` SET
				`user_name` 	= :user_name,
				`title`         = :title,
                `content`       = :content,
                `date`          = NOW(),
                `image`         = :image, 
                `category`      = :category, 
                `sub_category`  = :sub_category
			    WHERE 
			    `content`.`id`  = :id";

            return $this->run($sql, $put);
        }
    }

    private function _delete()
    {
        $security               = &$this    -> _security;
        $delete                 = $security -> getFilteredGet();

        if ($delete['category'])
        {
            $sql = "DELETE FROM `category` WHERE `category`.`id` = :id";
            return $this->run($sql, [':id' => $delete['category']]);
        }
        if ($delete['content'])
        {
            $sql = "DELETE FROM `content` WHERE `content`.`id` = :id";
            return $this->run($sql, [':id' => $delete['content']]);
        }
    }

    public function get()
    {
        /*if ($content['column']) return $this->_getColumn($content['column']);*/
        return $this->_get();
    }

    public function add($params)
    {
        return $this->_add($params);
    }

    public function update($params) {
        return $this->_update($params);
    }

    public function delete()
    {
        return $this->_delete();
    }
}


