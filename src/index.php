<?php

require_once('./model/Usermodel.php');

$db = Usermodel::getInstance();
$db->connect();

function selectData($db)
{
    $name = "Harry Parker";
    $email = "darien59@example.com";
    $result = $db->getdata($name, $email);
    print_r($result);
}

// selectData($db);

function insertData($db)
{
    $array = [
        "name" => "test5",
        "email" => "test5@test.com",
        "email_verified_at" => date("Y-m-d h:i:s"),
        "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
        "remember_token" => "lq5nyCuLfa",
        "created_at" => "2023-07-10 08:17:34",
        "updated_at" => "2023-07-10 08:17:34"
    ];
    $result = $db->insert($array);
    print_r($result);
}

// insertData($db);

function updateData($db)
{
    $array = [
        "name" => "Harry",
    ];

    $result = $db->update($array, "Harry Parker", "darien59@example.com");
    print_r($result);
}

// updateData($db);

function delete($db)
{
    $result = $db->delete("test5");
    print_r($result);
}
delete($db);
