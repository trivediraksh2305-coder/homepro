<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("header.php");
?>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ========== GLOBAL STYLES & VARIABLES ========== */
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
    --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
    --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.25);
    --gradient-primary: linear-gradient(135deg, #4361ee, #7209b7);
    --gradient-accent: linear-gradient(135deg, #f72585, #7209b7);
    --gradient-dark: linear-gradient(135deg, #1e293b, #0f172a);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: #ffffff;
    color: var(--dark);
    line-height: 1.6;
    overflow-x: hidden;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ========== TYPOGRAPHY ========== */
h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    line-height: 1.2;
}

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
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 15px;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-description {
    color: var(--gray);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

/* ========== PAGE HEADER ========== */
.page-header {
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.97) 0%, rgba(114, 9, 183, 0.97) 100%);
    padding: 120px 0 80px;
    margin-top: -90px;
    position: relative;
    overflow: hidden;
    text-align: center;
    color: white;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M30 0L60 30L30 60L0 30L30 0Z" fill="rgba(255,255,255,0.03)"/></svg>');
    opacity: 0.1;
    animation: patternMove 20s linear infinite;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    height: 100px;
    background: white;
    transform: skewY(-2deg);
    z-index: 2;
}

.page-header-content {
    position: relative;
    z-index: 3;
    max-width: 800px;
    margin: 0 auto;
}

.page-header h1 {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 20px;
    animation: fadeInUp 1s ease-out;
}

.page-header p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    animation: fadeInUp 1s ease-out 0.2s both;
}

.breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 10px 25px;
    border-radius: 50px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: fadeInUp 1s ease-out;
}

.breadcrumb a {
    color: white;
    text-decoration: none;
    font-size: 0.95rem;
    transition: var(--transition);
}

.breadcrumb a:hover {
    color: var(--accent);
}

.breadcrumb i {
    font-size: 0.8rem;
    opacity: 0.7;
}

.breadcrumb span {
    color: white;
    font-weight: 600;
}

/* ========== ABOUT SECTION ========== */
.about-section {
    padding: 100px 0;
    background: white;
}

.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.about-content {
    animation: fadeInLeft 1s ease-out;
}

.about-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--primary-light);
    color: var(--primary);
    padding: 8px 20px;
    border-radius: 100px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
}

.about-content h2 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: var(--dark);
}

.about-content h2 span {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.about-content p {
    color: var(--gray);
    font-size: 1.1rem;
    margin-bottom: 20px;
    line-height: 1.8;
}

.about-features {
    margin: 40px 0;
}

.about-feature {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.about-feature:hover .feature-icon {
    background: var(--gradient-primary);
}

.feature-icon i {
    font-size: 1.5rem;
    color: var(--primary);
    transition: var(--transition);
}

.about-feature:hover .feature-icon i {
    color: white;
}

.feature-text h4 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: var(--dark);
}

.feature-text p {
    color: var(--gray);
    font-size: 0.95rem;
    margin: 0;
}

.about-image {
    position: relative;
    animation: fadeInRight 1s ease-out;
}

.about-image img {
    width: 100%;
    height: auto;
    border-radius: 30px;
    box-shadow: var(--shadow-xl);
    position: relative;
    z-index: 2;
}

.about-image::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 20px;
    right: -20px;
    bottom: -20px;
    background: var(--gradient-primary);
    border-radius: 30px;
    opacity: 0.1;
    z-index: 1;
}

.experience-badge {
    position: absolute;
    bottom: 30px;
    right: -20px;
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
    text-align: center;
    z-index: 3;
    animation: float 3s ease-in-out infinite;
}

.experience-badge h3 {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 5px;
}

.experience-badge p {
    color: var(--gray);
    font-size: 0.9rem;
    margin: 0;
}

/* ========== MISSION VISION SECTION ========== */
.mission-vision-section {
    padding: 80px 0;
    background: var(--light);
}

.mission-vision-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.mission-card,
.vision-card {
    background: white;
    padding: 50px 40px;
    border-radius: 30px;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.mission-card:hover,
.vision-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
}

.mission-card::before,
.vision-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--gradient-primary);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.mission-card:hover::before,
.vision-card:hover::before {
    transform: scaleX(1);
}

