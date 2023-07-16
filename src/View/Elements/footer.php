<?php

use Core\Database\ConnectionManager;

$connectionManager = new ConnectionManager();

$year = date('Y');

$sql = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query = $connectionManager->getConnection()->prepare($sql);

$query->execute(['01', $year]);

$result = $query->fetch(\PDO::FETCH_ASSOC);

$jan[] = (int)$result['sum'];


$sql1 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query1 = $connectionManager->getConnection()->prepare($sql1);

$query1->execute(['02', $year]);

$result1 = $query1->fetch(\PDO::FETCH_ASSOC);

$fev[] = (int)$result1['sum'];


$sql2 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query2 = $connectionManager->getConnection()->prepare($sql2);

$query2->execute(['03', $year]);

$result2 = $query2->fetch(\PDO::FETCH_ASSOC);

$mar[] = (int)$result2['sum'];


$sql3 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query3 = $connectionManager->getConnection()->prepare($sql3);

$query3->execute(['04', $year]);

$result3 = $query3->fetch(\PDO::FETCH_ASSOC);

$avr[] = (int)$result3['sum'];


$sql4 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query4 = $connectionManager->getConnection()->prepare($sql4);

$query4->execute(['05', $year]);

$result4 = $query4->fetch(\PDO::FETCH_ASSOC);

$may[] = (int)$result4['sum'];


$sql5 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query5 = $connectionManager->getConnection()->prepare($sql5);

$query5->execute(['06', $year]);

$result5 = $query5->fetch(\PDO::FETCH_ASSOC);

$jun[] = (int)$result5['sum'];


$sql6 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query6 = $connectionManager->getConnection()->prepare($sql6);

$query6->execute(['07', $year]);

$result6 = $query6->fetch(\PDO::FETCH_ASSOC);

$jul[] = (int)$result6['sum'];


$sql7 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query7 = $connectionManager->getConnection()->prepare($sql7);

$query7->execute(['08', $year]);

$result7 = $query7->fetch(\PDO::FETCH_ASSOC);

$aou[] = (int)$result7['sum'];


$sql8 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query8 = $connectionManager->getConnection()->prepare($sql8);

$query8->execute(['09', $year]);

$result8 = $query8->fetch(\PDO::FETCH_ASSOC);

$sep[] = (int)$result8['sum'];


$sql9 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query9 = $connectionManager->getConnection()->prepare($sql9);

$query9->execute(['10', $year]);

$result9 = $query9->fetch(\PDO::FETCH_ASSOC);

$oct[] = (int)$result9['sum'];


$sql10 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query10 = $connectionManager->getConnection()->prepare($sql10);

$query10->execute(['11', $year]);

$result10 = $query10->fetch(\PDO::FETCH_ASSOC);

$nov[] = (int)$result10['sum'];


$sql11 = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

$query11 = $connectionManager->getConnection()->prepare($sql11);

$query11->execute(['12', $year]);

$result11 = $query11->fetch(\PDO::FETCH_ASSOC);

$dec[] = (int)$result11['sum'];

$chart =  [$jan , $fev , $mar , $avr , $may , $jun , $jul , $aou , $sep , $oct , $nov , $dec];

?>

<!-- ========== footer start =========== -->
<footer class="footer">
    <div class="container-fluid">
        <hr>
        <div class="row" style="justify-content: center;">
            <div class="col-md-6 order-last order-md-first">
                <div class="copyright text-center text-md-start">
                    <p class="text-sm">
                        © Copyrights
                        <a href="#" class="footer-link fw-bolder">Valdez Prince developpeur </a>,
                        <script>
                            document.write(new Date().getFullYear());
                        </script>.
                        Tout droits reservés
                    </p>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</footer>
<!-- ========== footer end =========== -->
</main>
<!-- ======== main-wrapper end =========== -->

<!-- ========= All Javascript files linkup ======== -->
<script src="<?= TEMPLATE_PATH ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/Chart.min.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/dynamic-pie-chart.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/moment.min.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/fullcalendar.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/jvectormap.min.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/world-merc.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/polyfill.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/js/main.js"></script>

<script src="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= TEMPLATE_PATH ?>assets/vendor/simple-datatables/simple-datatables.js"></script>

<!-- build:js assets/vendor/js/core.js -->
<script src="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="<?= TEMPLATE_PATH ?>assets/vendor/jquery/jquery.min.js"></script>

<!-- Vendor JS Files -->
<script src="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="<?= TEMPLATE_PATH ?>assets/js/main-1.js"></script>

<script type="text/javascript">
    var logoutbtn = document.getElementById('logoutBtn');

    if (logoutbtn !== null) {
        logoutbtn.addEventListener('click', function() {
            if (confirm("Voulez-vous fermer votre session ?")) {
                location.href = "<?= VIEWS . 'Auth/logout.php' ?>";
            }
        });
    }
</script>

</script>

<script>
    // =========== chart one start
    const ctx1 = document.getElementById("Chart1").getContext("2d");
    const chart1 = new Chart(ctx1, {
        // The type of chart we want to create
        type: "line", // also try bar or other graph types

        // The data for our dataset
        data: {
            labels: [
                "Janvier",
                "Février",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Décembre",
            ],
            // Information about the dataset
            datasets: [{
                label: "",
                backgroundColor: "transparent",
                borderColor: "#4A6CF7",
                data: <?php echo json_encode($chart) ?>,
                pointBackgroundColor: "transparent",
                pointHoverBackgroundColor: "#4A6CF7",
                pointBorderColor: "transparent",
                pointHoverBorderColor: "#fff",
                pointHoverBorderWidth: 5,
                pointBorderWidth: 5,
                pointRadius: 8,
                pointHoverRadius: 8,
            }, ],
        },

        // Configuration options
        defaultFontFamily: "Inter",
        options: {
            tooltips: {
                callbacks: {
                    labelColor: function(tooltipItem, chart) {
                        return {
                            backgroundColor: "#ffffff",
                        };
                    },
                },
                intersect: false,
                backgroundColor: "#f9f9f9",
                titleFontFamily: "Inter",
                titleFontColor: "#8F92A1",
                titleFontColor: "#8F92A1",
                titleFontSize: 12,
                bodyFontFamily: "Inter",
                bodyFontColor: "#171717",
                bodyFontStyle: "bold",
                bodyFontSize: 16,
                multiKeyBackground: "transparent",
                displayColors: false,
                xPadding: 30,
                yPadding: 10,
                bodyAlign: "center",
                titleAlign: "center",
            },

            title: {
                display: false,
            },
            legend: {
                display: false,
            },

            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawTicks: false,
                        drawBorder: false,
                    },
                    ticks: {
                        padding: 35,
                        max: 500000,
                        min: 30000,
                    },
                }, ],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: "rgba(143, 146, 161, .1)",
                        zeroLineColor: "rgba(143, 146, 161, .1)",
                    },
                    ticks: {
                        padding: 20,
                    },
                }, ],
            },
        },
    });

    // =========== chart four end
</script>
</body>

</html>