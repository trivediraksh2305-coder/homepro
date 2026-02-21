<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("header.php");

// Sample cart data - In real application, this would come from database
$cart_items = [
    [
        'id' => 1,
        'name' => 'Deep Cleaning Service',
        'category' => 'Cleaning',
        'provider' => 'CleanPro Services',
        'provider_img' => 'https://randomuser.me/api/portraits/men/1.jpg',
        'price' => 79,
        'price_type' => 'session',
        'original_price' => 99,
        'discount' => 20,
        'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400',
        'date' => '2024-03-25',
        'time' => '10:00 AM',
        'duration' => '3 hours',
        'quantity' => 1
    ],
    [
        'id' => 2,
        'name' => 'Emergency Plumbing',
        'category' => 'Plumbing',
        'provider' => 'QuickFix Plumbing',
        'provider_img' => 'https://randomuser.me/api/portraits/men/2.jpg',
        'price' => 89,
        'price_type' => 'hour',
        'original_price' => 110,
        'discount' => 15,
        'image' => 'https://images.unsplash.com/photo-1504320995620-8ee6f2aac7e4?w=400',
        'date' => '2024-03-26',
        'time' => '2:00 PM',
        'duration' => '2 hours',
        'quantity' => 1
    ],
    [
        'id' => 3,
        'name' => 'AC Service & Repair',
        'category' => 'HVAC',
        'provider' => 'CoolTech HVAC',
        'provider_img' => 'https://randomuser.me/api/portraits/men/5.jpg',
        'price' => 89,
        'price_type' => 'visit',
        'original_price' => 120,
        'discount' => 25,
        'image' => 'https://images.unsplash.com/photo-1631545804402-7d8b3e3f9b9f?w=400',
        'date' => '2024-03-27',
        'time' => '11:30 AM',
        'duration' => '1.5 hours',
        'quantity' => 1
    ]
];

// Calculate totals
$subtotal = 0;
$total_discount = 0;
$service_fee = 5.99;
$gst_rate = 0.18; // 18% GST

foreach($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
    $total_discount += ($item['original_price'] - $item['price']) * $item['quantity'];
}

