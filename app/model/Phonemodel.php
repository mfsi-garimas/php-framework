<?php

namespace app\model;

use core\QueryBuilder;

require_once(dirname(__DIR__, 2) . "/autoload.php");

class Phonemodel extends QueryBuilder
{
    protected $table = 'phone';
    protected $primaryKey = 'phone_id';
    private static $obj;
    protected $fillable = ['phone', 'user_id'];
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        self::connect();
        if (!self::$obj)
            self::$obj = new self();
        return self::$obj;
    }
}
