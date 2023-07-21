<?php
require_once('./config/DotEnv.php');

class QueryBuilder
{
    private $fields = [];
    private $table, $conn, $query;
    private $values = [];
    private $order = [];
    private $conditions = [];
    private $where_val = [];
    private static $obj;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function connect()
    {
        $dotenv = new DotEnv(getcwd() . '/.env');
        $dotenv->load();
        try {
            $this->conn = new PDO("mysql:host=" . getenv('servername') . ";dbname=" . getenv('database'), getenv('username'), getenv('password'));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$obj)
            self::$obj = new self();
        return self::$obj;
    }

    public function select(string ...$select): self
    {
        $this->fields = $select;
        return $this;
    }

    public function where(string $key, string $value): self
    {
        $val = $key . "= :" . $key;
        array_push($this->conditions, $val);
        $this->where_val[$key] = $value;
        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function get(): array
    {
        $condition = '';
        if ($this->conditions)
            $condition = " WHERE " . implode(" AND ", $this->conditions);
        $query = "SELECT " . implode(",", $this->fields) . " FROM " . $this->table . $condition . " " . $this->order;
        return $this->response($query, "GET");
    }

    public function response($query, $type)
    {
        try {
            $pdoStatement = $this->conn->prepare($query);
            if (!empty($this->where_val)) {

                // $pdoStatement->bindParam($key, $value, PDO::PARAM_STR);
                $pdoStatement->execute($this->where_val);
            } else
                $pdoStatement->execute();

            if ($type == "GET")
                return $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
            else if ($type == "INSERT")
                return "New record created successfully";
            else if ($type == "UPDATE")
                return $pdoStatement->rowCount() . " records UPDATED successfully";
            else if ($type == "DELETE")
                return "Record deleted successfully";
            else
                return "Invalid ";
        } catch (PDOException $e) {
            die("ERROR:" . $e->getMessage());
        }
    }

    public function insert(string $table, array $values): string
    {
        $this->table = $table;
        $this->values = $values;
        $query = "INSERT INTO " . $this->table . " (" . implode(",", array_keys($this->values)) . ") VALUES ('" . implode("' , '", array_values($this->values)) . "')";
        return $this->response($query, "INSERT");
    }

    public function update(string $table, array $values): string
    {
        $this->table = $table;
        $this->values = $values;
        $arr_val = array_values($this->values);
        $arr_key = array_keys($this->values);
        $res = array_map(function ($val, $key) {
            $val = "'" . $val . "'";
            return $key . "=" . $val;
        }, $arr_val, $arr_key);

        if ($this->conditions)
            $condition = " WHERE " . implode(" AND ", $this->conditions);
        $query = "UPDATE " . $this->table . " SET " . implode(",", $res) . $condition;
        return $this->response($query, "UPDATE");
    }

    public function order_by(string ...$order): self
    {
        $this->order = "ORDER BY " . implode(",", $order);
        return $this;
    }

    public function delete(string $table): string
    {
        $this->table = $table;
        if ($this->conditions)
            $condition = " WHERE " . implode(" AND ", $this->conditions);
        $query = "DELETE FROM " . $this->table . $condition;
        return $this->response($query, "DELETE");
    }
}
