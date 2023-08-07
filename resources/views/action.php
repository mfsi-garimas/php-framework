<?php

require_once(__DIR__ . "/validate.php");
if (!empty($_POST)) {
    $validation = validate($_POST, [
        'email' => 'required|email|unique:users',
        'first_name' => 'required|min:2|max:100',
        'last_name' => 'required|min:2|max:100',
        'pwd' => 'required',
    ]);

    print_r($validation);
}
