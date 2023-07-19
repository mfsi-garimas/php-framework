<?php


require_once('DotEnv.php');
require_once('QueryBuilder.php');

$dotenv = new DotEnv(getcwd() . '/.env');
$dotenv->load();

try {
    $conn = new PDO("mysql:host=" . getenv('servername') . ";dbname=" . getenv('database'), getenv('username'), getenv('password'));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$db = new QueryBuilder();

// $query = $db->select("name")->from("users")->get();
// $result = $conn->query($query);

// $array = [
//     "name" => "test",
//     "email" => "test@test.com",
//     "email_verified_at" => date("Y-m-d h:i:s"),
//     "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
//     "remember_token" => "lq5nyCuLfa",
//     "created_at" => "2023-07-10 08:17:34",
//     "updated_at" => "2023-07-10 08:17:34"
// ];

// $query = $db->insert("users", $array);
// $result = $conn->query($query);

// foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
//     echo $row["name"];
// }

$array = [
    "name" => "test2",
    "email" => "test2@test.com",
];

$query = $db->where("name=:name", "email=:email")->update("users", $array);
$pdoStatement = $conn->prepare($query);
$pdoStatement->execute(
    [
        'name' => 'test',
        'email' => 'test@test.com'
    ]
);
