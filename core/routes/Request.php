<?php

require_once dirname(__DIR__) . '/interface/IRequest.php';
class Request implements IRequest
{
    public function __construct()
    {
        $this->bootstrapSelf();
    }
    public function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    public function toCamelCase($key)
    {
        $arr = explode("_", strtolower($key));
        $camelCase = $arr[0];
        for ($i = 1; $i < count($arr); $i++) {
            $camelCase .= ucwords($arr[$i]);
        }

        return $camelCase;
    }

    public function getBody()
    {
        if ($this->requestMethod == 'GET')
            return;
        else if ($this->requestMethod == 'POST') {
            $body = [];
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