.card-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-light);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
}

.card-icon i {
    font-size: 2.5rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.mission-card h3,
.vision-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--dark);
}

.mission-card p,
.vision-card p {
    color: var(--gray);
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 25px;
}

.card-list {
    list-style: none;
}

.card-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    color: var(--gray);
}

.card-list li i {
    color: var(--success);
    font-size: 1.1rem;
}

/* ========== STATS SECTION ========== */
.stats-section {
    padding: 80px 0;
    background: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.stat-card {
    text-align: center;
    padding: 40px 30px;
    background: var(--light);
    border-radius: 20px;
    transition: var(--transition);
    border: 1px solid var(--gray-light);
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-lg);
    background: white;
    border-color: var(--primary);
}

.stat-icon {
    width: 70px;
    height: 70px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    transition: var(--transition);
}

.stat-card:hover .stat-icon {
    background: var(--gradient-primary);
}

.stat-icon i {
    font-size: 2rem;
    color: var(--primary);
    transition: var(--transition);
}

.stat-card:hover .stat-icon i {
    color: white;
}

.stat-number {
    font-size: 2.8rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 10px;
    display: block;
}

.stat-label {
    color: var(--gray);
    font-size: 1rem;
    font-weight: 500;
}

/* ========== TEAM SECTION ========== */
.team-section {
    padding: 100px 0;
    background: var(--light);
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    margin-top: 50px;
}

.team-card {
    background: white;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    position: relative;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
}

.team-image {
    position: relative;
    overflow: hidden;
    height: 300px;
}

.team-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.team-card:hover .team-image img {
    transform: scale(1.1);
}

.team-social {
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    transition: bottom 0.3s ease;
}

.team-card:hover .team-social {
    bottom: 0;
}

.team-social a {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    text-decoration: none;
    transition: var(--transition);
}

.team-social a:hover {
    background: var(--gradient-primary);
    color: white;
    transform: translateY(-3px);
}

.team-info {
    padding: 25px;
    text-align: center;
}

.team-info h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: var(--dark);
}

.team-info p {
    color: var(--gray);
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.team-rating {
    color: #ffb703;
    font-size: 0.9rem;
}

/* ========== VALUES SECTION ========== */
.values-section {
    padding: 100px 0;
    background: white;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 50px;
}

.value-card {
    text-align: center;
    padding: 50px 30px;
    background: var(--light);
    border-radius: 30px;
    transition: var(--transition);
    border: 1px solid var(--gray-light);
    position: relative;
    overflow: hidden;
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
    background: white;
    border-color: var(--primary);
}

.value-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.value-card:hover::before {
    transform: scaleX(1);
}

.value-icon {
    width: 90px;
    height: 90px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    transition: var(--transition);
}

.value-card:hover .value-icon {
    background: var(--gradient-primary);
}

.value-icon i {
    font-size: 2.5rem;
    color: var(--primary);
    transition: var(--transition);
}

.value-card:hover .value-icon i {
    color: white;
}

.value-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--dark);
}

.value-card p {
    color: var(--gray);
    font-size: 1rem;
    line-height: 1.8;
    margin: 0;
}

/* ========== TESTIMONIALS SECTION ========== */
.testimonials-section {
    padding: 100px 0;
    background: var(--light);
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 50px;
}

.testimonial-card {
    background: white;
    padding: 40px;
    border-radius: 30px;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    position: relative;
}

.testimonial-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
}

.testimonial-card::before {
    content: '"';
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 8rem;
    font-family: serif;
    color: var(--primary-light);
    line-height: 1;
    opacity: 0.5;
}

.testimonial-rating {
    color: #ffb703;
    font-size: 1.1rem;
    margin-bottom: 20px;
}

.testimonial-text {
    font-size: 1rem;
    line-height: 1.8;
    color: var(--dark);
    margin-bottom: 25px;
    font-style: italic;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 15px;
}

.author-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.author-info h6 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 5px;
}

.author-info p {
    color: var(--gray);
    font-size: 0.9rem;
    margin: 0;
}

/* ========== CTA SECTION ========== */
.cta-section {
    padding: 100px 0;
    background: var(--gradient-dark);
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M30 0L60 30L30 60L0 30L30 0Z" fill="rgba(255,255,255,0.03)"/></svg>');
    opacity: 0.1;
}