$gst = $subtotal * $gst_rate;
$total = $subtotal + $service_fee + $gst;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Home Services</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Cart Page Specific Styles */
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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Cart Header */
        .cart-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 60px 0;
            color: white;
            margin-bottom: 40px;
            text-align: center;
        }

        .cart-header h1 {
            font-size: clamp(2rem, 5vw, 2.8rem);
            margin-bottom: 10px;
        }

        .cart-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .cart-header i {
            margin-right: 10px;
        }

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
            margin-bottom: 60px;
        }

        @media (max-width: 992px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Cart Items */
        .cart-items {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .cart-items-header {
            padding: 20px 25px;
            background: var(--light);
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .cart-items-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
        }

        .cart-items-header h3 i {
            color: var(--primary);
            margin-right: 8px;
        }

        .select-all {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .select-all label {
            color: var(--gray);
            font-size: 0.95rem;
            cursor: pointer;
        }

        /* Cart Item Card */
        .cart-item {
            padding: 25px;
            border-bottom: 1px solid var(--gray-light);
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            transition: var(--transition);
            position: relative;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item:hover {
            background: var(--light);
        }

        /* Item Checkbox */
        .item-checkbox {
            padding-top: 5px;
        }

        .item-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        /* Item Image */
        .item-image {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .cart-item:hover .item-image img {
            transform: scale(1.05);
        }

        /* Item Details */
        .item-details {
            flex: 1;
        }

        .item-category {
            display: inline-block;
            padding: 4px 12px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .item-details h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .item-provider {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .item-provider img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            object-fit: cover;
        }

        .item-provider span {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .item-provider span strong {
            color: var(--dark);
            font-weight: 600;
        }

        /* Schedule Info */
        .item-schedule {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .schedule-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--light);
            padding: 6px 15px;
            border-radius: 100px;
            font-size: 0.9rem;
        }

        .schedule-badge i {
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* Price Info */
        .item-pricing {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .current-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
        }

        .original-price {
            font-size: 1rem;
            color: var(--gray);
            text-decoration: line-through;
        }

        .discount-badge {
            background: var(--success);
            color: white;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Quantity Controls */
        .item-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 15px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--light);
            padding: 5px;
            border-radius: 50px;
            border: 1px solid var(--gray-light);
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            background: white;
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .quantity-btn:hover {
            background: var(--primary);
            color: white;
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-value {
            font-size: 1.1rem;
            font-weight: 600;
            min-width: 30px;
            text-align: center;
        }

        .item-total {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .item-total strong {
            font-size: 1.3rem;
            color: var(--dark);
            margin-left: 5px;
        }

        /* Remove Button */
        .remove-item {
            background: none;
            border: none;
            color: var(--gray);
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            padding: 5px;
        }

        .remove-item:hover {
            color: var(--danger);
            transform: scale(1.1);
        }

        /* Cart Summary */
        .cart-summary {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            padding: 25px;
            position: sticky;
            top: 100px;
        }

        .summary-header {
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-light);
            margin-bottom: 20px;
        }

        .summary-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
        }

        .summary-header h3 i {
            color: var(--primary);
            margin-right: 8px;
        }

        /* Coupon Code */
        .coupon-section {
            margin-bottom: 20px;
        }

        .coupon-input {
            display: flex;
            gap: 10px;
        }

        .coupon-input input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid var(--gray-light);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .coupon-input input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .coupon-input button {
            padding: 12px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .coupon-input button:hover {
            background: var(--primary-dark);
        }

        .applied-coupon {
            background: var(--success);
            color: white;
            padding: 10px 15px;
            border-radius: 12px;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .applied-coupon i {
            cursor: pointer;
        }

        /* Price Breakdown */
        .price-breakdown {
            margin-bottom: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: var(--gray);
            font-size: 1rem;
        }

        .price-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed var(--gray-light);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .price-row.discount {
            color: var(--success);
        }

        .price-row span:last-child {
            font-weight: 600;
        }

        /* Checkout Button */
        .checkout-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .checkout-btn i {
            transition: transform 0.3s ease;
        }

        .checkout-btn:hover i {
            transform: translateX(5px);
        }

        /* Payment Methods */
        .payment-methods {
            text-align: center;
        }

        .payment-methods p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .payment-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            font-size: 2rem;
            color: var(--gray);
        }

        .payment-icons i {
            transition: var(--transition);
        }

        .payment-icons i:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* Empty Cart */
        .empty-cart {
            background: white;
            border-radius: 20px;
            padding: 60px 20px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .empty-cart i {
            font-size: 5rem;
            color: var(--gray-light);
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .empty-cart p {
            color: var(--gray);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .continue-shopping {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 40px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
        }

        .continue-shopping:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Recommended Services */
        .recommended-section {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        .recommended-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .recommended-header h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .recommended-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        @media (max-width: 992px) {
            .recommended-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .recommended-grid {
                grid-template-columns: 1fr;
            }
        }

        .rec-service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .rec-service-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .rec-service-image {
            height: 150px;
            overflow: hidden;
        }

        .rec-service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rec-service-content {
            padding: 15px;
        }

        .rec-service-content h5 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .rec-service-price {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .rec-add-btn {
            width: 100%;
            padding: 8px;
            background: var(--primary-light);
            color: var(--primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .rec-add-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 9999;
            border-left: 4px solid var(--success);
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast i {
            font-size: 1.5rem;
            color: var(--success);
        }

        .toast-content h6 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .toast-content p {
            font-size: 0.9rem;
            color: var(--gray);
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        .loading-overlay.show {
            display: flex;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 4px solid var(--gray-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<!-- Cart Header -->
<section class="cart-header">
    <div class="container">
        <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
        <p><?php echo count($cart_items); ?> item(s) in your cart</p>
    </div>
</section>

<div class="container">
    <?php if(empty($cart_items)): ?>
        <!-- Empty Cart -->
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any services to your cart yet.</p>
            <a href="index.php" class="continue-shopping">
                <i class="fas fa-arrow-left"></i> Browse Services
            </a>
        </div>
    <?php else: ?>
        <!-- Cart Layout -->
        <div class="cart-layout">
            <!-- Cart Items Section -->
            <div class="cart-items">
                <div class="cart-items-header">
                    <h3><i class="fas fa-list"></i> Cart Items (<?php echo count($cart_items); ?>)</h3>
                    <div class="select-all">
                        <input type="checkbox" id="selectAll" checked>
                        <label for="selectAll">Select All</label>
                    </div>
                </div>

                <!-- Cart Items List -->
                <div id="cartItemsList">
                    <?php foreach($cart_items as $index => $item): ?>
                    <div class="cart-item" data-item-id="<?php echo $item['id']; ?>">
                        <div class="item-checkbox">
                            <input type="checkbox" class="item-select" checked>
                        </div>
                        
                        <div class="item-image">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        </div>
                        
                        <div class="item-details">
                            <span class="item-category"><?php echo $item['category']; ?></span>
                            <h4><?php echo $item['name']; ?></h4>
                            
                            <div class="item-provider">
                                <img src="<?php echo $item['provider_img']; ?>" alt="<?php echo $item['provider']; ?>">
                                <span><strong><?php echo $item['provider']; ?></strong> • Professional</span>
                            </div>
                            
                            <div class="item-schedule">
                                <span class="schedule-badge">
                                    <i class="fas fa-calendar"></i> <?php echo date('F j, Y', strtotime($item['date'])); ?>
                                </span>
                                <span class="schedule-badge">
                                    <i class="fas fa-clock"></i> <?php echo $item['time']; ?> (<?php echo $item['duration']; ?>)
                                </span>
                            </div>
                            
                            <div class="item-pricing">
                                <span class="current-price">$<?php echo $item['price']; ?></span>
                                <?php if(isset($item['original_price']) && $item['original_price'] > $item['price']): ?>
                                    <span class="original-price">$<?php echo $item['original_price']; ?></span>
                                    <span class="discount-badge">-<?php echo $item['discount']; ?>%</span>
                                <?php endif; ?>
                                <span class="item-type">/ <?php echo $item['price_type']; ?></span>
                            </div>
                        </div>
                        
                        <div class="item-actions">
                            <button class="remove-item" onclick="removeItem(<?php echo $item['id']; ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            
                            <div class="quantity-control">
                                <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease')" <?php echo $item['quantity'] <= 1 ? 'disabled' : ''; ?>>
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity-value" id="quantity-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
                                <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase')">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            
                            <div class="item-total">
                                <span>Total: <strong>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></strong></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-header">
                    <h3><i class="fas fa-receipt"></i> Order Summary</h3>
                </div>
                
                <!-- Coupon Code -->
                <div class="coupon-section">
                    <div class="coupon-input">
                        <input type="text" id="couponCode" placeholder="Enter coupon code">
                        <button onclick="applyCoupon()">Apply</button>
                    </div>
                    <div id="appliedCoupon" style="display: none;" class="applied-coupon">
                        <span><i class="fas fa-tag"></i> <span id="couponName">SAVE20</span> applied</span>
                        <i class="fas fa-times" onclick="removeCoupon()"></i>
                    </div>
                </div>
                
                <!-- Price Breakdown -->
                <div class="price-breakdown">
                    <div class="price-row">
                        <span>Subtotal (<span id="itemCount"><?php echo count($cart_items); ?></span> items)</span>
                        <span>$<span id="subtotal"><?php echo number_format($subtotal, 2); ?></span></span>
                    </div>
                    
                    <div class="price-row discount" id="discountRow">
                        <span>Discount</span>
                        <span>-$<span id="discount"><?php echo number_format($total_discount, 2); ?></span></span>
                    </div>
                    
                    <div class="price-row" id="couponDiscountRow" style="display: none;">
                        <span>Coupon Discount (<span id="couponDiscountPercent">10</span>%)</span>
                        <span>-$<span id="couponDiscount">0.00</span></span>
                    </div>
                    
                    <div class="price-row">
                        <span>Service Fee</span>
                        <span>$<span id="serviceFee"><?php echo number_format($service_fee, 2); ?></span></span>
                    </div>
                    
                    <div class="price-row">
                        <span>GST (18%)</span>
                        <span>$<span id="gst"><?php echo number_format($gst, 2); ?></span></span>
                    </div>
                    
                    <div class="price-row total">
                        <span>Total Amount</span>
                        <span>$<span id="total"><?php echo number_format($total, 2); ?></span></span>
                    </div>
                </div>
                
                <!-- Checkout Button -->
                <button class="checkout-btn" onclick="proceedToCheckout()">
                    Proceed to Checkout <i class="fas fa-arrow-right"></i>
                </button>
                
                <!-- Payment Methods -->
                <div class="payment-methods">
                    <p>We Accept</p>
                    <div class="payment-icons">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                        <i class="fab fa-google-pay"></i>
                        <i class="fab fa-apple-pay"></i>
                    </div>
                </div>
                
                <!-- Secure Checkout Note -->
                <div style="text-align: center; margin-top: 20px; color: var(--gray); font-size: 0.85rem;">
                    <i class="fas fa-lock" style="margin-right: 5px;"></i>
                    Secure SSL Encrypted Checkout
                </div>
            </div>
        </div>
        
        <!-- Recommended Services -->
        <section class="recommended-section">
            <div class="recommended-header">
                <h3>You might also like</h3>
                <a href="services.php" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="recommended-grid">
                <!-- Recommended Service 1 -->
                <div class="rec-service-card">
                    <div class="rec-service-image">
                        <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=400" alt="Electrical">
                    </div>
                    <div class="rec-service-content">
                        <h5>Electrical Wiring</h5>
                        <div class="rec-service-price">$75/hour</div>
                        <button class="rec-add-btn" onclick="addToCart(4)">
                            <i class="fas fa-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
                
                <!-- Recommended Service 2 -->
                <div class="rec-service-card">
                    <div class="rec-service-image">
                        <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=400" alt="Painting">
                    </div>
                    <div class="rec-service-content">
                        <h5>Wall Painting</h5>
                        <div class="rec-service-price">$299/room</div>
                        <button class="rec-add-btn" onclick="addToCart(5)">
                            <i class="fas fa-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
                
                <!-- Recommended Service 3 -->
                <div class="rec-service-card">
                    <div class="rec-service-image">
                        <img src="https://images.unsplash.com/photo-1527576539890-dfa815648363?w=400" alt="Gardening">
                    </div>
                    <div class="rec-service-content">
                        <h5>Garden Maintenance</h5>
                        <div class="rec-service-price">$59/hour</div>
                        <button class="rec-add-btn" onclick="addToCart(6)">
                            <i class="fas fa-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
                
                <!-- Recommended Service 4 -->
                <div class="rec-service-card">
                    <div class="rec-service-image">
                        <img src="https://images.unsplash.com/photo-1605000797499-95a51c5269ae?w=400" alt="Carpet">
                    </div>
                    <div class="rec-service-content">
                        <h5>Carpet Cleaning</h5>
                        <div class="rec-service-price">$99/room</div>
                        <button class="rec-add-btn" onclick="addToCart(7)">
                            <i class="fas fa-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <div class="toast-content">
        <h6 id="toastTitle">Success!</h6>
        <p id="toastMessage">Item added to cart</p>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loader"></div>
</div>

<script>
    // Cart functionality
    let couponApplied = false;
    let couponDiscount = 0;
    let couponPercent = 0;
    
    // Update quantity
    function updateQuantity(itemId, action) {
        const quantitySpan = document.getElementById(`quantity-${itemId}`);
        let quantity = parseInt(quantitySpan.textContent);
        
        if(action === 'increase') {
            quantity++;
        } else if(action === 'decrease' && quantity > 1) {
            quantity--;
        }
        
        quantitySpan.textContent = quantity;
        updateItemTotal(itemId, quantity);
        updateCartSummary();
        
        // Enable/disable decrease button
        const decreaseBtn = quantitySpan.parentElement.querySelector('.quantity-btn:first-child');
        decreaseBtn.disabled = quantity <= 1;
        
        showToast('Cart Updated', 'Quantity updated successfully');
    }
    
    // Update item total
    function updateItemTotal(itemId, quantity) {
        // In real app, you'd fetch price from database
        // For demo, using hardcoded prices
        const prices = {
            1: 79,
            2: 89,
            3: 89
        };
        
        const price = prices[itemId] || 0;
        const itemTotal = price * quantity;
        
        // Update item total display
        const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
        if(itemElement) {
            const totalSpan = itemElement.querySelector('.item-total strong');
            if(totalSpan) {
                totalSpan.textContent = `$${itemTotal.toFixed(2)}`;
            }
        }
    }
    
    // Remove item
    function removeItem(itemId) {
        if(confirm('Are you sure you want to remove this item?')) {
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            if(itemElement) {
                itemElement.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => {
                    itemElement.remove();
                    updateCartSummary();
                    showToast('Item Removed', 'Item has been removed from cart');
                    
                    // Check if cart is empty
                    const cartItems = document.querySelectorAll('.cart-item');
                    if(cartItems.length === 0) {
                        location.reload(); // Reload to show empty cart
                    }
                }, 300);
            }
        }
    }
    
    // Update cart summary
    function updateCartSummary() {
        let subtotal = 0;
        let totalDiscount = 0;
        const items = document.querySelectorAll('.cart-item');
        const itemCount = items.length;
        
        items.forEach(item => {
            const priceElement = item.querySelector('.current-price');
            const originalPriceElement = item.querySelector('.original-price');
            const quantityElement = item.querySelector('.quantity-value');
            
            if(priceElement && quantityElement) {
                const price = parseFloat(priceElement.textContent.replace('$', ''));
                const quantity = parseInt(quantityElement.textContent);
                subtotal += price * quantity;
                
                if(originalPriceElement) {
                    const originalPrice = parseFloat(originalPriceElement.textContent.replace('$', ''));
                    totalDiscount += (originalPrice - price) * quantity;
                }
            }
        });
        
        const serviceFee = 5.99;
        const gst = subtotal * 0.18;
        
        // Apply coupon discount if active
        let couponDiscountAmount = 0;
        if(couponApplied) {
            couponDiscountAmount = subtotal * (couponPercent / 100);
        }
        
        const totalAfterCoupon = subtotal - couponDiscountAmount;
        const total = totalAfterCoupon + serviceFee + gst;
        
        // Update display
        document.getElementById('itemCount').textContent = itemCount;
        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('discount').textContent = totalDiscount.toFixed(2);
        document.getElementById('serviceFee').textContent = serviceFee.toFixed(2);
        document.getElementById('gst').textContent = gst.toFixed(2);
        
        if(couponApplied) {
            document.getElementById('couponDiscount').textContent = couponDiscountAmount.toFixed(2);
        }
        
        document.getElementById('total').textContent = total.toFixed(2);
    }
    
    // Apply coupon
    function applyCoupon() {
        const couponInput = document.getElementById('couponCode');
        const couponCode = couponInput.value.trim().toUpperCase();
        
        const validCoupons = {
            'SAVE10': 10,
            'SAVE20': 20,
            'WELCOME15': 15,
            'FIRST25': 25
        };
        
        if(validCoupons[couponCode]) {
            couponApplied = true;
            couponPercent = validCoupons[couponCode];
            
            // Show coupon applied section
            document.getElementById('appliedCoupon').style.display = 'flex';
            document.getElementById('couponName').textContent = couponCode;
            document.getElementById('couponDiscountRow').style.display = 'flex';
            document.getElementById('couponDiscountPercent').textContent = couponPercent;
            
            // Clear input
            couponInput.value = '';
            
            // Update summary
            updateCartSummary();
            showToast('Coupon Applied', `${couponCode} discount applied successfully`);
        } else {
            alert('Invalid coupon code');
        }
    }
    
    // Remove coupon
    function removeCoupon() {
        couponApplied = false;
        couponPercent = 0;
        document.getElementById('appliedCoupon').style.display = 'none';
        document.getElementById('couponDiscountRow').style.display = 'none';
        updateCartSummary();
        showToast('Coupon Removed', 'Coupon has been removed');
    }
    
    // Add to cart from recommended
    function addToCart(serviceId) {
        showLoading();
        
        // Simulate API call
        setTimeout(() => {
            hideLoading();
            showToast('Added to Cart', 'Service added to your cart');
            
            // In real app, you'd add to cart and maybe update cart count
            // For demo, just show success message
        }, 1000);
    }
    
    // Proceed to checkout
    function proceedToCheckout() {
        const selectedItems = document.querySelectorAll('.item-select:checked');
        
        if(selectedItems.length === 0) {
            alert('Please select at least one item to checkout');
            return;
        }
        
        showLoading();
        
        // Simulate checkout process
        setTimeout(() => {
            hideLoading();
            window.location.href = 'checkout.php';
        }, 1500);
    }
    
    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-select');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Individual checkbox change
    document.querySelectorAll('.item-select').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = document.querySelectorAll('.item-select:checked').length === document.querySelectorAll('.item-select').length;
            document.getElementById('selectAll').checked = allChecked;
        });
    });
    
    // Toast notification
    function showToast(title, message) {
        const toast = document.getElementById('toast');
        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;
        
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
    
    // Loading overlay
    function showLoading() {
        document.getElementById('loadingOverlay').classList.add('show');
    }
    
    function hideLoading() {
        document.getElementById('loadingOverlay').classList.remove('show');
    }
    
    // Add animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            to {
                opacity: 0;
                transform: translateX(-100%);
            }
        }
    `;
    document.head.appendChild(style);
</script>

<?php include("footer.php"); ?>
?>