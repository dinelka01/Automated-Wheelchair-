<?php

// Define your data array
$data = array(
    "name" => "John",
    "age" => 30,
    "city" => "New York"
);


$json_data = json_encode($data);


header('Content-Type: application/json');

// Echo JSON data
echo $json_data;
