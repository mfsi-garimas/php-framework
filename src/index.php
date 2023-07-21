<?php

require_once('QueryBuilder.php');

$db = QueryBuilder::getInstance();
$db->connect();

function selectData($db)
{
    $query_select = $db->select("name,email")->from("users")->where("name", "'; DELETE FROM users; /*")->where("email", "darien59@example.com")->order_by("name ASC", "email ASC")->get();
    print_r($query_select);
}

selectData($db);

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
    $query_insert = $db->insert("users", $array);
    print_r($query_insert);
}

// insertData($db);

function updateData($db,)
{
    $array = [
        "name" => "Harry",
    ];

    $query_update = $db->where("name", "Harry Parker")->where("email", "darien59@example.com")->update("users", $array);
    print_r($query_update);
}

// updateData($db);

function delete($db)
{
    $query = $db->where("name", "test2")->delete("users");
    print_r($query);
}
// delete($db);
