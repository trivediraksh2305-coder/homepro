<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Include database connection for cart count
include("../includes/db.php");

// Get cart count for logged in user
$cart_count = 0;
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $cart_query = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
    $cart_result = mysqli_fetch_assoc($cart_query);
    $cart_count = $cart_result['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>HomePro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #eef2ff;
            --secondary: #7209b7;
            --accent: #f72585;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            --gradient-primary: linear-gradient(135deg, #4361ee, #7209b7);
            --gradient-accent: linear-gradient(135deg, #f72585, #7209b7);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            padding-top: 90px; /* Prevent content from hiding under fixed navbar */
        }

        /* ========== NAVBAR STYLES ========== */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 60px;
            box-shadow: var(--shadow-sm);
            min-height: 90px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: var(--transition);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .navbar.scrolled {
            padding: 10px 60px;
            min-height: 70px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-md);
        }

        /* Logo Styles */
        .navbar-brand {
            font-size: 32px;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            position: relative;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand::after {
            content: '•';
            position: absolute;
            right: -12px;
            top: -5px;
            font-size: 24px;
            color: var(--accent);
            -webkit-text-fill-color: var(--accent);
        }

        /* Nav Links */
        .navbar-nav {
            gap: 5px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark) !important;
            padding: 10px 20px !important;
            border-radius: 50px;
            transition: var(--transition);
            position: relative;
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 16px;
            color: var(--gray);
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--primary) !important;
            background: var(--primary-light);
        }

        .nav-link:hover i {
            color: var(--primary);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: var(--gradient-primary);
            color: white !important;
        }

        .nav-link.active i {
            color: white;
        }

        /* Cart Styles */
        .cart-wrapper {
            position: relative;
            margin-right: 20px;
        }

        .cart-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: var(--primary-light);
            border-radius: 50%;
            color: var(--primary);
            font-size: 20px;
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }

        .cart-link:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .cart-link:hover i {
            color: white;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent);
            color: white;
            font-size: 12px;
            font-weight: 700;
            min-width: 22px;
            height: 22px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            box-shadow: 0 2px 5px rgba(247, 37, 133, 0.3);
            animation: pulse 2s infinite;
            border: 2px solid white;
        }

        .cart-preview {
            position: absolute;
            top: 70px;
            right: 0;
            width: 380px;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1001;
            border: 1px solid var(--gray-light);
        }

        .cart-wrapper:hover .cart-preview {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .cart-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-light);
        }

        .cart-preview-header h6 {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .cart-preview-header span {
            background: var(--primary-light);
            color: var(--primary);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .cart-preview-items {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
        }

        .cart-preview-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-light);
        }

        .cart-preview-item img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
        }

        .cart-preview-item-info {
            flex: 1;
        }

        .cart-preview-item-info h6 {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .cart-preview-item-info p {
            font-size: 12px;
            color: var(--gray);
            margin: 0;
        }

        .cart-preview-item-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 14px;
        }

        .cart-preview-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 2px solid var(--gray-light);
        }

        .cart-preview-total {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }

        .cart-preview-total span {
            color: var(--primary);
            font-size: 18px;
            font-weight: 800;
            margin-left: 5px;
        }

        .cart-preview-btn {
            background: var(--gradient-primary);
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .cart-preview-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        /* Logout Button */
        .logout-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white !important;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.2);
        }

        .logout-btn i {
            font-size: 16px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
        }

        .logout-btn:hover i {
            transform: translateX(3px);
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            body {
                padding-top: 70px;
            }

            .navbar {
                padding: 10px 20px;
                min-height: 70px;
            }

            .navbar.scrolled {
                padding: 8px 20px;
            }

            .navbar-brand {
                font-size: 26px;
            }

            .navbar-brand::after {
                font-size: 20px;
                right: -10px;
            }

            .navbar-collapse {
                margin-top: 15px;
                background: white;
                border-radius: 20px;
                padding: 20px;
                box-shadow: var(--shadow-lg);
                animation: slideIn 0.3s ease;
            }

            .navbar-nav {
                gap: 5px;
                margin-bottom: 15px;
            }

            .nav-link {
                padding: 12px 20px !important;
                text-align: center;
            }

            .nav-link i {
                width: 20px;
            }

            .cart-wrapper {
                margin: 15px 0;
                display: flex;
                justify-content: center;
            }

            .cart-preview {
                position: fixed;
                top: auto;
                bottom: 20px;
                left: 20px;
                right: 20px;
                width: auto;
                max-width: 380px;
                margin: 0 auto;
            }

            .cart-wrapper:hover .cart-preview {
                display: block;
            }

            .logout-btn {
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 22px;
            }
            
            .cart-link {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
            
            .cart-badge {
                min-width: 20px;
                height: 20px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" id="mainNavbar">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand" href="home.php">
            HomePro
        </a>

        <!-- Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>" href="home.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="about.php">
                        <i class="fas fa-info-circle"></i> About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>" href="services.php">
                        <i class="fas fa-tools"></i> Services
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'active' : ''; ?>" href="bookings.php">
                        <i class="fas fa-calendar-check"></i> My Bookings
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>" href="contact.php">
                        <i class="fas fa-envelope"></i> Contact
                    </a>
                </li>
            </ul>

            <!-- Cart and Logout Section -->
            <div class="d-flex align-items-center">
                <!-- Cart with preview -->
                <div class="cart-wrapper">
                    <a href="cart.php" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if($cart_count > 0): ?>
                            <span class="cart-badge" id="cartCount"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Cart Preview Dropdown -->
                    <div class="cart-preview" id="cartPreview">
                        <div class="cart-preview-header">
                            <h6><i class="fas fa-shopping-cart me-2"></i>Your Cart</h6>
                            <span><?php echo $cart_count; ?> items</span>
                        </div>
                        
                        <div class="cart-preview-items" id="cartPreviewItems">
                            <!-- Cart items will be loaded here via AJAX -->
                            <div class="text-center py-3 text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                            </div>
                        </div>
                        
                        <div class="cart-preview-footer">
                            <div class="cart-preview-total">
                                Total: <span id="cartTotal">$0.00</span>
                            </div>
                            <a href="cart.php" class="cart-preview-btn">
                                View Cart <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <a href="login.php" class="logout-btn ms-3">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery for AJAX (optional, you can use vanilla JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    
    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#mainNavbar').addClass('scrolled');
        } else {
            $('#mainNavbar').removeClass('scrolled');
        }
    });

    // Load cart preview items
    function loadCartPreview() {
        $.ajax({
            url: 'get_cart_preview.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    updateCartPreview(response.data);
                }
            },
            error: function() {
                $('#cartPreviewItems').html('<div class="text-center py-3 text-danger">Failed to load cart</div>');
            }
        });
    }

    // Update cart preview HTML
    function updateCartPreview(cartData) {
        let itemsHtml = '';
        let total = 0;
        
        if(cartData.items && cartData.items.length > 0) {
            cartData.items.forEach(function(item) {
                itemsHtml += `
                    <div class="cart-preview-item">
                        <img src="../assets/${item.image}" alt="${item.name}">
                        <div class="cart-preview-item-info">
                            <h6>${item.name}</h6>
                            <p>Qty: ${item.quantity}</p>
                        </div>
                        <div class="cart-preview-item-price">
                            $${(item.price * item.quantity).toFixed(2)}
                        </div>
                    </div>
                `;
                total += item.price * item.quantity;
            });
            
            $('#cartTotal').text('$' + total.toFixed(2));
            $('.cart-badge').text(cartData.total_items);
        } else {
            itemsHtml = '<div class="text-center py-4"><i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i><p class="text-muted">Your cart is empty</p></div>';
            $('#cartTotal').text('$0.00');
            $('.cart-badge').hide();
        }
        
        $('#cartPreviewItems').html(itemsHtml);
        $('.cart-preview-header span').text(cartData.total_items + ' items');
    }

    // Load cart preview on hover
    let hoverTimer;
    $('.cart-wrapper').hover(
        function() {
            clearTimeout(hoverTimer);
            loadCartPreview();
        },
        function() {
            hoverTimer = setTimeout(function() {
                // Keep preview open for a moment before hiding
            }, 300);
        }
    );

    // Update cart count after adding items (listen for custom event)
    $(document).on('cartUpdated', function(e, newCount) {
        if(newCount > 0) {
            if($('.cart-badge').length) {
                $('.cart-badge').text(newCount).show();
            } else {
                $('.cart-link').append('<span class="cart-badge">' + newCount + '</span>');
            }
        } else {
            $('.cart-badge').hide();
        }
    });

    // Auto-refresh cart preview every 30 seconds
    setInterval(function() {
        if($('.cart-wrapper:hover').length) {
            loadCartPreview();
        }
    }, 30000);

    // Mark active nav link based on current page
    function setActiveNav() {
        const currentPage = window.location.pathname.split('/').pop();
        $('.nav-link').each(function() {
            const href = $(this).attr('href');
            if(href === currentPage) {
                $(this).addClass('active');
            }
        });
    }
    setActiveNav();

});
</script>

<!-- Create this file for AJAX cart preview -->
<?php
// Save this as get_cart_preview.php in the same directory
/*
<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$response = ['success' => true, 'data' => ['items' => [], 'total_items' => 0]];

$query = mysqli_query($conn, "
    SELECT c.*, s.name, s.price, s.image 
    FROM cart c 
    JOIN services s ON c.service_id = s.id 
    WHERE c.user_id = '$user_id'
");

$items = [];
$total_items = 0;

while($row = mysqli_fetch_assoc($query)){
    $items[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => floatval($row['price']),
        'quantity' => intval($row['quantity']),
        'image' => $row['image'] ?? 'default-service.jpg'
    ];
    $total_items += $row['quantity'];
}

$response['data']['items'] = $items;
$response['data']['total_items'] = $total_items;

echo json_encode($response);
?>
*/
?>

</body>
</html>