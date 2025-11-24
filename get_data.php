<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "aqualith";

$conn = new mysqli($host, $user, $pass, $db);

$sql = "SELECT intensitas_cahaya, kelembapan_tanah, ketinggian, created_at 
        FROM sensor_logs ORDER BY id DESC LIMIT 50";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
