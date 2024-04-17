<?php

namespace application\lib;

use PDO;

class Db {

    protected PDO $db;

    public function __construct()
    {
        $config = require 'application/config/db.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['name'], $config['user'], $config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params))
            foreach ($params as $key => $val) {
                if (is_int($val))
                    $type = PDO::PARAM_INT;
                else
                    $type = PDO::PARAM_STR;
                $stmt->bindValue(':' . $key, $val, $type);
            }
        $stmt->execute();
        //$stmt->debugDumpParams(); // Debug mode
        return $stmt;
    }

    public function row($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fullColumn($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function pairColumn($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_KEY_PAIR);
    }

	public function column($sql, $params = [])
    {
		return $this->query($sql, $params)->fetchColumn();
    }

    public function fetchUnique($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_UNIQUE);
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
    
    public function exists($sql, $params = []): bool
    {
        if ($this->query($sql, $params)->rowCount() > 0)
            return true;
        else
            return false;
    }
	
}