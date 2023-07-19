<?php

class DotEnv
{
    protected $path;
    public function __construct(string $path)
    {
        if (!file_exists($path))
            throw new InvalidArgumentException($path . ' does not exist');
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path))
            throw new InvalidArgumentException($this->path . 'is not readable');

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = explode("=", $line, 2);
            $key = $data[0];
            $value = $data[1];
            if (!array_key_exists($key, $_ENV)) {
                putenv($key . "=" . $value);
                $_ENV[$key] = $value;
            }
        }
    }
}
