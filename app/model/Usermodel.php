<?php

namespace app\model;

use core\Database;

require_once(dirname(__DIR__, 2) . "/autoload.php");

class Usermodel extends Database
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    private static $obj;
    protected $fillable = ['name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'];
    // private function __construct()
    // {
    // }

    // private function __clone()
    // {
    // }

    // public function __call($method, $args)
    // {
    //     if (method_exists($this, $method)) {
    //         $this->connect();
    //         return call_user_func_array(array($this, $method), $args);
    //     }
    // }

    // public static function getInstance()
    // {
    //     self::connect();
    //     if (!self::$obj)
    //         self::$obj = new self();
    //     return self::$obj;
    // }

    public function phone()
    {
        return $this->hasOne('./app/model/Phonemodel.php');
    }
}
