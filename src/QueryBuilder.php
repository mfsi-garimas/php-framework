<?php

class QueryBuilder
{
    private $fields = [];
    private $conditions = [];
    private $table;
    private $values = [];

    public function select(string ...$select): self
    {
        $this->fields = $select;
        return $this;
    }

    public function where(string ...$where): self
    {
        $this->conditions = empty($where) ? "" : " WHERE " . implode(" AND ", $where);
        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function get(): string
    {
        return "SELECT " . implode(",", $this->fields) . " FROM " . $this->table . $this->conditions;
    }

    public function insert(string $table, array $values): string
    {
        $this->table = $table;
        $this->values = $values;
        return "INSERT INTO " . $this->table . " (" . implode(",", array_keys($this->values)) . ") VALUES ('" . implode("' , '", array_values($this->values)) . "')";
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
        return "UPDATE " . $this->table . " SET " . implode(",", $res) . $this->conditions;
    }
}
