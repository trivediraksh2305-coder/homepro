<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("header.php");

// Handle form submission
$success_message = '';
$error_message = '';

if(isset($_POST['submit_contact'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Here you would typically insert into database or send email
    // For now, we'll just show a success message
    $success_message = "Thank you for contacting us! We'll get back to you within 24 hours.";
}
?>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

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

/* ========== CONTACT INFO CARDS ========== */
.contact-info-section {
    padding: 80px 0 40px;
    background: white;
}

.contact-info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.contact-info-card {
    background: var(--light);
    padding: 40px 30px;
    border-radius: 20px;
    text-align: center;
    transition: var(--transition);
    border: 1px solid var(--gray-light);
    position: relative;
    overflow: hidden;
}

.contact-info-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
    background: white;
    border-color: var(--primary);
}

.contact-info-card::before {
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

.contact-info-card:hover::before {
    transform: scaleX(1);
}

.info-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    transition: var(--transition);
}

.contact-info-card:hover .info-icon {
    background: var(--gradient-primary);
}

.info-icon i {
    font-size: 2rem;
    color: var(--primary);
    transition: var(--transition);
}

.contact-info-card:hover .info-icon i {
    color: white;
}

.contact-info-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--dark);
}

.contact-info-card p {
    color: var(--gray);
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
}

.contact-info-card .contact-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
    margin-top: 15px;
    transition: var(--transition);
}

.contact-info-card .contact-link:hover {
    color: var(--secondary);
    transform: translateX(5px);
}

/* ========== CONTACT FORM SECTION ========== */
.contact-form-section {
    padding: 60px 0 100px;
    background: white;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    background: white;
    border-radius: 30px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
}

.contact-form-wrapper {
    padding: 60px 50px;
}

.contact-form-wrapper h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--dark);
}

.contact-form-wrapper p {
    color: var(--gray);
    margin-bottom: 30px;
}

.contact-form {
    display: grid;
    gap: 25px;
}

.form-group {
    position: relative;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--dark);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid var(--gray-light);
    border-radius: 15px;
    font-size: 1rem;
    transition: var(--transition);
    background: var(--light);
    font-family: 'Inter', sans-serif;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    background: white;
}

.form-group textarea {
    resize: vertical;
    min-height: 150px;
}

.form-group .input-icon {
    position: absolute;
    right: 20px;
    top: 52px;
    color: var(--gray);
    transition: var(--transition);
}

.form-group input:focus + .input-icon,
.form-group select:focus + .input-icon,
.form-group textarea:focus + .input-icon {
    color: var(--primary);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.submit-btn {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 18px 40px;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    margin-top: 10px;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.submit-btn i {
    transition: var(--transition);
}

.submit-btn:hover i {
    transform: translateX(5px);
}

/* ========== MAP SECTION ========== */
.map-section {
    padding: 60px 0;
    background: var(--light);
}

.map-container {
    height: 450px;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    position: relative;
}

#map {
    width: 100%;
    height: 100%;
}

.map-overlay {
    position: absolute;
    top: 30px;
    left: 30px;
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    max-width: 300px;
    z-index: 10;
}

.map-overlay h4 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--dark);
}

.map-overlay p {
    color: var(--gray);
    font-size: 0.95rem;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.map-overlay p i {
    color: var(--primary);
    width: 20px;
}

/* ========== FAQ SECTION ========== */
.faq-section {
    padding: 80px 0;
    background: white;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 50px;
}

.faq-item {
    background: var(--light);
    padding: 30px;
    border-radius: 20px;
    transition: var(--transition);
    border: 1px solid var(--gray-light);
    cursor: pointer;
}

.faq-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    background: white;
    border-color: var(--primary);
}

.faq-question {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.faq-question i {
    width: 30px;
    height: 30px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 0.9rem;
    transition: var(--transition);
}

.faq-item:hover .faq-question i {
    background: var(--gradient-primary);
    color: white;
}

.faq-question h4 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
}

.faq-answer {
    color: var(--gray);
    font-size: 0.95rem;
    line-height: 1.7;
    margin-left: 45px;
}

/* ========== BUSINESS HOURS SECTION ========== */
.hours-section {
    padding: 60px 0;
    background: var(--light);
}

