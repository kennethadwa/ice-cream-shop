<?php

include('../connection.php');

// Query to get the count of pending orders
$query = "SELECT COUNT(*) AS pending_orders FROM transactions WHERE status = 'Pending'";
$result = mysqli_query($conn, $query);

// Fetch the result
$row = mysqli_fetch_assoc($result);
$pendingOrders = $row['pending_orders'] ? $row['pending_orders'] : 0; // Default to 0 if no data found

// Query to get the total number of orders for percentage calculation
$totalQuery = "SELECT COUNT(*) AS total_orders FROM transactions";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalOrders = $totalRow['total_orders'] ? $totalRow['total_orders'] : 1; // Default to 1 to prevent division by zero

// Calculate the percentage of pending orders
$pendingPercentage = ($pendingOrders / $totalOrders) * 100;
?>

<style>
    .mango-card {
        border: none;
        background: linear-gradient(135deg, #FFA500 , #FF8C00); /* Mango-inspired gradient */
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .mango-card-body {
        position: relative;
        padding: 20px;
    }

    .mango-card .text-warning {
        color: #FF8C00 !important; /* Vibrant mango orange */
    }

    .mango-card .text-gray-800 {
        color: #4B3F00 !important; /* Deep brown for contrast */
    }

    .text-xs {
        font-size: 0.85rem;
    }

    .h5 {
        font-size: 1.5rem;
    }

    .mango-progress {
        height: 8px;
        background: #FFF5E1; 
        border-radius: 5px;
        overflow: hidden;
    }

    .mango-progress-bar {
        background: #FF4500;
    }

    .mango-icon {
        position: relative;
        top: -10px;
        right: -10px;
        background: #FF6347; /* Bold orange for the icon background */
        padding: 10px;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .mango-icon i {
        color: #FFFFFF;
        font-size: 1.5rem;
    }

    .mango-card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease-in-out;
    }

    .mango-percentage {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
</style>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="mango-card h-100 py-2" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.9);">
        <div class="mango-card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Pending Orders
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-white text-center" style="margin-left: 50px;">
                        <?php echo $pendingOrders; ?>
                    </div>
                </div>
                <div class="mango-icon">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
            <div class="row no-gutters align-items-center">
                <div class="col-auto">
                    <div class="mango-percentage">
                        <div class="text-xs text-white" style="margin-right: 10px;">
                            <?php echo number_format($pendingPercentage, 2); ?>%
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="mango-progress">
                        <div class="progress-bar mango-progress-bar" role="progressbar" 
                            style="width: <?php echo $pendingPercentage; ?>%" 
                            aria-valuenow="<?php echo $pendingPercentage; ?>" 
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
