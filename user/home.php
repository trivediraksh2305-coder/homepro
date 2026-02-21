<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("header.php");
?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    background: #ffffff;
    color: var(--dark);
    line-height: 1.6;
    overflow-x: hidden;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
    width: 100%;
}

/* Typography */
.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-subtitle {
    display: inline-block;
    background: var(--primary-light);
    color: var(--primary);
    padding: 8px 20px;
    border-radius: 100px;
    font-size: clamp(12px, 2vw, 14px);
    font-weight: 600;
    margin-bottom: 15px;
}

.section-title {
    font-size: clamp(1.8rem, 5vw, 2.5rem);
    font-weight: 800;
    margin-bottom: 15px;
    color: var(--dark);
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
    display: flex;
    align-items: center;
    padding: 120px 0 80px;
    margin-top: -90px;
    overflow: hidden;
}

.hero-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(30px, 5vw, 60px);
    align-items: center;
    position: relative;
    z-index: 2;
    width: 100%;
}

.hero-content {
    color: white;
}

.hero-content h1 {
    font-size: clamp(2rem, 5vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 20px;
}

.hero-content p {
    font-size: clamp(1rem, 2vw, 1.2rem);
    margin-bottom: 40px;
    opacity: 0.9;
    max-width: 500px;
}

.hero-stats {
    display: flex;
    gap: clamp(20px, 4vw, 40px);
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: left;
}

.stat-number {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 800;
    display: block;
    color: white;
}

.stat-label {
    font-size: clamp(0.8rem, 1.5vw, 0.9rem);
    opacity: 0.8;
}

.hero-buttons {
    display: flex;
    gap: clamp(10px, 3vw, 20px);
    flex-wrap: wrap;
}

.btn-primary, .btn-outline {
    padding: clamp(12px, 2vw, 16px) clamp(20px, 4vw, 40px);
    border-radius: 50px;
    font-weight: 600;
    font-size: clamp(0.9rem, 1.5vw, 1.1rem);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
    white-space: nowrap;
}

.btn-primary {
    background: white;
    color: var(--primary);
}

.btn-outline {
    border: 2px solid white;
    color: white;
}

.btn-primary:hover, .btn-outline:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* Floating Hero Cards - Fixed */
.hero-image {
    position: relative;
    height: 500px;
    width: 100%;
}

.hero-image img {
    width: 100%;
    height: auto;
    border-radius: 30px;
    box-shadow: var(--shadow-lg);
    object-fit: cover;
}

.floating-card {
    position: absolute;
    background: white;
    padding: 15px 25px;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 15px;
    white-space: nowrap;
    animation: float 3s ease-in-out infinite;
    z-index: 10;
}

.floating-card-1 {
    top: 10%;
    left: -10%;
    animation-delay: 0s;
}

.floating-card-2 {
    bottom: 20%;
    right: -5%;
    animation-delay: 0.5s;
}

.floating-card-3 {
    top: 45%;
    left: -15%;
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.floating-card i {
    font-size: 2rem;
    color: var(--primary);
    min-width: 32px;
}

.floating-card-content h6 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
}

.floating-card-content p {
    font-size: 0.85rem;
    color: var(--gray);
    margin: 0;
}

/* Search Section */
.search-section {
    position: relative;
    z-index: 10;
    margin-top: -50px;
    margin-bottom: 60px;
}

.search-container {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    padding: clamp(20px, 4vw, 40px);
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 20px;
    width: 100%;
}

@media (max-width: 768px) {
    .search-container {
        grid-template-columns: 1fr;
    }
}

.search-box {
    position: relative;
    width: 100%;
}

.search-box i {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    z-index: 2;
}

.search-box input,
.search-box select {
    width: 100%;
    padding: 18px 18px 18px 50px;
    border: 2px solid var(--gray-light);
    border-radius: 15px;
    font-size: 1rem;
    background: white;
}

.search-btn {
    padding: 0 clamp(20px, 3vw, 40px);
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 15px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
    transition: var(--transition);
}

.search-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* Categories with Images */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-top: 40px;
}

