<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aqualith Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Aqualith Monitoring Dashboard</h1>

<div class="container">

    <div class="card">
        <h2>Intensitas Cahaya</h2>
        <canvas id="lightChart"></canvas>
    </div>

    <div class="card">
        <h2>Kelembapan Tanah</h2>
        <canvas id="soilChart"></canvas>
    </div>

    <div class="card">
        <h2>Ketinggian</h2>
        <canvas id="heightChart"></canvas>
    </div>

    <!-- ======== CARD AI GEMINI (TIDAK DIUBAH, HANYA DIPERAPIKAN SEDIKIT) ======== -->
    <div class="card" style="width: 100%; text-align: center;">
        <h2>AI Gemini: Prediksi & Rekomendasi</h2>
        <p id="ai-status" style="font-size: 22px; font-weight: bold;">Memuat prediksi...</p>
        <p id="ai-rekom" style="font-size: 18px;">Menunggu respons AI...</p>
    </div>

</div>

<script>
function loadData() {
    fetch("get_data.php")
        .then(response => response.json())
        .then(data => {
            let labels = data.map(item => item.created_at).reverse();
            let light = data.map(item => item.intensitas_cahaya).reverse();
            let soil = data.map(item => item.kelembapan_tanah).reverse();
            let height = data.map(item => item.ketinggian).reverse();

            new Chart(document.getElementById("lightChart"), {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Cahaya",
                        data: light,
                        borderWidth: 2
                    }]
                }
            });

            new Chart(document.getElementById("soilChart"), {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Kelembapan",
                        data: soil,
                        borderWidth: 2
                    }]
                }
            });

            new Chart(document.getElementById("heightChart"), {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Ketinggian",
                        data: height,
                        borderWidth: 2
                    }]
                }
            });
        });
}

loadData();
setInterval(loadData, 5000);

// ================================================
//            GEMINI AI PREDIKSI
// ================================================
function loadGemini() {
    fetch("ai_gemini.php")
        .then(response => response.json())
        .then(ai => {
            document.getElementById("ai-status").innerText = "Status: " + ai.prediksi;
            document.getElementById("ai-rekom").innerText = "Rekomendasi: " + ai.rekomendasi;

            if (ai.prediksi === "Butuh Air") {
                document.getElementById("ai-status").style.color = "#ff4d4d";
            } else {
                document.getElementById("ai-status").style.color = "#4dff4d";
            }
        })
        .catch(err => {
            document.getElementById("ai-status").innerText = "AI Error: " + err;
            document.getElementById("ai-status").style.color = "red";
        });
}

loadGemini();
setInterval(loadGemini, 25000);

</script>

</body>
</html>
