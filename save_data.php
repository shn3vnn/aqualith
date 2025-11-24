<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "aqualith";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$intensitas = $_POST['intensitas_cahaya'] ?? null;
$kelembapan = $_POST['kelembapan_tanah'] ?? null;
$ketinggian = $_POST['ketinggian'] ?? null;

if ($intensitas !== null && $kelembapan !== null && $ketinggian !== null) {

    $sql = "INSERT INTO sensor_logs (intensitas_cahaya, kelembapan_tanah, ketinggian)
            VALUES ('$intensitas', '$kelembapan', '$ketinggian')";

    if ($conn->query($sql) === TRUE) {
        echo "DATA_OK";
    } else {
        echo "ERROR_DB";
    }

} else {
    echo "ERROR_PARAM";
}

$conn->close();
?>