.hours-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.hours-card {
    background: white;
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
}

.hours-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
}

.hours-icon {
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

.hours-card:hover .hours-icon {
    background: var(--gradient-primary);
}

.hours-icon i {
    font-size: 2rem;
    color: var(--primary);
    transition: var(--transition);
}

.hours-card:hover .hours-icon i {
    color: white;
}

.hours-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--dark);
}

.hours-list {
    list-style: none;
    text-align: left;
}

.hours-list li {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--gray-light);
    color: var(--gray);
}

.hours-list li:last-child {
    border-bottom: none;
}

.hours-list li span {
    font-weight: 600;
    color: var(--dark);
}

.hours-note {
    margin-top: 20px;
    padding: 15px;
    background: var(--primary-light);
    border-radius: 10px;
    color: var(--primary);
    font-size: 0.9rem;
    font-weight: 500;
}

/* ========== SOCIAL SECTION ========== */
.social-section {
    padding: 60px 0;
    background: white;
    text-align: center;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

.social-link {
    width: 60px;
    height: 60px;
    background: var(--light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.5rem;
    text-decoration: none;
    transition: var(--transition);
    border: 1px solid var(--gray-light);
}

.social-link:hover {
    background: var(--gradient-primary);
    color: white;
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: transparent;
}

/* ========== ALERT MESSAGES ========== */
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideInDown 0.5s ease;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left: 4px solid var(--success);
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid var(--danger);
}

.alert i {
    font-size: 1.2rem;
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

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
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
    .contact-info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .hours-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 992px) {
    .page-header h1 {
        font-size: 3rem;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
    }
    
    .contact-form-wrapper {
        padding: 40px 30px;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 100px 0 60px;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
    }
    
    .contact-info-grid {
        grid-template-columns: 1fr;
    }
    
    .hours-grid {
        grid-template-columns: 1fr;
    }
    
    .map-overlay {
        position: static;
        max-width: 100%;
        margin-bottom: 20px;
    }
    
    .social-links {
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .contact-form-wrapper {
        padding: 30px 20px;
    }
    
    .contact-form-wrapper h2 {
        font-size: 1.8rem;
    }
    
    .faq-item {
        padding: 20px;
    }
    
    .faq-question h4 {
        font-size: 1.1rem;
    }
}
</style>

<!-- ========== PAGE HEADER ========== -->
<section class="page-header">
    <div class="page-header-content">
        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Contact Us</span>
        </div>
        <h1>Get In Touch</h1>
        <p>We're here to help with any questions or concerns you may have</p>
    </div>
</section>

<!-- ========== CONTACT INFO CARDS ========== -->
<section class="contact-info-section">
    <div class="container">
        <div class="contact-info-grid">
            <div class="contact-info-card">
                <div class="info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Call Us</h3>
                <p>Available 24/7 for urgent needs</p>
                <p><strong>+1 (800) 123-4567</strong></p>
                <a href="tel:+18001234567" class="contact-link">
                    Call Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="contact-info-card">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <p>We'll respond within 24 hours</p>
                <p><strong>support@homepro.com</strong></p>
                <a href="mailto:support@homepro.com" class="contact-link">
                    Send Email <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="contact-info-card">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <p>123 Business Avenue, Suite 100</p>
                <p><strong>New York, NY 10001</strong></p>
                <a href="#map" class="contact-link">
                    Get Directions <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="contact-info-card">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Live Chat</h3>
                <p>Instant support online</p>
                <p><strong>Average response: 2 min</strong></p>
                <a href="#" class="contact-link">
                    Start Chat <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ========== CONTACT FORM SECTION ========== -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-form-wrapper">
                <h2>Send Us a Message</h2>
                <p>Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                
                <?php if($success_message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if($error_message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Your Name *</label>
                            <input type="text" name="name" required placeholder="John Doe">
                            <i class="fas fa-user input-icon"></i>
                        </div>
                        
                        <div class="form-group">
                            <label>Your Email *</label>
                            <input type="email" name="email" required placeholder="john@example.com">
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="+1 (555) 000-0000">
                            <i class="fas fa-phone input-icon"></i>
                        </div>
                        
                        <div class="form-group">
                            <label>Subject *</label>
                            <select name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Customer Support</option>
                                <option value="booking">Booking Issue</option>
                                <option value="billing">Billing Question</option>
                                <option value="feedback">Feedback</option>
                                <option value="partnership">Partnership</option>
                            </select>
                            <i class="fas fa-chevron-down input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Your Message *</label>
                        <textarea name="message" required placeholder="How can we help you?"></textarea>
                        <i class="fas fa-comment input-icon"></i>
                    </div>
                    
                    <button type="submit" name="submit_contact" class="submit-btn">
                        Send Message <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            
            <div style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); padding: 60px 40px; display: flex; align-items: center;">
                <div style="width: 100%;">
                    <div style="margin-bottom: 40px;">
                        <span style="display: inline-block; padding: 8px 16px; background: var(--primary-light); color: var(--primary); border-radius: 100px; font-size: 0.9rem; font-weight: 600; margin-bottom: 20px;">
                            <i class="fas fa-comment-dots"></i> Why Choose Us
                        </span>
                        <h3 style="font-size: 2rem; font-weight: 700; color: var(--dark); margin-bottom: 20px;">We're Here to Help</h3>
                        <p style="color: var(--gray); line-height: 1.8; margin-bottom: 30px;">Our dedicated customer support team is available 24/7 to assist you with any questions or concerns. We pride ourselves on quick response times and helpful, friendly service.</p>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 50px; height: 50px; background: var(--primary-light); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bolt" style="color: var(--primary); font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-weight: 600; color: var(--dark); margin-bottom: 5px;">Lightning Fast Response</h4>
                                <p style="color: var(--gray); font-size: 0.95rem; margin: 0;">Average response time under 2 hours</p>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 50px; height: 50px; background: var(--primary-light); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-headset" style="color: var(--primary); font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-weight: 600; color: var(--dark); margin-bottom: 5px;">Dedicated Support Team</h4>
                                <p style="color: var(--gray); font-size: 0.95rem; margin: 0;">Real people, real solutions, 24/7</p>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 50px; height: 50px; background: var(--primary-light); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: var(--primary); font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-weight: 600; color: var(--dark); margin-bottom: 5px;">Issue Resolution Guarantee</h4>
                                <p style="color: var(--gray); font-size: 0.95rem; margin: 0;">We don't stop until you're satisfied</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 40px; padding: 25px; background: white; border-radius: 20px; box-shadow: var(--shadow-md);">
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Support" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <p style="color: var(--gray); font-style: italic; margin-bottom: 5px;">"We're committed to providing the best support experience. Your satisfaction is our priority."</p>
                                <strong style="color: var(--dark);">- Sarah, Support Lead</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== MAP SECTION ========== -->
<section class="map-section" id="map">
    <div class="container">
        <div class="map-container">
            <div class="map-overlay">
                <h4><i class="fas fa-map-pin" style="color: var(--primary); margin-right: 10px;"></i> Our Headquarters</h4>
                <p><i class="fas fa-building"></i> HomePro Inc.</p>
                <p><i class="fas fa-map-marker-alt"></i> 123 Business Avenue, Suite 100</p>
                <p><i class="fas fa-city"></i> New York, NY 10001</p>
                <p><i class="fas fa-globe"></i> United States</p>
                <hr style="margin: 15px 0; border-color: var(--gray-light);">
                <p><i class="fas fa-phone"></i> +1 (800) 123-4567</p>
                <p><i class="fas fa-envelope"></i> office@homepro.com</p>
                <a href="#" style="display: inline-block; margin-top: 15px; color: var(--primary); font-weight: 600; text-decoration: none;">
                    Get Directions <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <!-- Google Map will be initialized here -->
            <div id="map" style="width: 100%; height: 100%;"></div>
        </div>
    </div>
</section>

<!-- ========== BUSINESS HOURS SECTION ========== -->
<section class="hours-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Business Hours</span>
            <h2 class="section-title">When We're Available</h2>
            <p class="section-description">We're here to serve you seven days a week</p>
        </div>
        
        <div class="hours-grid">
            <div class="hours-card">
                <div class="hours-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <h3>Weekdays</h3>
                <ul class="hours-list">
                    <li>Monday <span>8:00 AM - 8:00 PM</span></li>
                    <li>Tuesday <span>8:00 AM - 8:00 PM</span></li>
                    <li>Wednesday <span>8:00 AM - 8:00 PM</span></li>
                    <li>Thursday <span>8:00 AM - 8:00 PM</span></li>
                    <li>Friday <span>8:00 AM - 8:00 PM</span></li>
                </ul>
            </div>
            
            <div class="hours-card">
                <div class="hours-icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <h3>Weekends</h3>
                <ul class="hours-list">
                    <li>Saturday <span>9:00 AM - 6:00 PM</span></li>
                    <li>Sunday <span>10:00 AM - 4:00 PM</span></li>
                </ul>
                <div class="hours-note">
                    <i class="fas fa-clock"></i> Emergency services available 24/7
                </div>
            </div>
            
            <div class="hours-card">
                <div class="hours-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Holidays</h3>
                <ul class="hours-list">
                    <li>New Year's Day <span>Closed</span></li>
                    <li>Christmas Day <span>Closed</span></li>
                    <li>Thanksgiving <span>Closed</span></li>
                    <li>Memorial Day <span>Closed</span></li>
                    <li>Independence Day <span>Closed</span></li>
                </ul>
                <div class="hours-note">
                    <i class="fas fa-exclamation-circle"></i> Limited hours on holiday eves
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== FAQ SECTION ========== -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">FAQ</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-description">Quick answers to common questions</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question"></i>
                    <h4>How quickly do you respond to inquiries?</h4>
                </div>
                <div class="faq-answer">
                    We typically respond to all inquiries within 2-4 hours during business hours. For urgent matters, we recommend calling our 24/7 support line.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question"></i>
                    <h4>Can I book a service through email?</h4>
                </div>
                <div class="faq-answer">
                    While you can inquire via email, we recommend booking through our website or app for the fastest service. Our team will assist you via email if needed.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question"></i>
                    <h4>What are your emergency service hours?</h4>
                </div>
                <div class="faq-answer">
                    Emergency services (plumbing, electrical, locksmith) are available 24/7, 365 days a year. Call our emergency line for immediate assistance.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question"></i>
                    <h4>Do you have a physical office I can visit?</h4>
                </div>
                <div class="faq-answer">
                    Yes! Our headquarters is located in New York City. Visit us during business hours or schedule an appointment for a meeting.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question"></i>
                    <h4>How do I become a service partner?</h4>
                </div>
                <div class="faq-answer">
                    Visit our "Become a Partner" page or email partnerships@homepro.com with your credentials and experience.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question"></i>
                    <h4>What is your refund/cancellation policy?</h4>
                </div>
                <div class="faq-answer">
                    Cancellations made 24 hours before service receive full refund. Same-day cancellations may incur a small fee. Contact support for assistance.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== SOCIAL SECTION ========== -->
<section class="social-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Connect With Us</span>
            <h2 class="section-title">Follow Us On Social Media</h2>
            <p class="section-description">Stay updated with news, offers, and home care tips</p>
        </div>
        
        <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>
</section>

<!-- Initialize Google Maps -->
<script>
function initMap() {
    // New York coordinates
    const location = { lat: 40.7128, lng: -74.0060 };
    
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
        styles: [
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [{ visibility: "off" }]
            }
        ]
    });
    
    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: "HomePro Headquarters",
        animation: google.maps.Animation.DROP,
        icon: {
            url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        }
    });
    
    const infowindow = new google.maps.InfoWindow({
        content: `
            <div style="padding: 10px;">
                <h4 style="margin: 0 0 5px; color: #4361ee;">HomePro Inc.</h4>
                <p style="margin: 0; font-size: 13px;">123 Business Avenue, Suite 100<br>New York, NY 10001</p>
            </div>
        `
    });
    
    marker.addListener("click", () => {
        infowindow.open(map, marker);
    });
}
</script>

<!-- Smooth scroll and FAQ interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
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
    
    // FAQ item click to expand/collapse (optional)
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        item.addEventListener('click', function() {
            const answer = this.querySelector('.faq-answer');
            if (answer.style.maxHeight) {
                answer.style.maxHeight = null;
            } else {
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        });
    });
});
</script>

<?php include("footer.php"); ?>