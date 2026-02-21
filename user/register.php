<?php
session_start();
include("../includes/db.php");

if(isset($_POST['register'])){

    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $name = $first . " " . $last;
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password != $confirm){
        $error = "Passwords do not match!";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "Email already exists!";
        } else {

            $insert = "INSERT INTO users (name,email,password,phone)
                       VALUES ('$name','$email','$hashed_password','$phone')";
            mysqli_query($conn, $insert);

            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    height: 100vh;
    display: flex;
    background: #f8fafc;
}

.left {
    width: 45%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 60px 40px;
    position: relative;
    overflow: hidden;
}

.left::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M30 0L60 30L30 60L0 30L30 0Z" fill="rgba(255,255,255,0.03)"/></svg>');
    opacity: 0.1;
}

.left h1 {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    position: relative;
    animation: slideInLeft 0.8s ease-out;
    text-align: center;
}

.left p {
    font-size: 1.2rem;
    opacity: 0.95;
    line-height: 1.6;
    max-width: 400px;
    text-align: center;
    position: relative;
    animation: slideInLeft 0.8s ease-out 0.2s both;
}

.left .feature-list {
    margin-top: 3rem;
    list-style: none;
    position: relative;
    animation: slideInLeft 0.8s ease-out 0.4s both;
}

.left .feature-list li {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1rem;
}

.left .feature-list li svg {
    margin-right: 1rem;
    width: 20px;
    height: 20px;
    fill: none;
    stroke: white;
    stroke-width: 2;
}

.right {
    width: 55%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    background: #f8fafc;
    overflow-y: auto;
    min-height: 100vh;
}

.form-box {
    width: 100%;
    max-width: 520px;
    background: white;
    padding: 50px 40px;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08), 0 6px 12px rgba(0,0,0,0.05);
    animation: fadeInUp 0.8s ease-out;
    margin: 20px 0;
}

.form-box h2 {
    color: #1e293b;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.form-box .subtitle {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 2rem;
    font-weight: 400;
}

.form-box .alert {
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    border: none;
    font-size: 0.95rem;
}

.form-box .alert-danger {
    background: #fef2f2;
    color: #b91c1c;
    border-left: 4px solid #ef4444;
}

.form-box .row {
    margin: 0 -0.75rem;
}

.form-box .row > [class*="col-"] {
    padding: 0 0.75rem;
}

.form-box .mb-3 {
    margin-bottom: 1.5rem !important;
}

.form-box label {
    color: #334155;
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: block;
}

.form-box .form-control {
    height: 52px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8fafc;
    width: 100%;
}

.form-box .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: white;
    outline: none;
}

.form-box .btn-primary {
    height: 52px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.5px;
    color: white;
    transition: all 0.3s ease;
    margin-top: 1rem;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 100%;
}

.form-box .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.form-box .btn-primary:active {
    transform: translateY(0);
}

.form-box .btn-primary::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 5px;
    height: 5px;
    background: rgba(255,255,255,0.5);
    opacity: 0;
    border-radius: 100%;
    transform: scale(1, 1) translate(-50%);
    transform-origin: 50% 50%;
}

.form-box .btn-primary:focus:not(:active)::after {
    animation: ripple 1s ease-out;
}

.form-box .mt-3 {
    text-align: center;
    margin-top: 2rem !important;
    color: #64748b;
    font-size: 0.95rem;
}

.form-box .mt-3 a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    margin-left: 0.5rem;
    transition: color 0.3s ease;
}

.form-box .mt-3 a:hover {
    color: #764ba2;
    text-decoration: underline;
}

.form-box .divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 1.5rem 0;
    color: #94a3b8;
    font-size: 0.9rem;
}

.form-box .divider::before,
.form-box .divider::after {
    content: '';
    flex: 1;
    border-bottom: 2px solid #e2e8f0;
}

.form-box .divider::before {
    margin-right: 1rem;
}

.form-box .divider::after {
    margin-left: 1rem;
}

/* Password strength indicator (optional) */
.password-strength {
    margin-top: 0.5rem;
    height: 4px;
    border-radius: 2px;
    background: #e2e8f0;
    overflow: hidden;
}

.password-strength-bar {
    height: 100%;
    width: 0;
    transition: width 0.3s ease, background-color 0.3s ease;
}

/* Terms checkbox styling */
.form-check {
    margin: 1.5rem 0;
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-right: 0.5rem;
    border: 2px solid #e2e8f0;
    border-radius: 4px;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.form-check-label {
    color: #64748b;
    font-size: 0.95rem;
    cursor: pointer;
}

.form-check-label a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.form-check-label a:hover {
    text-decoration: underline;
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

@keyframes ripple {
    0% {
        transform: scale(0, 0);
        opacity: 1;
    }
    20% {
        transform: scale(25, 25);
        opacity: 1;
    }
    100% {
        opacity: 0;
        transform: scale(40, 40);
    }
}

/* Responsive Design */
@media (max-width: 992px) {
    .left h1 {
        font-size: 2.8rem;
    }
}

@media (max-width: 768px) {
    body {
        flex-direction: column;
    }
    
    .left, .right {
        width: 100%;
    }
    
    .left {
        padding: 40px 20px;
        min-height: 280px;
    }
    
    .left h1 {
        font-size: 2.5rem;
    }
    
    .right {
        padding: 20px;
        min-height: auto;
    }
    
    .form-box {
        padding: 40px 30px;
        max-width: 100%;
    }
}

@media (max-width: 480px) {
    .form-box .row {
        flex-direction: column;
    }
    
    .form-box .row > [class*="col-"] {
        width: 100%;
    }
    
    .left h1 {
        font-size: 2rem;
    }
}
</style>
</head>

<body>

<div class="left">
    <h1>Join HomeServe Today!</h1>
    <p>Create an account to book services easily.</p>
    <ul class="feature-list">
        <li>
            <svg viewBox="0 0 24 24">
                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Quick & easy registration
        </li>
        <li>
            <svg viewBox="0 0 24 24">
                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Book services in minutes
        </li>
        <li>
            <svg viewBox="0 0 24 24">
                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Track your service history
        </li>
    </ul>
</div>

<div class="right">
    <div class="form-box">
        <h2>Create Account</h2>
        <p class="subtitle">Join us today and get started with our services.</p>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="John" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="Doe" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Email address</label>
                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
            </div>

            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" name="register" class="btn btn-primary">
                Create Account
            </button>
        </form>

        <div class="divider">or</div>

        <p class="mt-3">
            Already have an account?
            <a href="login.php">Sign In</a>
        </p>
    </div>
</div>

</body>
</html>