.category-card {
    background: white;
    padding: 30px 20px;
    border-radius: 20px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-light);
    transition: var(--transition);
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.category-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-icon i {
    font-size: 2rem;
    color: var(--primary);
}

.category-card h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.category-card p {
    font-size: 0.9rem;
    color: var(--gray);
}

/* Service Cards - Fixed Layout */
.services-section {
    padding: 60px 0;
    background: var(--light);
}

.service-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.service-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.service-card:hover .service-image img {
    transform: scale(1.05);
}

.service-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--primary);
    color: white;
    padding: 5px 15px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
}

.service-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 8px;
    z-index: 2;
}

.service-wishlist {
    width: 35px;
    height: 35px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    font-size: 1rem;
}

.service-wishlist:hover {
    background: var(--danger);
    color: white;
}

.service-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.service-category {
    display: inline-block;
    padding: 4px 12px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 10px;
    width: fit-content;
}

.service-content h5 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
}

.service-content p {
    color: var(--gray);
    font-size: 0.9rem;
    margin-bottom: 15px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Star Ratings */
.service-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.stars {
    color: #ffb703;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
}

.stars i {
    margin-right: 2px;
}

.stars .far {
    color: #ddd;
}

.reviews {
    color: var(--gray);
    font-size: 0.8rem;
}

.service-provider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.provider-img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    background: #f0f0f0;
}

.provider-name {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--dark);
}

.service-price {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    padding-top: 10px;
    border-top: 1px solid var(--gray-light);
}

.price {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary);
}

.price small {
    font-size: 0.8rem;
    font-weight: 400;
    color: var(--gray);
    margin-left: 5px;
}

/* Fixed Button Layout - Cart button properly aligned */
.service-buttons {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: auto;
}

