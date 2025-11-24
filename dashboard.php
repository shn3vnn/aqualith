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

            // Cahaya
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

            // Kelembapan
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

            // Ketinggian
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
setInterval(loadData, 5000); // update setiap 5 detik
</script>

</body>
</html>
