<?php

class QueryBuilder
{
    private $fields = [];
    private $conditions = [];
    private $table;
    public function __toString(): string
    {
        $where_dt = $this->conditions == [] ? "" : " WHERE " . implode(" AND ", $this->conditions);
        return "SELECT " . implode(",", $this->fields) . " FROM " . $this->table . $where_dt;
    }
    public function select(string ...$select): self
    {
        $this->fields = $select;
        return $this;
    }

    public function where(string ...$where): self
    {
        $this->conditions = $where;
        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }
}
