<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM providers WHERE email='$email'");
    $row = mysqli_fetch_assoc($query);

    if($row){

        if(password_verify($password, $row['password'])){

            $_SESSION['provider_id'] = $row['id'];
            $_SESSION['provider_name'] = $row['name'];
            $_SESSION['role'] = "provider";

            header("Location: portfolio.php");
            exit();

        } else {
            $error = "Invalid Password!";
        }

    } else {
        $error = "Provider not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Provider Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
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
}

/* Left Section - Hero Area */
.left {
    flex: 1;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    padding: 2rem;
}

.left::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(45deg);
    top: -50%;
    left: -50%;
    animation: shimmer 10s infinite linear;
}

@keyframes shimmer {
    0% { transform: rotate(45deg) translateY(0); }
    100% { transform: rotate(45deg) translateY(50%); }
}

.left h2 {
    font-size: clamp(1.5rem, 5vw, 2.5rem);
    font-weight: 700;
    margin-bottom: 1rem;
    text-align: center;
    position: relative;
    z-index: 1;
    animation: fadeInUp 1s ease;
}

.left p {
    font-size: clamp(0.9rem, 3vw, 1.1rem);
    opacity: 0.9;
    text-align: center;
    position: relative;
    z-index: 1;
    animation: fadeInUp 1s ease 0.2s both;
}

/* Right Section - Form Area */
.right {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 2rem;
}

.form-box {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.5s ease;
}

.form-box h3 {
    color: #333;
    font-size: clamp(1.3rem, 4vw, 1.8rem);
    font-weight: 600;
    margin-bottom: 1.5rem;
    text-align: center;
    position: relative;
}

.form-box h3::after {
    content: '';
    display: block;
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: 0.5rem auto 0;
    border-radius: 2px;
}

/* Form Elements */
.mb-3 {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #555;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e1e1e1;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
    font-family: inherit;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control:hover {
    border-color: #764ba2;
}

/* Button Styles */
.btn {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-danger {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    width: 100%;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-danger:active {
    transform: translateY(0);
}

.btn-danger::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
}

.btn-danger:hover::after {
    width: 300px;
    height: 300px;
}

/* Alert Styles */
.alert {
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    animation: shake 0.5s ease;
}

.alert-danger {
    background: #fee;
    color: #c33;
    border-left: 4px solid #c33;
}

/* Link Styles */
.text-center {
    text-align: center;
    margin-top: 1.5rem;
}

.text-center a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
}

.text-center a:hover {
    color: #764ba2;
}

.text-center a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: width 0.3s ease;
}

.text-center a:hover::after {
    width: 100%;
}

/* Animations */
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

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    body {
        flex-direction: column;
    }
    
    .left {
        min-height: 200px;
    }
    
    .right {
        min-height: calc(100vh - 200px);
    }
    
    .form-box {
        padding: 2rem;
    }
}

@media (max-width: 480px) {
    .form-box {
        padding: 1.5rem;
    }
    
    .left h2 {
        font-size: 1.5rem;
    }
    
    .left p {
        font-size: 0.9rem;
    }
}

/* Loading State for Button */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    border: 2px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Password Field Toggle (Optional Enhancement) */
.password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: #667eea;
}

/* Remember Me Checkbox (Optional) */
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.form-check-input {
    margin-right: 0.5rem;
    cursor: pointer;
}

.form-check-label {
    color: #666;
    cursor: pointer;
    user-select: none;
}
</style>
</style>
</head>

<body>

<div class="left">
    <h2>Welcome Back Provider</h2>
    <p>Login to manage your services.</p>
</div>

<div class="right">
    <div class="form-box">
        <h3>Login</h3>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="login" class="btn btn-danger w-100">
                Login
            </button>
        </form>

        <p class="mt-3 text-center">
            Don't have account?
            <a href="register.php">Register here</a>
        </p>

    </div>
</div>

</body>
</html>