.cta-content {
    text-align: center;
    color: white;
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.cta-content h2 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 20px;
}

.cta-content p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 40px;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.btn-primary {
    padding: 18px 45px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    background: white;
    color: var(--dark);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-outline {
    padding: 18px 45px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    border: 2px solid white;
    background: transparent;
    color: white;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary:hover,
.btn-outline:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn-primary:hover {
    background: var(--primary);
    color: white;
}

.btn-outline:hover {
    background: white;
    color: var(--primary);
}

/* ========== ANIMATIONS ========== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes patternMove {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 60px 60px;
    }
}

/* ========== RESPONSIVE DESIGN ========== */
@media (max-width: 1200px) {
    .team-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .testimonials-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 992px) {
    .page-header h1 {
        font-size: 3rem;
    }
    
    .about-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .mission-vision-grid {
        grid-template-columns: 1fr;
    }
    
    .about-image {
        order: -1;
    }
    
    .experience-badge {
        right: 20px;
    }
    
    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 100px 0 60px;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
    }
    
    .about-content h2 {
        font-size: 2.2rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-content h2 {
        font-size: 2.2rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    .btn-primary,
    .btn-outline {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .about-content h2 {
        font-size: 1.8rem;
    }
    
    .experience-badge {
        position: static;
        margin-top: 20px;
    }
    
    .mission-card,
    .vision-card {
        padding: 30px 20px;
    }
    
    .card-icon {
        width: 60px;
        height: 60px;
    }
    
    .card-icon i {
        font-size: 2rem;
    }
}
</style>

<!-- ========== PAGE HEADER ========== -->
<section class="page-header">
    <div class="page-header-content">
        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>About Us</span>
        </div>
        <h1>About HomePro</h1>
        <p>Your trusted partner for professional home services since 2015</p>
    </div>
</section>

<!-- ========== ABOUT SECTION ========== -->
<section class="about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <div class="about-badge">
                    <i class="fas fa-home"></i>
                    <span>Who We Are</span>
                </div>
                <h2>We're <span>Revolutionizing</span> Home Services</h2>
                <p>HomePro is a leading platform that connects homeowners with trusted, verified professionals for all their home service needs. Founded in 2015, we've helped over 50,000 customers with quality home services ranging from cleaning and plumbing to electrical work and renovations.</p>
                <p>Our mission is to make home maintenance stress-free and reliable. We carefully screen every professional on our platform, ensuring they have the right skills, licenses, and experience to deliver exceptional service.</p>
                
                <div class="about-features">
                    <div class="about-feature">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>100% Verified Professionals</h4>
                            <p>Every expert undergoes thorough background checks and skill verification</p>
                        </div>
                    </div>
                    
                    <div class="about-feature">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Quick & Reliable Service</h4>
                            <p>Average response time under 60 minutes for urgent requests</p>
                        </div>
                    </div>
                    
                    <div class="about-feature">
                        <div class="feature-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Best Price Guarantee</h4>
                            <p>Transparent pricing with no hidden costs or surprises</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="about-image">
                <img src="../assets/about-team.jpg" alt="Our Team" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'">
                <div class="experience-badge">
                    <h3>10+</h3>
                    <p>Years of Experience</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== MISSION & VISION SECTION ========== -->
<section class="mission-vision-section">
    <div class="container">
        <div class="mission-vision-grid">
            <div class="mission-card">
                <div class="card-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Our Mission</h3>
                <p>To provide homeowners with reliable, high-quality home services through a platform that ensures trust, transparency, and convenience. We aim to take the stress out of home maintenance by connecting customers with the best professionals in their area.</p>
                <ul class="card-list">
                    <li><i class="fas fa-check-circle"></i> Quality service guaranteed</li>
                    <li><i class="fas fa-check-circle"></i> Fair and transparent pricing</li>
                    <li><i class="fas fa-check-circle"></i> Customer satisfaction first</li>
                    <li><i class="fas fa-check-circle"></i> Continuous improvement</li>
                </ul>
            </div>
            
            <div class="vision-card">
                <div class="card-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Our Vision</h3>
                <p>To become the most trusted and comprehensive home services platform, creating a world where homeowners can easily find, book, and manage all their home maintenance needs through a single, reliable platform.</p>
                <ul class="card-list">
                    <li><i class="fas fa-check-circle"></i> Nationwide coverage</li>
                    <li><i class="fas fa-check-circle"></i> 100+ service categories</li>
                    <li><i class="fas fa-check-circle"></i> Industry-leading standards</li>
                    <li><i class="fas fa-check-circle"></i> Community of experts</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ========== STATS SECTION ========== -->
<section class="stats-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Our Impact</span>
            <h2 class="section-title">By The Numbers</h2>
            <p class="section-description">We're proud of what we've achieved together with our customers and professionals</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <span class="stat-number">50K+</span>
                <span class="stat-label">Happy Customers</span>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <span class="stat-number">500+</span>
                <span class="stat-label">Expert Partners</span>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <span class="stat-number">100K+</span>
                <span class="stat-label">Jobs Completed</span>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <span class="stat-number">4.9</span>
                <span class="stat-label">Average Rating</span>
            </div>
        </div>
    </div>
</section>

<!-- ========== VALUES SECTION ========== -->
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Our Core Values</span>
            <h2 class="section-title">What Drives Us</h2>
            <p class="section-description">The principles that guide everything we do</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3>Trust & Integrity</h3>
                <p>We believe in honest, transparent relationships with both our customers and service professionals. Trust is the foundation of everything we do.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3>Excellence</h3>
                <p>We never compromise on quality. Every service professional on our platform meets our high standards for skills and professionalism.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Customer First</h3>
                <p>Our customers are at the heart of our business. We listen, we care, and we continuously improve based on their feedback.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Innovation</h3>
                <p>We constantly explore new ways to make home services more accessible, convenient, and reliable through technology.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Partnership</h3>
                <p>We build lasting relationships with our service professionals, helping them grow their businesses while serving customers.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Sustainability</h3>
                <p>We promote eco-friendly practices and encourage sustainable solutions in all home services we offer.</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== TEAM SECTION ========== -->
<section class="team-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Leadership Team</span>
            <h2 class="section-title">Meet Our Leaders</h2>
            <p class="section-description">Experienced professionals dedicated to your satisfaction</p>
        </div>
        
        <div class="team-grid">
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="John Smith">
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h4>John Smith</h4>
                    <p>CEO & Founder</p>
                    <div class="team-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=688&q=80" alt="Sarah Johnson">
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h4>Sarah Johnson</h4>
                    <p>Operations Director</p>
                    <div class="team-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Michael Chen">
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h4>Michael Chen</h4>
                    <p>Technology Head</p>
                    <div class="team-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=761&q=80" alt="Emily Rodriguez">
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h4>Emily Rodriguez</h4>
                    <p>Customer Experience</p>
                    <div class="team-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== TESTIMONIALS SECTION ========== -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Testimonials</span>
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-description">Real feedback from real customers</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"HomePro has been a game-changer for our home maintenance. The plumber they sent was professional, skilled, and fixed the issue quickly. Highly recommended!"</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Robert Brown" class="author-img">
                    <div class="author-info">
                        <h6>Robert Brown</h6>
                        <p>Homeowner</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"I've used HomePro for cleaning, electrical work, and painting. Every professional has been excellent. The platform makes booking so easy and stress-free."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=688&q=80" alt="Lisa Thompson" class="author-img">
                    <div class="author-info">
                        <h6>Lisa Thompson</h6>
                        <p>Regular Customer</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"As a busy professional, HomePro saves me so much time. I can book trusted services with confidence. The customer support is also top-notch!"</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="David Kim" class="author-img">
                    <div class="author-info">
                        <h6>David Kim</h6>
                        <p>Satisfied Client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA SECTION ========== -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Experience the HomePro Difference?</h2>
            <p>Join thousands of satisfied customers who trust us for their home service needs. Book your first service today and get 20% off!</p>
            <div class="cta-buttons">
                <a href="services.php" class="btn-primary">
                    Explore Services <i class="fas fa-arrow-right"></i>
                </a>
                <a href="contact.php" class="btn-outline">
                    Contact Us <i class="fas fa-phone"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<?php include("footer.php"); ?>