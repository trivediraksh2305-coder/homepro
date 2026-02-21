<?php
include("session.php");
include("../includes/db.php");

$provider_id = $_SESSION['provider_id'];

// Get current month data
$current_month = date('m');
$current_year = date('Y');

// Initialize variables with default values
$appointments_data = ['total' => 0, 'completed' => 0, 'pending' => 0, 'cancelled' => 0];
$monthly_earnings = 0;
$total_services = 0;
$avg_rating = 0;
$total_reviews = 0;
$unread_notifications = 0;
$monthly_chart_data = array_fill(0, 12, 0);
$notifications = [];
$recent_appointments = [];

// Check if tables exist and fetch data safely
try {
    // Appointments table check and data fetch
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'appointments'");
    if(mysqli_num_rows($table_check) > 0) {
        $appointments_query = mysqli_query($conn, "SELECT COUNT(*) as total, 
                                               SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as completed,
                                               SUM(CASE WHEN status='pending' THEN 1 ELSE 0 END) as pending,
                                               SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) as cancelled
                                               FROM appointments 
                                               WHERE provider_id='$provider_id' 
                                               AND MONTH(appointment_date)='$current_month' 
                                               AND YEAR(appointment_date)='$current_year'");
        if($appointments_query && mysqli_num_rows($appointments_query) > 0) {
            $appointments_data = mysqli_fetch_assoc($appointments_query);
        }
    }
} catch (Exception $e) {
    error_log("Appointments table error: " . $e->getMessage());
}

