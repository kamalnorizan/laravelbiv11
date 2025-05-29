<!doctype html>
<html lang="en">

<head>
    <title>ChartJS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <h1>test page</h1>

        <div class="row">
            <div class="col-md-6">
                <canvas  id="myChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas  id="linechart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas  id="bubbleChart"></canvas>
            </div>
            {{-- <div class="col-md-6">
                <canvas  id="linechart"></canvas>
            </div> --}}
        </div>
        <div class="row mt-5">
            <div class="col-md-3">
                <canvas  id="donut1"></canvas>
            </div>
            <div class="col-md-3">
                <canvas  id="donut2"></canvas>
            </div>
            <div class="col-md-3">
                <canvas  id="donut3"></canvas>
            </div>
            <div class="col-md-3">
                <canvas  id="donut4"></canvas>
            </div>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        const ctx = $('#myChart');
        const linectx = $('#linechart');
        const bubblectx = $('#bubbleChart');
        var data = {
                labels: ['Jan', 'Feb', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: '# of Votes(Male)',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1,
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                },{
                    label: '# of Votes(Female)',
                    data: [10, 5, 8, 9, 11, 7],
                    borderWidth: 1,
                    backgroundColor: 'rgba(0, 255, 0, 0.2)',
                }, {
                    label: '# of Votes(Other)',
                    data: [3, 6, 2, 8, 4, 5],
                    borderWidth: 1,
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                }]
            };
        var chartSaya = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var lineChartSaya = new Chart(linectx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var bubbleChartSaya = new Chart(bubblectx, {
            type: 'bubble',
            data: {
                datasets: [ {
                    label: 'Category A',
                    data: [
                        { x: randomX(), y: randomY(), r: randomY() },
                        { x: randomX(), y: randomY(), r: randomY() },
                        { x: randomX(), y: randomY(), r: randomY() }
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Category B',
                    data: [
                        { x: randomX(), y: randomY(), r: randomY() },
                        { x: randomX(), y: randomY(), r: randomY() },
                        { x: randomX(), y: randomY(), r: randomY() }
                    ],
                    backgroundColor: 'rgb(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1
                },  {
                    label: 'Category C',
                    data: [
                        { x: randomX(), y: randomY(), r: randomY() },
                        { x: randomX(), y: randomY(), r: randomY() },
                        { x: randomX(), y: randomY(), r: randomY() }
                    ],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function randomX() {
            return Math.floor(Math.random() * 70);
        }

        function randomY() {
            return Math.floor(Math.random() * 60);
        }

        function createDonutChart(ctxId, label, data, colors, type){
            const ctx = document.getElementById(ctxId).getContext('2d');
            new Chart(ctx, {
                type: type,
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Votes',
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Donut Chart Example'
                        }
                    }
                }
            });
        }

        createDonutChart('donut1', ['Red', 'Blue', 'Yellow'], [12, 19, 3], ['rgba(255, 99, 132, .8)', 'rgba(54, 162, 235, .8)', 'rgba(255, 206, 86, .8)'], 'doughnut');
        createDonutChart('donut2', ['Green', 'Purple', 'Orange'], [5, 10, 15], ['rgba(75, 192, 192, .8)', 'rgba(153, 102, 255, .8)', 'rgba(255, 159, 64, .8)'], 'doughnut');
        createDonutChart('donut3', ['Pink', 'Cyan', 'Magenta'], [8, 12, 6], ['rgba(255, 99, 132, .8)', 'rgba(54, 162, 235, .8)', 'rgba(255, 206, 86, .8)'], 'pie');
        createDonutChart('donut4', ['Lime', 'Teal', 'Coral'], [7, 14, 9], ['rgba(75, 192, 192, .8)', 'rgba(153, 102, 255, .8)', 'rgba(255, 159, 64, .8)'], 'pie');

    </script>
</body>

</html>
