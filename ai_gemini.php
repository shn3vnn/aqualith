<?php
header("Content-Type: application/json");
include "config.php";

$sql = "SELECT * FROM sensor_logs ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$cahaya  = $data['intensitas_cahaya'];
$soil    = $data['kelembapan_tanah'];
$height  = $data['ketinggian'];

$api_key = "AIzaSyDguRZFh7-8e-CsFH5AhTWgodlU5ZTkzn0";

$model = "gemini-2.0-flash";
$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$api_key";

$payload = [
    "contents" => [[
        "parts" => [[
            "text" => "
Analisis data berikut:

- Intensitas cahaya: $cahaya
- Kelembapan tanah: $soil
- Ketinggian air: $height

HASILKAN JSON MURNI seperti:
{
    \"prediksi\": \"Butuh Air\",
    \"rekomendasi\": \"Saran...\"
}

JANGAN gunakan markdown, JANGAN gunakan backtick, JANGAN gunakan ```json.
"
        ]]
    ]]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

$text = $result["candidates"][0]["content"]["parts"][0]["text"] ?? null;

if (!$text) {
    echo json_encode([
        "prediksi" => "ERROR",
        "rekomendasi" => $response
    ]);
    exit;
}

// Hapus blok markdown jika masih ada
$clean = preg_replace('/```json|```/', '', $text);
$clean = trim($clean);

echo $clean;
?>