try {
    // Earnings table check and data fetch
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'earnings'");
    if(mysqli_num_rows($table_check) > 0) {
        $earnings_query = mysqli_query($conn, "SELECT SUM(amount) as total_earnings 
                                           FROM earnings 
                                           WHERE provider_id='$provider_id' 
                                           AND MONTH(earning_date)='$current_month' 
                                           AND YEAR(earning_date)='$current_year'");
        if($earnings_query && mysqli_num_rows($earnings_query) > 0) {
            $earnings_data = mysqli_fetch_assoc($earnings_query);
            $monthly_earnings = $earnings_data['total_earnings'] ?? 0;
        }
        
        // Monthly earnings for chart
        $chart_data = [];
        for($i = 1; $i <= 12; $i++) {
            $month_query = mysqli_query($conn, "SELECT SUM(amount) as total 
                                                FROM earnings 
                                                WHERE provider_id='$provider_id' 
                                                AND MONTH(earning_date)='$i' 
                                                AND YEAR(earning_date)='$current_year'");
            if($month_query && mysqli_num_rows($month_query) > 0) {
                $month_data = mysqli_fetch_assoc($month_query);
                $monthly_chart_data[$i-1] = $month_data['total'] ?? 0;
            }
        }
    }
} catch (Exception $e) {
    error_log("Earnings table error: " . $e->getMessage());
}

try {
    // Services count
    $services_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM services WHERE provider_id='$provider_id'");
    if($services_query && mysqli_num_rows($services_query) > 0) {
        $services_data = mysqli_fetch_assoc($services_query);
        $total_services = $services_data['total'];
    }
} catch (Exception $e) {
    error_log("Services table error: " . $e->getMessage());
}

try {
    // Reviews table check and data fetch
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'reviews'");
    if(mysqli_num_rows($table_check) > 0) {
        $rating_query = mysqli_query($conn, "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
                                             FROM reviews 
                                             WHERE provider_id='$provider_id'");
        if($rating_query && mysqli_num_rows($rating_query) > 0) {
            $rating_data = mysqli_fetch_assoc($rating_query);
            $avg_rating = number_format($rating_data['avg_rating'] ?? 0, 1);
            $total_reviews = $rating_data['total_reviews'] ?? 0;
        }
    }
} catch (Exception $e) {
    error_log("Reviews table error: " . $e->getMessage());
}

// Handle notifications
if(isset($_POST['mark_read'])) {
    $notification_id = mysqli_real_escape_string($conn, $_POST['notification_id']);
    try {
        mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id='$notification_id' AND provider_id='$provider_id'");
    } catch (Exception $e) {
        error_log("Error marking notification as read: " . $e->getMessage());
    }
}

if(isset($_POST['mark_all_read'])) {
    try {
        mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE provider_id='$provider_id' AND is_read=0");
    } catch (Exception $e) {
        error_log("Error marking all notifications as read: " . $e->getMessage());
    }
}

try {
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'notifications'");
    if(mysqli_num_rows($table_check) > 0) {
        $notifications_query = mysqli_query($conn, "SELECT * FROM notifications 
                                                    WHERE provider_id='$provider_id' 
                                                    ORDER BY created_at DESC 
                                                    LIMIT 10");
        if($notifications_query) {
            $notifications = mysqli_fetch_all($notifications_query, MYSQLI_ASSOC);
        }
        
        $unread_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM notifications 
                                             WHERE provider_id='$provider_id' AND is_read=0");
        if($unread_count && mysqli_num_rows($unread_count) > 0) {
            $unread_data = mysqli_fetch_assoc($unread_count);
            $unread_notifications = $unread_data['count'];
        }
    }
} catch (Exception $e) {
    error_log("Notifications table error: " . $e->getMessage());
}

// Fetch recent appointments with filters
$filter_status = $_GET['status'] ?? 'all';
$filter_date = $_GET['date'] ?? '';
$search = $_GET['search'] ?? '';

try {
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'appointments'");
    if(mysqli_num_rows($table_check) > 0) {
        $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
        if(mysqli_num_rows($table_check) > 0) {
            $appointments_query = "SELECT a.*, u.name as customer_name, u.phone as customer_phone 
                                   FROM appointments a 
                                   LEFT JOIN users u ON a.user_id = u.id 
                                   WHERE a.provider_id='$provider_id'";

            if($filter_status != 'all') {
                $appointments_query .= " AND a.status='$filter_status'";
            }

            if(!empty($filter_date)) {
                $appointments_query .= " AND DATE(a.appointment_date)='$filter_date'";
            }

            if(!empty($search)) {
                $appointments_query .= " AND (u.name LIKE '%$search%' OR a.service_name LIKE '%$search%')";
            }

            $appointments_query .= " ORDER BY a.appointment_date DESC LIMIT 10";
            $recent_appointments_result = mysqli_query($conn, $appointments_query);
            if($recent_appointments_result) {
                $recent_appointments = mysqli_fetch_all($recent_appointments_result, MYSQLI_ASSOC);
            }
        }
    }
} catch (Exception $e) {
    error_log("Recent appointments error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            overflow-x: hidden;
        }

        .content {
            margin-left: 280px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-header h2 {
            color: #333;
            font-weight: 700;
            font-size: 2rem;
            position: relative;
            padding-bottom: 10px;
            animation: fadeInLeft 0.6s ease;
        }

        .page-header h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .welcome-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea20, #764ba220);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stat-icon i {
            font-size: 2rem;
            color: #667eea;
        }

        .stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-content p {
            color: #666;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .trend-up { color: #28a745; }
        .trend-down { color: #dc3545; }

        /* Charts Row */
        .charts-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .chart-header h4 {
            color: #333;
            font-weight: 600;
        }

        canvas {
            max-height: 300px;
            width: 100% !important;
        }

        /* Notifications Panel */
        .notifications-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease 0.3s both;
        }

        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .notifications-header h4 {
            color: #333;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-unread {
            background: #ff6b6b;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .mark-all-read {
            background: none;
            border: 2px solid #eef2f6;
            padding: 8px 20px;
            border-radius: 12px;
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .mark-all-read:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .notification-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            animation: slideInRight 0.5s ease;
            background: #f8f9fc;
        }

        .notification-item.unread {
            background: linear-gradient(90deg, #e3f2fd, #f8f9fc);
            border-left: 4px solid #667eea;
        }

        .notification-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea20, #764ba220);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-icon i {
            color: #667eea;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content p {
            margin: 0;
            color: #333;
            font-weight: 500;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #999;
        }

        .mark-read-btn {
            background: none;
            border: none;
            color: #667eea;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mark-read-btn:hover {
            background: #667eea20;
        }

        /* Recent Appointments */
        .appointments-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 25px;
            animation: fadeInUp 0.6s ease 0.4s both;
        }

        .appointments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .appointments-header h4 {
            color: #333;
            font-weight: 600;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filters select,
        .filters input {
            padding: 8px 15px;
            border: 2px solid #eef2f6;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table th {
            color: #666;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 10px;
        }

        .table td {
            background: #f8f9fc;
            padding: 15px;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .table tr:hover td {
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-completed { background: #d4edda; color: #28a745; }
        .status-pending { background: #fff3cd; color: #ffc107; }
        .status-confirmed { background: #cce5ff; color: #007bff; }
        .status-cancelled { background: #f8d7da; color: #dc3545; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .content { margin-left: 250px; }
        }

        @media (max-width: 992px) {
            .charts-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 20px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-badge {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="content">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="fas fa-chart-pie me-3" style="color: #667eea;"></i>Dashboard Overview</h2>
        
        <div class="welcome-badge">
            <i class="fas fa-calendar-alt me-2"></i>
            <?php echo date('l, F j, Y'); ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $appointments_data['total'] ?? 0; ?></h3>
                <p>Total Appointments</p>
                <div class="stat-trend">
                    <span class="trend-up"><i class="fas fa-arrow-up"></i> This Month</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-content">
                <h3>₹<?php echo number_format($monthly_earnings); ?></h3>
                <p>Monthly Earnings</p>
                <div class="stat-trend">
                    <span class="trend-up"><i class="fas fa-arrow-up"></i> This Month</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $avg_rating; ?> <small style="font-size: 1rem;">/5</small></h3>
                <p>Average Rating</p>
                <div class="stat-trend">
                    <span><?php echo $total_reviews; ?> reviews</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $total_services; ?></h3>
                <p>Active Services</p>
                <div class="stat-trend">
                    <span><i class="fas fa-box"></i> Total Services</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
        <!-- Earnings Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h4><i class="fas fa-chart-line me-2" style="color: #667eea;"></i>Earnings Overview <?php echo $current_year; ?></h4>
            </div>
            <canvas id="earningsChart"></canvas>
        </div>

        <!-- Appointments Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <h4><i class="fas fa-chart-pie me-2" style="color: #667eea;"></i>Appointments Status</h4>
            </div>
            <canvas id="appointmentsChart"></canvas>
        </div>
    </div>

    <!-- Notifications Panel -->
    <div class="notifications-card">
        <div class="notifications-header">
            <h4>
                <i class="fas fa-bell me-2" style="color: #667eea;"></i>
                Notifications
                <?php if($unread_notifications > 0): ?>
                    <span class="badge-unread"><?php echo $unread_notifications; ?> new</span>
                <?php endif; ?>
            </h4>
            
            <form method="POST" style="display: inline;">
                <button type="submit" name="mark_all_read" class="mark-all-read">
                    <i class="fas fa-check-double me-2"></i>Mark All as Read
                </button>
            </form>
        </div>

        <div class="notifications-list">
            <?php if(!empty($notifications)): ?>
                <?php foreach($notifications as $notif): ?>
                    <div class="notification-item <?php echo $notif['is_read'] ? '' : 'unread'; ?>">
                        <div class="notification-icon">
                            <i class="fas fa-<?php echo $notif['type'] == 'appointment' ? 'calendar' : ($notif['type'] == 'payment' ? 'rupee-sign' : 'info-circle'); ?>"></i>
                        </div>
                        <div class="notification-content">
                            <p><?php echo htmlspecialchars($notif['message']); ?></p>
                            <span class="notification-time"><?php echo timeAgo($notif['created_at']); ?></span>
                        </div>
                        <?php if(!$notif['is_read']): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="notification_id" value="<?php echo $notif['id']; ?>">
                                <button type="submit" name="mark_read" class="mark-read-btn" title="Mark as read">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <p>No notifications yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="appointments-card">
        <div class="appointments-header">
            <h4><i class="fas fa-clock me-2" style="color: #667eea;"></i>Recent Appointments</h4>
            
            <div class="filters">
                <select id="statusFilter" onchange="applyFilters()">
                    <option value="all" <?php echo $filter_status == 'all' ? 'selected' : ''; ?>>All Status</option>
                    <option value="pending" <?php echo $filter_status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo $filter_status == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="completed" <?php echo $filter_status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $filter_status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
                
                <input type="text" id="searchInput" placeholder="Search customer..." value="<?php echo htmlspecialchars($search); ?>">
                
                <button onclick="applyFilters()" class="btn btn-primary" style="background: linear-gradient(90deg, #667eea, #764ba2); border: none;">
                    <i class="fas fa-search"></i>
                </button>
                
                <button onclick="clearFilters()" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date & Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($recent_appointments)): ?>
                        <?php foreach($recent_appointments as $apt): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="customer-avatar me-2">
                                            <i class="fas fa-user-circle" style="font-size: 2rem; color: #667eea;"></i>
                                        </div>
                                        <div>
                                            <strong><?php echo htmlspecialchars($apt['customer_name'] ?? 'Guest'); ?></strong>
                                            <br>
                                            <small><?php echo htmlspecialchars($apt['customer_phone'] ?? 'No phone'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($apt['service_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php echo isset($apt['appointment_date']) ? date('d M Y', strtotime($apt['appointment_date'])) : 'N/A'; ?>
                                    <br>
                                    <small><?php echo isset($apt['appointment_time']) ? date('h:i A', strtotime($apt['appointment_time'])) : ''; ?></small>
                                </td>
                                <td><strong>₹<?php echo isset($apt['amount']) ? number_format($apt['amount']) : '0'; ?></strong></td>
                                <td>
                                    <?php if(isset($apt['status'])): ?>
                                        <span class="status-badge status-<?php echo $apt['status']; ?>">
                                            <?php echo ucfirst($apt['status']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm" style="background: linear-gradient(90deg, #667eea20, #764ba220); color: #667eea; border: none;" onclick="viewDetails(<?php echo $apt['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <p>No appointments found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Charts JavaScript -->
<script>
// Earnings Chart
const earningsCtx = document.getElementById('earningsChart').getContext('2d');
const earningsChart = new Chart(earningsCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Earnings (₹)',
            data: <?php echo json_encode($monthly_chart_data); ?>,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#667eea',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return '₹' + context.raw.toLocaleString('en-IN');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#eef2f6' },
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString('en-IN');
                    }
                }
            }
        }
    }
});

// Appointments Distribution Chart
const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
new Chart(appointmentsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'Pending', 'Confirmed', 'Cancelled'],
        datasets: [{
            data: [
                <?php echo $appointments_data['completed'] ?? 0; ?>,
                <?php echo $appointments_data['pending'] ?? 0; ?>,
                <?php echo ($appointments_data['confirmed'] ?? 0); ?>,
                <?php echo $appointments_data['cancelled'] ?? 0; ?>
            ],
            backgroundColor: ['#28a745', '#ffc107', '#007bff', '#dc3545'],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        },
        cutout: '70%'
    }
});

// Apply filters
function applyFilters() {
    const status = document.getElementById('statusFilter').value;
    const search = document.getElementById('searchInput').value;
    
    let url = '?';
    if(status !== 'all') url += `status=${status}&`;
    if(search) url += `search=${encodeURIComponent(search)}&`;
    
    window.location.href = url;
}

// Clear filters
function clearFilters() {
    window.location.href = '?';
}

// View appointment details
function viewDetails(id) {
    window.location.href = `appointment_details.php?id=${id}`;
}

// Refresh data every 30 seconds
setInterval(function() {
    location.reload();
}, 30000);
</script>

<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<?php
// Helper function for time ago
function timeAgo($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);
    
    if($seconds <= 60) {
        return "Just now";
    } else if($minutes <= 60) {
        return ($minutes == 1) ? "1 minute ago" : "$minutes minutes ago";
    } else if($hours <= 24) {
        return ($hours == 1) ? "1 hour ago" : "$hours hours ago";
    } else if($days <= 7) {
        return ($days == 1) ? "yesterday" : "$days days ago";
    } else if($weeks <= 4.3) {
        return ($weeks == 1) ? "1 week ago" : "$weeks weeks ago";
    } else if($months <= 12) {
        return ($months == 1) ? "1 month ago" : "$months months ago";
    } else {
        return ($years == 1) ? "1 year ago" : "$years years ago";
    }
}
?>

</body>
</html>