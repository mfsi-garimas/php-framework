<?php

require_once('./config/QueryBuilder.php');

class Usermodel
{
    private $table = 'users';
    private $primaryKey = 'id';
    private $db;
    private static $obj;
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!self::$obj)
            self::$obj = new self();
        return self::$obj;
    }

    public function connect()
    {
        $this->db = QueryBuilder::getInstance();
        $this->db->connect();
    }

    public function getdata($name, $email)
    {
        $query = $this->db->select("name,email")->from($this->table)->where("name", $name)->where("email", $email)->order_by("name ASC", "email ASC")->get();
        return $query;
    }

    public function insert($data)
    {
        $query = $this->db->insert($this->table, $data);
        return $query;
    }

    public function update($data, $name, $email)
    {
        $query = $this->db->where("name", $name)->where("email", $email)->update($this->table, $data);
        return $query;
    }

    public function delete($name)
    {
        $query = $this->db->where("name", $name)->delete($this->table);
        return $query;
    }
}
