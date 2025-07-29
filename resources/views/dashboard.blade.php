<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandwidth Usage Analyzer 🚀</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1, h2 {
            text-align: center;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        p {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            width: 80%;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        canvas {
            margin-top: 20px;
            max-width: 90%;
            border: 1px solid #ccc;
            border-radius: 5px;
            /* height: 100px; */
        }
    </style>
</head>
<body>
    <h1>Bandwidth Usage Analyzer 🚀</h1>

    <!-- Speed Test -->
    <h2>Internet Speed Test</h2>
    <button onclick="runSpeedTest()">Run Test</button>
    <p id="speedTestResult">Speed test results will appear here...</p>

    <!-- Traffic Stats -->
    <h2>Real-Time Traffic Stats</h2>
    <button onclick="getTrafficStats()">Get Traffic Stats</button>
    <p id="trafficStats">Traffic stats will appear here...</p>

    <!-- Traffic Chart -->
    <canvas id="trafficChart"></canvas>

    {{-- <script>
        // Initialize the chart
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    { label: 'Download Speed (Mbps)', data: [], borderColor: 'green', fill: false },
                    { label: 'Upload Speed (Mbps)', data: [], borderColor: 'blue', fill: false },
                    { label: 'Ping (ms)', data: [], borderColor: 'red', fill: false },
                    { label: 'Incoming Traffic (bytes)', data: [], borderColor: 'purple', fill: false },
                    { label: 'Outgoing Traffic (bytes)', data: [], borderColor: 'orange', fill: false }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Run internet speed test
        function runSpeedTest() {
            fetch('/speed-test')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('speedTestResult').innerText =
                        `Download: ${data.download} Mbps, Upload: ${data.upload} Mbps, Ping: ${data.ping} ms`;

                    // Add speed test results to chart
                    const now = new Date().toLocaleTimeString();
                    trafficChart.data.labels.push(now);
                    trafficChart.data.datasets[0].data.push(data.download);
                    trafficChart.data.datasets[1].data.push(data.upload);
                    trafficChart.data.datasets[2].data.push(data.ping);
                    trafficChart.update();
                })
                .catch(error => {
                    console.error('Error running speed test:', error);
                    alert('Failed to run speed test. Check server connection.');
                });
        }

        // Fetch traffic stats
        function getTrafficStats() {
            fetch('/traffic-stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('trafficStats').innerText =
                        `Incoming: ${data.incoming} bytes, Outgoing: ${data.outgoing} bytes`;

                    // Add traffic stats to chart
                    const now = new Date().toLocaleTimeString();
                    trafficChart.data.labels.push(now);
                    trafficChart.data.datasets[3].data.push(data.incoming);
                    trafficChart.data.datasets[4].data.push(data.outgoing);
                    trafficChart.update();
                })
                .catch(error => {
                    console.error('Error fetching traffic stats:', error);
                    alert('Failed to fetch traffic stats. Check server connection.');
                });
        }
    </script> --}}

    <script>
        // Auto-run speed test every 30 seconds
        function runSpeedTest() {
            fetch('/speed-test')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('speedTestResult').innerText =
                        `Download: ${data.download} Mbps, Upload: ${data.upload} Mbps, Ping: ${data.ping} ms`;
                    updateChart(data.download, data.upload, data.ping, null, null);
                });
        }

        // Auto-fetch traffic stats every 5 seconds
        function getTrafficStats() {
            fetch('/traffic-stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('trafficStats').innerText =
                        `Incoming: ${data.incoming} bytes, Outgoing: ${data.outgoing} bytes`;
                    updateChart(null, null, null, data.incoming, data.outgoing);
                });
        }

        // Auto-run on load and set intervals
        window.onload = function () {
            runSpeedTest();
            getTrafficStats();

            setInterval(runSpeedTest, 1000);      // Run speed test every 30 seconds
            setInterval(getTrafficStats, 1000);    // Get traffic stats every 5 seconds
        };

        // Chart.js setup
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    { label: 'Download Speed (Mbps)', data: [], borderColor: 'green' },
                    { label: 'Upload Speed (Mbps)', data: [], borderColor: 'blue' },
                    { label: 'Ping (ms)', data: [], borderColor: 'red' },
                    { label: 'Incoming Traffic (bytes)', data: [], borderColor: 'purple' },
                    { label: 'Outgoing Traffic (bytes)', data: [], borderColor: 'orange' }
                ]
            },
            options: { responsive: true }
        });

        // Update chart with new data
        function updateChart(download, upload, ping, incoming, outgoing) {
            const now = new Date().toLocaleTimeString();
            trafficChart.data.labels.push(now);

            if (download !== null) trafficChart.data.datasets[0].data.push(download);
            if (upload !== null) trafficChart.data.datasets[1].data.push(upload);
            if (ping !== null) trafficChart.data.datasets[2].data.push(ping);
            if (incoming !== null) trafficChart.data.datasets[3].data.push(incoming);
            if (outgoing !== null) trafficChart.data.datasets[4].data.push(outgoing);

            trafficChart.update();
        }
    </script>

</body>
</html>
