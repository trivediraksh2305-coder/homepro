<?php
session_start();
include("../includes/db.php");

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password != $confirm){
        $error = "Passwords do not match!";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check = mysqli_query($conn, "SELECT * FROM providers WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "Email already exists!";
        } else {

            // Removed service_type from INSERT query
            $insert = "INSERT INTO providers (name, email, password, phone)
                       VALUES ('$name', '$email', '$hashed_password', '$phone')";

            if(mysqli_query($conn, $insert)) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Provider Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-wrap: wrap;
    background: #f8f9fa;
}

/* Left Section - Hero Area with Gradient Animation */
.left {
    flex: 1;
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    padding: 2rem;
}

@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.left::before {
    content: '';
    position: absolute;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.left h2 {
    font-size: clamp(1.5rem, 5vw, 2.5rem);
    font-weight: 700;
    margin-bottom: 1rem;
    text-align: center;
    position: relative;
    z-index: 1;
    animation: slideInLeft 1s ease;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.left p {
    font-size: clamp(0.9rem, 3vw, 1.1rem);
    opacity: 0.95;
    text-align: center;
    position: relative;
    z-index: 1;
    animation: slideInLeft 1s ease 0.2s both;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

/* Right Section - Form Area with Glass Morphism Effect */
.right {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 2rem;
    position: relative;
    overflow-y: auto;
}

.form-box {
    width: 100%;
    max-width: 450px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 2.5rem;
    border-radius: 30px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: scaleIn 0.6s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.form-box h3 {
    color: #333;
    font-size: clamp(1.3rem, 4vw, 1.8rem);
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
}

.form-box h3::before {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #f093fb, #f5576c);
    border-radius: 2px;
    animation: widthGrow 0.8s ease;
}

@keyframes widthGrow {
    from { width: 0; opacity: 0; }
    to { width: 60px; opacity: 1; }
}

/* Form Elements */
.mb-3 {
    margin-bottom: 1.5rem;
    position: relative;
}

label {
    font-weight: 500;
    color: #555;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.form-control {
    width: 100%;
    padding: 0.85rem 1.2rem;
    border: 2px solid #eef2f6;
    border-radius: 15px;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    outline: none;
    font-family: inherit;
    background: white;
}

.form-control:focus {
    border-color: #f5576c;
    box-shadow: 0 5px 15px rgba(245, 87, 108, 0.2);
    transform: translateY(-2px);
}

.form-control:hover {
    border-color: #f093fb;
}

/* Button Styles */
.btn {
    padding: 1rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.btn-danger {
    background: linear-gradient(90deg, #f093fb, #f5576c);
    color: white;
    width: 100%;
    background-size: 200% auto;
}

.btn-danger:hover {
    background-position: right center;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
}

.btn-danger:active {
    transform: translateY(-1px);
}

.btn-danger::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.btn-danger:hover::before {
    left: 100%;
}

/* Alert Styles */
.alert {
    padding: 1rem 1.2rem;
    border-radius: 15px;
    margin-bottom: 1.5rem;
    animation: slideDown 0.5s ease;
    border-left: 5px solid;
    font-weight: 500;
}

.alert-danger {
    background: linear-gradient(90deg, #fff5f5, #ffe5e5);
    color: #dc3545;
    border-left-color: #dc3545;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Link Styles */
.text-center {
    text-align: center;
    margin-top: 2rem;
    color: #666;
}

.text-center a {
    color: #f5576c;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    margin-left: 0.5rem;
}

.text-center a:hover {
    color: #f093fb;
}

.text-center a::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #f093fb, #f5576c);
    transition: width 0.3s ease;
}

.text-center a:hover::before {
    width: 100%;
}

/* Password Strength Indicator */
.password-strength {
    height: 5px;
    background: #eef2f6;
    border-radius: 10px;
    margin-top: 0.5rem;
    overflow: hidden;
}

.password-strength-bar {
    height: 100%;
    width: 0;
    border-radius: 10px;
    transition: width 0.3s ease;
}

.strength-weak { background: #dc3545; width: 33.33%; }
.strength-medium { background: #ffc107; width: 66.66%; }
.strength-strong { background: #28a745; width: 100%; }

/* Responsive Design */
@media (max-width: 992px) {
    .form-box {
        max-width: 400px;
        padding: 2rem;
    }
}

@media (max-width: 768px) {
    body {
        flex-direction: column;
    }
    
    .left {
        min-height: 200px;
        padding: 1.5rem;
    }
    
    .right {
        min-height: auto;
        padding: 1.5rem;
    }
    
    .form-box {
        padding: 2rem;
        margin: 1rem 0;
    }
    
    .left h2 {
        font-size: 1.8rem;
    }
}

@media (max-width: 480px) {
    .form-box {
        padding: 1.5rem;
        border-radius: 20px;
    }
    
    label {
        font-size: 0.85rem;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
    }
    
    .btn {
        padding: 0.85rem 1.2rem;
        font-size: 0.95rem;
    }
}

/* Loading State for Button */
.btn-loading {
    position: relative;
    color: transparent !important;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    border: 3px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Smooth Scroll for Right Panel */
.right::-webkit-scrollbar {
    width: 8px;
}

.right::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

.right::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 10px;
}

.right::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}
</style>
</head>

<body>

<div class="left">
    <h2>Become a Service Provider</h2>
    <p>Join us and grow your business.</p>
</div>

<div class="right">
    <div class="form-box">
        <h3>Create Account</h3>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST" id="registrationForm">

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label>Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a password" required minlength="6">
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrength"></div>
                </div>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password" required>
            </div>

            <button type="submit" name="register" class="btn btn-danger w-100" id="registerBtn">
                Register
            </button>
        </form>

        <p class="text-center">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>
</div>

<script>
// Password strength indicator
const passwordInput = document.querySelector('input[name="password"]');
const strengthBar = document.getElementById('passwordStrength');

passwordInput.addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    
    if (password.length >= 6) strength += 1;
    if (password.match(/[a-z]+/)) strength += 1;
    if (password.match(/[A-Z]+/)) strength += 1;
    if (password.match(/[0-9]+/)) strength += 1;
    if (password.match(/[$@#&!]+/)) strength += 1;
    
    strengthBar.className = 'password-strength-bar';
    
    if (password.length === 0) {
        strengthBar.style.width = '0';
    } else if (strength <= 2) {
        strengthBar.classList.add('strength-weak');
    } else if (strength <= 4) {
        strengthBar.classList.add('strength-medium');
    } else {
        strengthBar.classList.add('strength-strong');
    }
});

// Form submission with loading animation
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
    const registerBtn = document.getElementById('registerBtn');
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return;
    }
    
    // Add loading animation to button
    registerBtn.classList.add('btn-loading');
    registerBtn.textContent = '';
});

// Phone number validation
document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
});
</script>

</body>
</html>