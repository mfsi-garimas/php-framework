<?php

use app\model\Usermodel;

require_once(dirname(__DIR__, 2) . "/autoload.php");

$db = Usermodel::getInstance();

function selectData($db)
{
    $name = "Harry";
    $email = "darien59@example.com";

    // $result = $db->select()->join('phone', 'phone.user_id=users.id', 'left')->order_by("name ASC", "email ASC")->get();
    $result = $db->select()->order_by("name ASC", "email ASC")->get();
    print_r($result);
}

selectData($db);

function insertData($db)
{
    $data = $db->store();
    $data->update_obj->name = "test";
    $data->update_obj->email = "test@test.com";
    $data->update_obj->email_verified_at = date("Y-m-d h:i:s");
    $data->update_obj->password = "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi";
    $data->update_obj->remember_token = "lq5nyCuLfa";
    $data->update_obj->created_at = "2023-07-10 08:17:34";
    $data->update_obj->updated_at = "2023-07-10 08:17:34";
    $data->save();
}

// insertData($db);

function updateData($db)
{
    $array = [
        "name" => "Harry",
    ];
    $data = $db->find(1);
    $data->update_obj->name = "Harry";
    $data->save();

    // $result = $db->where("name", "Harry Potter")->where("email", "darien59@example.com")->update($array);
    // print_r($result);
}

// updateData($db);

function delete($db)
{
    $result = $db->delete("test5");
    print_r($result);
}
// delete($db);
