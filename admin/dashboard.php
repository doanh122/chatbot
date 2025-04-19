<?php 
require('inc/ess.php');
adminLogin();
?>

<?php
// dashboard.php
require('inc/db_connect.php');

// Retrieve weekly room booking statistics
$weekly_query = "SELECT r.room_number, COUNT(*) as total_booking 
    FROM bookings b 
    JOIN rooms r ON b.room_id = r.room_id 
    WHERE YEARWEEK(b.booking_date, 1) = YEARWEEK(CURDATE(), 1)
    GROUP BY r.room_number 
    ORDER BY total_booking DESC";
$weekly_result = $conn->query($weekly_query);
$weekly_labels = [];
$weekly_data = [];
if ($weekly_result) {
    while($row = $weekly_result->fetch_assoc()){
        $weekly_labels[] = $row['room_number'];
        $weekly_data[] = $row['total_booking'];
    }
}

// Retrieve monthly room booking statistics
$monthly_query = "SELECT r.room_number, COUNT(*) as total_booking 
    FROM bookings b 
    JOIN rooms r ON b.room_id = r.room_id 
    WHERE MONTH(b.booking_date) = MONTH(CURDATE()) 
      AND YEAR(b.booking_date) = YEAR(CURDATE())
    GROUP BY r.room_number 
    ORDER BY total_booking DESC";
$monthly_result = $conn->query($monthly_query);
$monthly_labels = [];
$monthly_data = [];
if ($monthly_result) {
    while($row = $monthly_result->fetch_assoc()){
        $monthly_labels[] = $row['room_number'];
        $monthly_data[] = $row['total_booking'];
    }
}

// Retrieve revenue per room
$revenue_query = "SELECT r.room_number, SUM(b.total_price) as revenue 
    FROM bookings b 
    JOIN rooms r ON b.room_id = r.room_id 
    GROUP BY r.room_number 
    ORDER BY revenue DESC";
$revenue_result = $conn->query($revenue_query);
$revenue_labels = [];
$revenue_data = [];
if ($revenue_result) {
    while($row = $revenue_result->fetch_assoc()){
        $revenue_labels[] = $row['room_number'];
        $revenue_data[] = $row['revenue'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php require('inc/links.php'); ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-header {
            font-weight: bold;
        }
        .chart-container {
            position: relative;
            height: 350px;
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid py-4" id="main-content">
        <div class="row justify-content-center" style="margin-left: 30px;">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h2 class="mb-4">Dashboard - Statistics</h2>

                <!-- Chart: Room Bookings This Week -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Room Bookings This Week
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="weeklyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart: Room Bookings This Month -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Room Bookings This Month
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart: Revenue Per Room -->
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        Revenue Per Room
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/script.php'); ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data for Weekly Chart
        const weeklyLabels = <?php echo json_encode($weekly_labels); ?>;
        const weeklyData = <?php echo json_encode($weekly_data); ?>;

        const ctxWeekly = document.getElementById('weeklyChart').getContext('2d');
        const weeklyChart = new Chart(ctxWeekly, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Number of Bookings',
                    data: weeklyData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Data for Monthly Chart
        const monthlyLabels = <?php echo json_encode($monthly_labels); ?>;
        const monthlyData = <?php echo json_encode($monthly_data); ?>;

        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Number of Bookings',
                    data: monthlyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Data for Revenue Chart
        const revenueLabels = <?php echo json_encode($revenue_labels); ?>;
        const revenueData = <?php echo json_encode($revenue_data); ?>;

        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue (VND)',
                    data: revenueData,
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'VND' }).format(value);
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>

</html>