.book-btn {
    flex: 1;
    padding: 12px 16px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.book-btn:hover {
    background: var(--primary-dark);
}

.cart-btn {
    width: 45px;
    height: 45px;
    background: var(--light);
    border: 1px solid var(--gray-light);
    border-radius: 10px;
    color: var(--primary);
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.cart-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Swiper Styles */
.swiper {
    padding: 20px 10px 40px;
    overflow: hidden;
}

.swiper-slide {
    height: auto;
}

.swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: var(--primary);
    opacity: 0.3;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    width: 25px;
    border-radius: 5px;
}

.swiper-button-next,
.swiper-button-prev {
    width: 45px;
    height: 45px;
    background: white;
    border-radius: 50%;
    box-shadow: var(--shadow-md);
    color: var(--primary);
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 1.2rem;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    padding: clamp(60px, 10vw, 100px) 0;
    color: white;
    text-align: center;
}

.cta-content h2 {
    font-size: clamp(2rem, 5vw, 3rem);
    margin-bottom: 20px;
}

.cta-content p {
    font-size: clamp(1rem, 2vw, 1.2rem);
    margin-bottom: 30px;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    gap: clamp(10px, 3vw, 20px);
    justify-content: center;
    flex-wrap: wrap;
}

.cta-btn {
    padding: clamp(12px, 2vw, 16px) clamp(20px, 4vw, 40px);
    border-radius: 50px;
    font-weight: 600;
    font-size: clamp(0.9rem, 1.5vw, 1.1rem);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
}

.cta-btn-primary {
    background: white;
    color: var(--dark);
}

.cta-btn-outline {
    border: 2px solid white;
    color: white;
}

.cta-btn-primary:hover,
.cta-btn-outline:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* Responsive Design */
@media (max-width: 992px) {
    .hero-container {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-content p {
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-stats {
        justify-content: center;
    }
    
    .hero-buttons {
        justify-content: center;
    }
    
    .hero-image {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .floating-card {
        display: none;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 100px 0 60px;
    }
    
    .categories-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .service-buttons {
        flex-wrap: wrap;
    }
    
    .book-btn {
        flex: 1 1 auto;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        display: none;
    }
}

@media (max-width: 480px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }
    
    .hero-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-primary,
    .btn-outline {
        width: 100%;
        justify-content: center;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <h1>Professional Home Services At Your Doorstep</h1>
            <p>Book trusted experts for cleaning, plumbing, electrical repairs, and more. Quality service guaranteed.</p>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Happy Customers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Expert Pros</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Support</span>
                </div>
            </div>
            
            <div class="hero-buttons">
                <a href="#services" class="btn-primary">
                    Explore Services <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#" class="btn-outline">
                    <i class="fas fa-play"></i> Watch Demo
                </a>
            </div>
        </div>
        
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=600" alt="Professional Services">
            <div class="floating-card floating-card-1">
                <i class="fas fa-shield-alt"></i>
                <div class="floating-card-content">
                    <h6>100% Guarantee</h6>
                    <p>Satisfaction assured</p>
                </div>
            </div>
            <div class="floating-card floating-card-2">
                <i class="fas fa-headset"></i>
                <div class="floating-card-content">
                    <h6>24/7 Support</h6>
                    <p>Always here to help</p>
                </div>
            </div>
            <div class="floating-card floating-card-3">
                <i class="fas fa-bolt"></i>
                <div class="floating-card-content">
                    <h6>60 Min Response</h6>
                    <p>Quick service</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<div class="container search-section">
    <div class="search-container">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="What service do you need?">
        </div>
        <div class="search-box">
            <i class="fas fa-map-marker-alt"></i>
            <select>
                <option>Select Location</option>
                <option>New York</option>
                <option>Los Angeles</option>
                <option>Chicago</option>
                <option>Houston</option>
                <option>Miami</option>
            </select>
        </div>
        <button class="search-btn">
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>

<!-- Categories with Images -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Categories</span>
            <h2 class="section-title">Browse by Category</h2>
        </div>
        
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-icon">
                    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=100" alt="Cleaning">
                </div>
                <h4>Cleaning</h4>
                <p>128 services</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <img src="https://images.unsplash.com/photo-1504320995620-8ee6f2aac7e4?w=100" alt="Plumbing">
                </div>
                <h4>Plumbing</h4>
                <p>95 services</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=100" alt="Electrical">
                </div>
                <h4>Electrical</h4>
                <p>76 services</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=100" alt="Painting">
                </div>
                <h4>Painting</h4>
                <p>64 services</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <img src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=100" alt="Moving">
                </div>
                <h4>Moving</h4>
                <p>42 services</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <img src="https://images.unsplash.com/photo-1558002038-1055907df827?w=100" alt="Security">
                </div>
                <h4>Security</h4>
                <p>38 services</p>
            </div>
        </div>
    </div>
</section>

<!-- Most Booked Services -->
<section class="services-section" id="services">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Trending Now</span>
            <h2 class="section-title">Most Booked Services</h2>
        </div>

        <div class="swiper mostBookedSwiper">
            <div class="swiper-wrapper">
                <!-- Service 1 -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400" alt="Deep Cleaning">
                            <div class="service-badge">Trending</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-broom"></i> Cleaning</span>
                            <h5>Deep Cleaning Service</h5>
                            <p>Complete home deep cleaning with professional equipment and eco-friendly products.</p>
                            
                            <div class="service-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="reviews">(4.5 · 245 reviews)</span>
                            </div>
                            
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">CleanPro Services</span>
                            </div>
                            
                            <div class="service-price">
                                <span class="price">$79 <small>/ session</small></span>
                            </div>
                            
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1504320995620-8ee6f2aac7e4?w=400" alt="Plumbing">
                            <div class="service-badge">Popular</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-wrench"></i> Plumbing</span>
                            <h5>Emergency Plumbing</h5>
                            <p>24/7 emergency plumbing services for leaks, clogs, and pipe repairs.</p>
                            
                            <div class="service-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="reviews">(5.0 · 189 reviews)</span>
                            </div>
                            
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">QuickFix Plumbing</span>
                            </div>
                            
                            <div class="service-price">
                                <span class="price">$89 <small>/ hour</small></span>
                            </div>
                            
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=400" alt="Electrical">
                            <div class="service-badge">Trending</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-bolt"></i> Electrical</span>
                            <h5>Electrical Repairs</h5>
                            <p>Licensed electricians for wiring, fixture installation, and troubleshooting.</p>
                            
                            <div class="service-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="reviews">(4.7 · 156 reviews)</span>
                            </div>
                            
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">Spark Electrical</span>
                            </div>
                            
                            <div class="service-price">
                                <span class="price">$75 <small>/ hour</small></span>
                            </div>
                            
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=400" alt="Painting">
                            <div class="service-badge">New</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-paint-roller"></i> Painting</span>
                            <h5>Interior Painting</h5>
                            <p>Professional interior painting with premium paints and clean finish.</p>
                            
                            <div class="service-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                </div>
                                <span class="reviews">(4.0 · 78 reviews)</span>
                            </div>
                            
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">ColorMaster</span>
                            </div>
                            
                            <div class="service-price">
                                <span class="price">$299 <small>/ room</small></span>
                            </div>
                            
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=400" alt="Moving">
                            <div class="service-badge">Popular</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-truck"></i> Moving</span>
                            <h5>Local Moving</h5>
                            <p>Professional moving services with trucks and trained movers.</p>
                            
                            <div class="service-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="reviews">(4.6 · 134 reviews)</span>
                            </div>
                            
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/4.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">EasyMove</span>
                            </div>
                            
                            <div class="service-price">
                                <span class="price">$149 <small>/ hour</small></span>
                            </div>
                            
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1558002038-1055907df827?w=400" alt="Security">
                            <div class="service-badge">Trending</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-shield-alt"></i> Security</span>
                            <h5>Camera Installation</h5>
                            <p>Professional CCTV and security camera installation for homes.</p>
                            
                            <div class="service-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="reviews">(5.0 · 92 reviews)</span>
                            </div>
                            
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">SecureTech</span>
                            </div>
                            
                            <div class="service-price">
                                <span class="price">$199 <small>/ install</small></span>
                            </div>
                            
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- Popular Services -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Top Rated</span>
            <h2 class="section-title">Popular Services</h2>
        </div>

        <div class="swiper popularSwiper">
            <div class="swiper-wrapper">
                <!-- Similar structure with different services -->
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1631545804402-7d8b3e3f9b9f?w=400" alt="AC Repair">
                            <div class="service-badge">Top Rated</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-wind"></i> HVAC</span>
                            <h5>AC Service & Repair</h5>
                            <p>Expert AC repair, maintenance, and installation services.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span class="reviews">(5.0 · 312 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/5.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">CoolTech HVAC</span>
                            </div>
                            <div class="service-price"><span class="price">$89 <small>/ visit</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=400" alt="Carpentry">
                            <div class="service-badge">Popular</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-hammer"></i> Carpentry</span>
                            <h5>Custom Furniture</h5>
                            <p>Custom furniture making and repair services.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                                <span class="reviews">(4.8 · 67 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/6.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">WoodCraft</span>
                            </div>
                            <div class="service-price"><span class="price">$129 <small>/ hour</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1584483766114-2cea6facdf57?w=400" alt="Pest Control">
                            <div class="service-badge">Top Rated</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-bug"></i> Pest Control</span>
                            <h5>Home Pest Control</h5>
                            <p>Complete pest control treatment for homes.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span class="reviews">(4.9 · 203 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/7.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">PestFree</span>
                            </div>
                            <div class="service-price"><span class="price">$149 <small>/ treatment</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1527576539890-dfa815648363?w=400" alt="Gardening">
                            <div class="service-badge">New</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-leaf"></i> Gardening</span>
                            <h5>Garden Maintenance</h5>
                            <p>Professional gardening and lawn care services.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                                <span class="reviews">(4.7 · 156 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">GreenThumb</span>
                            </div>
                            <div class="service-price"><span class="price">$59 <small>/ hour</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- Recommended Services -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">For You</span>
            <h2 class="section-title">Recommended Services</h2>
        </div>

        <div class="swiper recommendedSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1605000797499-95a51c5269ae?w=400" alt="Carpet Cleaning">
                            <div class="service-badge">Recommended</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-couch"></i> Cleaning</span>
                            <h5>Carpet Cleaning</h5>
                            <p>Deep carpet cleaning with steam and eco-friendly products.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>
                                <span class="reviews">(4.2 · 89 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">CarpetCare</span>
                            </div>
                            <div class="service-price"><span class="price">$99 <small>/ room</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1621786030484-4c855eed6974?w=400" alt="Appliance Repair">
                            <div class="service-badge">Popular</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-tools"></i> Repair</span>
                            <h5>Appliance Repair</h5>
                            <p>Expert repair for all home appliances.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span class="reviews">(5.0 · 178 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/8.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">ApplianceMaster</span>
                            </div>
                            <div class="service-price"><span class="price">$69 <small>/ diagnostic</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card">
                        <div class="service-image">
                            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=400" alt="Home Renovation">
                            <div class="service-badge">New</div>
                            <div class="service-actions">
                                <button class="service-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="service-content">
                            <span class="service-category"><i class="fas fa-home"></i> Renovation</span>
                            <h5>Home Renovation</h5>
                            <p>Complete home renovation and remodeling services.</p>
                            <div class="service-rating">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                                <span class="reviews">(4.8 · 45 reviews)</span>
                            </div>
                            <div class="service-provider">
                                <img src="https://randomuser.me/api/portraits/men/9.jpg" alt="Provider" class="provider-img">
                                <span class="provider-name">RenovatePro</span>
                            </div>
                            <div class="service-price"><span class="price">$499 <small>/ day</small></span></div>
                            <div class="service-buttons">
                                <a href="services.php" class="book-btn">Book Now</a>
                                <button class="cart-btn" onclick="window.location.href='cart.php'"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Get Started?</h2>
            <p>Join thousands of satisfied customers who trust us for their home service needs. Book your first service today and get 20% off!</p>
            <div class="cta-buttons">
                <a href="services.php" class="cta-btn cta-btn-primary">
                    Book a Service <i class="fas fa-arrow-right"></i>
                </a>
                <a href="contact.php" class="cta-btn cta-btn-outline">
                    Contact Us <i class="fas fa-phone"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Most Booked Swiper
    new Swiper(".mostBookedSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: { delay: 3000, disableOnInteraction: false },
        loop: true,
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        breakpoints: {
            576: { slidesPerView: 2 },
            992: { slidesPerView: 3 }
        }
    });

    // Popular Services Swiper
    new Swiper(".popularSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: { delay: 3500, disableOnInteraction: false },
        loop: true,
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        breakpoints: {
            576: { slidesPerView: 2 },
            992: { slidesPerView: 3 }
        }
    });

    // Recommended Swiper
    new Swiper(".recommendedSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: { delay: 4000, disableOnInteraction: false },
        loop: true,
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        breakpoints: {
            576: { slidesPerView: 2 },
            992: { slidesPerView: 3 }
        }
    });

    // Wishlist functionality
    document.querySelectorAll('.service-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            icon.style.color = icon.classList.contains('fas') ? '#ef4444' : '';
        });
    });

    // Navbar scroll effect
    const navbar = document.getElementById('mainNavbar');
    if(navbar) {
        window.addEventListener('scroll', function() {
            if(window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
});
</script>

<?php include("footer.php"); ?>