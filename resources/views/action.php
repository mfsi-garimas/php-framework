<?php

require_once("./validate.php");
if (!empty($_POST)) {
    $validation = validate($_POST, [
        'email' => 'required|email',
        'first_name' => 'required|min:2|max:100',
        'last_name' => 'required|min:2|max:100',
        'pwd' => 'required',
    ]);

    print_r($validation);
}
