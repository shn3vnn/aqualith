<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli("localhost", "root", "", "aqualith");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "msg" => $conn->connect_error]));
}

$intensitas = $_POST['intensitas'] ?? null;
$kelembapan = $_POST['kelembapan'] ?? null;
$ketinggian = $_POST['ketinggian'] ?? null;

$sql = "INSERT INTO sensor_logs (intensitas_cahaya, kelembapan_tanah, ketinggian) 
        VALUES ('$intensitas', '$kelembapan', '$ketinggian')";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "msg" => $conn->error]);
}
?>
