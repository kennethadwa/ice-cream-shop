<style>
    #orderTypePieChart, #statusPieChart {
        max-height: 300px; /* Adjust as needed */
        width: 100%;       /* Ensure it scales within the card */
    }
</style>


<?php
require_once '../connection.php';

// Query for the first pie chart: order types
$orderTypeQuery = "
    SELECT 
        ot.order_type, 
        COUNT(t.order_id) AS total 
    FROM 
        transactions t 
    JOIN 
        order_types ot 
    ON 
        t.order_id = ot.order_id 
    GROUP BY 
        ot.order_type";
$orderTypeResult = $conn->query($orderTypeQuery);
$orderTypeData = [];
while ($row = $orderTypeResult->fetch_assoc()) {
    $orderTypeData[$row['order_type']] = $row['total'];
}

// Query for the second pie chart: order statuses
$statusQuery = "
    SELECT 
        t.status, 
        COUNT(t.order_id) AS total 
    FROM 
        transactions t 
    GROUP BY 
        t.status";
$statusResult = $conn->query($statusQuery);
$statusData = [];
while ($row = $statusResult->fetch_assoc()) {
    $statusData[$row['status']] = $row['total'];
}
?>

<div class="row">
    <!-- First Pie Chart -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Types</h6>
            </div>
            <div class="card-body">
                <canvas id="orderTypePieChart"></canvas>
                <div id="orderTypeLegend" class="mt-3"></div>
            </div>
        </div>
    </div>

    <!-- Second Pie Chart -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Status</h6>
            </div>
            <div class="card-body">
                <canvas id="statusPieChart"></canvas>
                <div id="statusLegend" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data for the first pie chart
    const orderTypeData = {
        labels: ["For Delivery", "For Pickup"],
        datasets: [{
            data: [
                <?= $orderTypeData['For Delivery'] ?? 0 ?>,
                <?= $orderTypeData['For Pickup'] ?? 0 ?>
            ],
            backgroundColor: ["#4e73df", "#1cc88a"],
            hoverBackgroundColor: ["#2e59d9", "#17a673"],
            hoverBorderColor: "#ffffff",
        }]
    };

    // Data for the second pie chart
    const statusData = {
        labels: ["Pending", "Completed", "Cancelled"],
        datasets: [{
            data: [
                <?= $statusData['Pending'] ?? 0 ?>,
                <?= $statusData['Completed'] ?? 0 ?>,
                <?= $statusData['Cancelled'] ?? 0 ?>
            ],
            backgroundColor: ["#f6c23e", "#1cc88a", "#e74a3b"],
            hoverBackgroundColor: ["#d4a52c", "#17a673", "#c82333"],
            hoverBorderColor: "#ffffff",
        }]
    };

    // Configurations for both pie charts
    const config = (data) => ({
        type: 'pie',
        data: data,
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false, // Turn off the default legend
                }
            }
        },
    });

    // Render the first pie chart and create a legend
    const orderTypeChart = new Chart(document.getElementById('orderTypePieChart'), config(orderTypeData));
    document.getElementById('orderTypeLegend').innerHTML = orderTypeChart.generateLegend();

    // Render the second pie chart and create a legend
    const statusChart = new Chart(document.getElementById('statusPieChart'), config(statusData));
    document.getElementById('statusLegend').innerHTML = statusChart.generateLegend();
</script>