<?php


require_once('DotEnv.php');
require_once('QueryBuilder.php');

$dotenv = new DotEnv(getcwd() . '/.env');
$dotenv->load();
$conn = new mysqli(getenv('servername'), getenv('username'), getenv('password'), getenv('database'));

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = (new QueryBuilder())->select("name")->from("users");
$result = $conn->query($query);

foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
    echo $row["name"];
}
