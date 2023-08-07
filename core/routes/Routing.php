<?php

class Routing
{
    private $request;
    private $supportedMethod = ["GET", "POST"];
    public function __construct(IRequest $request)
    {
        $this->request = $request;
    }
    public function __call($name, $args)
    {
        list($route, $method) = $args;
        if (!in_array(strtoupper($name), $this->supportedMethod)) {
            $this->invalidMethod();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, "/");
        if ($result == "") {
            return "/";
        }

        return $result;
    }

    private function invalidMethod()
    {
        exit($this->request->serverProtocol . " 405 Method not allowed");
    }

    private function defaultRequest()
    {
        exit($this->request->serverProtocol . " 404 not found");
    }

    public function callRoute()
    {
        $method = $this->{strtolower($this->request->requestMethod)};
        $route = $this->formatRoute($this->request->requestUri);
        $methodToCall = $method[$route];
        if (is_null($methodToCall)) {
            $this->defaultRequest();
        }

        echo call_user_func_array($methodToCall, array($this->request));
    }

    public function __destruct()
    {
        $this->callRoute();
    }
}
