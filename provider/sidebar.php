<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if provider is logged in
if (!isset($_SESSION['provider_id'])) {
    header("Location: login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);
$provider_name = $_SESSION['provider_name'] ?? 'Provider';

// Get unread notifications count (optional - you can implement this)
// $unread_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM notifications WHERE provider_id='{$_SESSION['provider_id']}' AND is_read=0");
// $unread = mysqli_fetch_assoc($unread_count)['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fc;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 5px 0 20px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            animation: fadeInDown 0.6s ease;
        }

        .sidebar-header h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 15px 0 5px;
            background: linear-gradient(45deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0;
        }

        /* Provider Avatar */
        .provider-avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }

        .provider-avatar i {
            font-size: 2.5rem;
            color: white;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 0 15px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px 0;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.5s ease;
            animation-fill-mode: both;
        }

        /* Staggered Animation for Nav Items */
        .sidebar-nav a:nth-child(1) { animation-delay: 0.1s; }
        .sidebar-nav a:nth-child(2) { animation-delay: 0.2s; }
        .sidebar-nav a:nth-child(3) { animation-delay: 0.3s; }
        .sidebar-nav a:nth-child(4) { animation-delay: 0.4s; }
        .sidebar-nav a:nth-child(5) { animation-delay: 0.5s; }
        .sidebar-nav a:nth-child(6) { animation-delay: 0.6s; }
        .sidebar-nav a:nth-child(7) { animation-delay: 0.7s; }

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

        .sidebar-nav a i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .sidebar-nav a span {
            flex: 1;
            font-weight: 500;
        }

        /* Badge for notifications */
        .badge-count {
            background: #ff6b6b;
            color: white;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Active and Hover States */
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding-left: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav a:hover i,
        .sidebar-nav a.active i {
            transform: scale(1.1);
            color: #fff;
        }

        .sidebar-nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            border-radius: 0 4px 4px 0;
            animation: slideInLeft 0.3s ease;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-4px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Logout Button Special Style */
        .sidebar-nav a:last-child {
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .sidebar-nav a:last-child:hover {
            background: rgba(255, 107, 107, 0.2);
        }

        /* Content Area */
        .content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            transition: all 0.4s ease;
            background: #f4f7fc;
            position: relative;
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease;
        }

        .mobile-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(3px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 250px;
            }
            .content {
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
                box-shadow: none;
            }
            
            .sidebar.active {
                left: 0;
                box-shadow: 5px 0 30px rgba(0, 0, 0, 0.3);
            }
            
            .content {
                margin-left: 0;
                padding: 20px;
                width: 100%;
            }
            
            .mobile-toggle {
                display: block;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
            
            /* Adjust header for mobile */
            .sidebar-header {
                padding: 20px 15px;
            }
            
            .provider-avatar {
                width: 60px;
                height: 60px;
            }
            
            .provider-avatar i {
                font-size: 2rem;
            }
            
            .sidebar-header h4 {
                font-size: 1.2rem;
            }
            
            .sidebar-nav a {
                padding: 10px 15px;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 15px;
            }
            
            .mobile-toggle {
                top: 15px;
                left: 15px;
                padding: 10px 12px;
                font-size: 1rem;
            }
        }

        /* Tooltip Styles */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin-left: 10px;
            z-index: 1002;
        }

        [data-tooltip]:hover:before {
            opacity: 1;
            visibility: visible;
        }

        /* Loading Skeleton Animation */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body>

<!-- Mobile Toggle Button -->
<button class="mobile-toggle" id="sidebarToggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Sidebar Header with Provider Info -->
    <div class="sidebar-header">
        <div class="provider-avatar">
            <i class="fas fa-user-tie"></i>
        </div>
        <h4>Welcome, <?php echo htmlspecialchars(explode(' ', $provider_name)[0]); ?>!</h4>
        <p><i class="fas fa-circle" style="font-size: 8px; color: #4caf50;"></i> Online</p>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar-nav">
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" data-tooltip="Dashboard">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="appointments.php" class="<?php echo ($current_page == 'appointments.php') ? 'active' : ''; ?>" data-tooltip="View Appointments">
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span>
            <?php if(isset($unread) && $unread > 0): ?>
                <span class="badge-count"><?php echo $unread; ?></span>
            <?php endif; ?>
        </a>

        <a href="earnings.php" class="<?php echo ($current_page == 'earnings.php') ? 'active' : ''; ?>" data-tooltip="Earnings & Reports">
            <i class="fas fa-wallet"></i>
            <span>Earnings</span>
        </a>

        <a href="services.php" class="<?php echo ($current_page == 'services.php' || $current_page == 'manage_services.php') ? 'active' : ''; ?>" data-tooltip="Manage Services">
            <i class="fas fa-tools"></i>
            <span>Services</span>
        </a>

        <a href="portfolio.php" class="<?php echo ($current_page == 'portfolio.php') ? 'active' : ''; ?>" data-tooltip="My Portfolio">
            <i class="fas fa-briefcase"></i>
            <span>Portfolio</span>
        </a>

        <a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>" data-tooltip="Account Settings">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>

        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" data-tooltip="Logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- JavaScript for Sidebar Toggle -->
<script>
// Toggle sidebar on mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Change toggle icon
    if (sidebar.classList.contains('active')) {
        toggleBtn.innerHTML = '<i class="fas fa-times"></i>';
    } else {
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
    }
}

// Close sidebar when clicking on a link (mobile)
document.querySelectorAll('.sidebar-nav a').forEach(link => {
    link.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            // Don't close if it's the logout link (confirmation will show)
            if (!this.getAttribute('href').includes('logout')) {
                setTimeout(() => {
                    toggleSidebar();
                }, 100);
            }
        }
    });
});

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
    }
});

// Add active class based on URL path
document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.sidebar-nav a');
    
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref === currentLocation) {
            link.classList.add('active');
        }
    });
});

// Keyboard shortcut to toggle sidebar (Ctrl+B)
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'b') {
        e.preventDefault();
        if (window.innerWidth <= 768) {
            toggleSidebar();
        }
    }
});

// Smooth hover effects
document.querySelectorAll('.sidebar-nav a').forEach(link => {
    link.addEventListener('mouseenter', function() {
        this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    });
});

// Add loading animation for page transitions
document.querySelectorAll('.sidebar-nav a:not([href*="logout"])').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!this.classList.contains('active') && !this.getAttribute('href').includes('logout')) {
            // You can add a loading indicator here
            document.body.style.opacity = '0.6';
            document.body.style.transition = 'opacity 0.3s ease';
        }
    });
});
</script>

</body>
</html>