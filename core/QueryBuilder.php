<?php

namespace core;

require_once(dirname(__DIR__) . "/autoload.php");

class QueryBuilder
{
    private $fields = [];
    protected $table;
    private static $conn;
    private $values = [];
    private $order, $join = [];
    private $conditions = [];
    private $where_val = [];
    private $update_val = [];
    private static $obj_qb;
    protected $fillable;
    protected $primaryKey;
    public $update_obj;
    private $id;

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function connect()
    {
        $dotenv = new DotEnv(dirname(__DIR__) . '/.env');
        $dotenv->load();
        try {
            self::$conn = new \PDO("mysql:host=" . getenv('servername') . ";dbname=" . getenv('database'), getenv('username'), getenv('password'));
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        self::connect();
        if (!static::$obj_qb)
            static::$obj_qb = new static();
        return static::$obj_qb;
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
        $join = '';
        if ($this->join)
            $join = implode(" ", $this->join);
        $fields = "*";
        if ($this->fields)
            $fields = implode(",", $this->fields);

        $query = "SELECT " . $fields . " FROM " . $this->table . $join . $condition . " " . $this->order;
        return $this->response($query, "GET");
    }

    public function find(int $id): object
    {
        $this->id = $id;
        $condition = " WHERE " . $this->primaryKey . "=" . $this->id;
        $query = "SELECT * FROM " . $this->table . $condition;
        return $this->response($query, "FIND");
    }

    public function store()
    {
        $this->update_obj = new \stdClass;
        foreach ($this->fillable as $key => $value) {
            $this->update_obj->$value = '';
        }
        return $this;
    }

    public function join(string $join, string $condition, string $join_type = 'INNER'): self
    {
        $type = '';

        if ($join_type == 'left') {
            $type = ' LEFT JOIN ';
        } else if ($join_type == 'right') {
            $type = ' RIGHT JOIN ';
        } else {
            $type = ' JOIN ';
        }
        array_push($this->join, $type . $join . " ON " . $condition);
        return $this;
    }

    public function save()
    {
        $up = [];
        foreach ($this->update_obj as $key => $val) {
            array_push($up, $key . "= '" . $val . "'");
        }

        if (!empty($this->id)) {
            $condition = " WHERE " . $this->primaryKey . "=" . $this->id;
            $query = "UPDATE " . $this->table . " SET " . implode(",", $up) . $condition;
        } else {
            $query = "INSERT INTO " . $this->table . " (" . implode(",", array_keys((array)$this->update_obj)) . ") VALUES ('" . implode("' , '", array_values((array)$this->update_obj)) . "')";
        }
        return $this->response($query, "UPDATE");
    }

    public function response($query, $type)
    {
        try {
            $pdoStatement = self::$conn->prepare($query);
            if (!empty($this->where_val) && empty($this->update_val)) {

                // $pdoStatement->bindParam($key, $value, PDO::PARAM_STR);
                $pdoStatement->execute($this->where_val);
            } else if (!empty($this->where_val) && !empty($this->update_val)) {
                $merge = array_merge($this->where_val, $this->update_val);
                $pdoStatement->execute($merge);
            } else if (empty($this->where_val) && !empty($this->update_val)) {
                $pdoStatement->execute($this->update_val);
            } else
                $pdoStatement->execute();

            if ($type == "GET")
                return $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
            else if ($type == "FIND") {
                $this->update_obj = $pdoStatement->fetchObject();
                return $this;
            } else if ($type == "INSERT")
                return "New record created successfully";
            else if ($type == "UPDATE")
                return $pdoStatement->rowCount() . " records UPDATED successfully";
            else if ($type == "DELETE")
                return "Record deleted successfully";
            else
                return "Invalid ";
        } catch (\PDOException $e) {
            die("ERROR:" . $e->getMessage());
        }
    }

    public function insert(array $values): string
    {
        $this->values = $values;
        $query = "INSERT INTO " . $this->table . " (" . implode(",", array_keys($this->values)) . ") VALUES ('" . implode("' , '", array_values($this->values)) . "')";
        return $this->response($query, "INSERT");
    }

    public function update(array $values): string
    {
        $this->values = $values;
        $arr_val = array_values($this->values);
        $arr_key = array_keys($this->values);
        $res = array_map(function ($val, $key) {
            // $val = "'" . $val . "'";
            return $key . "= :val_" . $key;
        }, $arr_val, $arr_key);
        foreach ($values as $key => $val) {
            $this->update_val["val_" . $key] = $val;
        }

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

    public function hasOne($model)
    {
    }
}
