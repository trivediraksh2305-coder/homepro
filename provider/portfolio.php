<?php
include("session.php");
include("../includes/db.php");

$provider_id = $_SESSION['provider_id'];

if(isset($_POST['save_portfolio'])){

    $experience = $_POST['experience'];
    $rate = $_POST['rate'];
    $about = $_POST['about'];

    if(isset($_POST['services'])){
        $services = implode(",", $_POST['services']);
    } else {
        $services = "";
    }

    $check = mysqli_query($conn, "SELECT * FROM provider_details WHERE provider_id='$provider_id'");

    if(mysqli_num_rows($check) > 0){
        mysqli_query($conn, "UPDATE provider_details 
            SET experience='$experience',
                hourly_rate='$rate',
                services='$services',
                about='$about'
            WHERE provider_id='$provider_id'");
    } else {
        mysqli_query($conn, "INSERT INTO provider_details 
            (provider_id, experience, hourly_rate, services, about)
            VALUES ('$provider_id','$experience','$rate','$services','$about')");
    }

    header("Location: dashboard.php");
    exit();
}

$service_query = mysqli_query($conn, "SELECT * FROM services");
?>

<!DOCTYPE html>
<html>
<head>
<title>Provider Portfolio</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
}

/* Animated Background */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><circle cx="50" cy="50" r="40" fill="white"/></svg>') repeat;
    animation: float 20s linear infinite;
    pointer-events: none;
}

@keyframes float {
    from { transform: translateY(0) rotate(0deg); }
    to { transform: translateY(-100px) rotate(10deg); }
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
    position: relative;
    z-index: 1;
}

/* Card Styles */
.card-custom {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    animation: slideUp 0.6s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-custom:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 35px 60px rgba(0, 0, 0, 0.3);
}

.card-custom .p-4 {
    padding: 2.5rem !important;
}

/* Header Styles */
.card-custom h3 {
    color: #333;
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
    padding-bottom: 1rem;
}

.card-custom h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
    animation: expandWidth 0.8s ease;
}

@keyframes expandWidth {
    from { width: 0; opacity: 0; }
    to { width: 80px; opacity: 1; }
}

/* Form Label Styles */
.form-label {
    font-weight: 600;
    color: #444;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label::before {
    content: '●';
    color: #667eea;
    font-size: 1.2rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Input Field Styles */
.form-control {
    width: 100%;
    padding: 1rem 1.2rem;
    border: 2px solid #eef2f6;
    border-radius: 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
    font-family: 'Poppins', sans-serif;
    background: white;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.form-control:hover {
    border-color: #764ba2;
}

/* Number Input Specific Styles */
input[type="number"] {
    -moz-appearance: textfield;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Textarea Styles */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
    line-height: 1.6;
}

/* Service Box Styles */
.service-box {
    max-height: 250px;
    overflow-y: auto;
    border: 2px solid #eef2f6;
    padding: 1.2rem;
    border-radius: 15px;
    background: white;
    transition: all 0.3s ease;
    scrollbar-width: thin;
    scrollbar-color: #667eea #eef2f6;
}

.service-box:hover {
    border-color: #667eea;
    box-shadow: inset 0 2px 10px rgba(102, 126, 234, 0.1);
}

/* Custom Scrollbar for Service Box */
.service-box::-webkit-scrollbar {
    width: 8px;
}

.service-box::-webkit-scrollbar-track {
    background: #eef2f6;
    border-radius: 10px;
}

.service-box::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
}

.service-box::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2, #667eea);
}

/* Checkbox Styles */
.form-check {
    margin-bottom: 0.8rem;
    padding: 0.5rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease;
    animation-fill-mode: both;
}

.form-check:hover {
    background: linear-gradient(90deg, #f8f9ff, transparent);
    transform: translateX(5px);
}

/* Staggered Animation for Checkboxes */
.form-check:nth-child(1) { animation-delay: 0.1s; }
.form-check:nth-child(2) { animation-delay: 0.2s; }
.form-check:nth-child(3) { animation-delay: 0.3s; }
.form-check:nth-child(4) { animation-delay: 0.4s; }
.form-check:nth-child(5) { animation-delay: 0.5s; }
.form-check:nth-child(6) { animation-delay: 0.6s; }
.form-check:nth-child(7) { animation-delay: 0.7s; }
.form-check:nth-child(8) { animation-delay: 0.8s; }

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-right: 0.8rem;
    cursor: pointer;
    accent-color: #667eea;
    transition: all 0.2s ease;
}

.form-check-input:checked {
    transform: scale(1.1);
}

.form-check-label {
    color: #555;
    font-weight: 500;
    cursor: pointer;
    transition: color 0.3s ease;
}

.form-check-input:checked + .form-check-label {
    color: #667eea;
    font-weight: 600;
}

/* Button Styles */
.btn-save {
    background: linear-gradient(90deg, #667eea, #764ba2);
    border: none;
    color: white;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 15px;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    margin-top: 1rem;
    background-size: 200% auto;
}

.btn-save:hover {
    background-position: right center;
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 20px 30px rgba(102, 126, 234, 0.4);
}

.btn-save:active {
    transform: translateY(-1px) scale(1.01);
}

.btn-save::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-save:hover::before {
    width: 300px;
    height: 300px;
}

/* Responsive Design */
@media (max-width: 992px) {
    .container {
        padding: 1.5rem;
    }
    
    .card-custom .p-4 {
        padding: 2rem !important;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .card-custom .p-4 {
        padding: 1.5rem !important;
    }
    
    .card-custom h3 {
        font-size: 1.5rem;
    }
    
    .form-label {
        font-size: 0.9rem;
    }
    
    .form-control {
        padding: 0.9rem 1rem;
    }
    
    .btn-save {
        padding: 0.9rem 1.5rem;
        font-size: 1rem;
    }
    
    .service-box {
        max-height: 200px;
    }
}

@media (max-width: 480px) {
    .card-custom {
        border-radius: 20px;
    }
    
    .card-custom .p-4 {
        padding: 1.2rem !important;
    }
    
    .form-check {
        padding: 0.3rem;
    }
    
    .form-check-label {
        font-size: 0.9rem;
    }
}

/* Loading Animation for Form Submission */
.btn-save.loading {
    position: relative;
    color: transparent !important;
    pointer-events: none;
}

.btn-save.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 24px;
    height: 24px;
    border: 3px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Success Animation for Save */
@keyframes saveSuccess {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.btn-save.success {
    animation: saveSuccess 0.5s ease;
    background: linear-gradient(90deg, #28a745, #20c997);
}

/* Input Validation Styles */
.form-control:valid {
    border-color: #28a745;
}

.form-control:invalid:not(:placeholder-shown) {
    border-color: #dc3545;
}

/* Tooltip Styles */
[data-tooltip] {
    position: relative;
    cursor: help;
}

[data-tooltip]::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-5px);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
}

[data-tooltip]:hover::before {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-10px);
}

/* Focus Visible for Accessibility */
:focus-visible {
    outline: 3px solid #667eea;
    outline-offset: 2px;
}

/* Row and Column Spacing */
.row {
    margin: 0;
}

.col-lg-8, .col-md-10 {
    padding: 0.5rem;
}

/* Additional Polish */
.mb-3 {
    margin-bottom: 1.8rem !important;
}

.mb-4 {
    margin-bottom: 2rem !important;
}

.mt-3 {
    margin-top: 1.5rem !important;
}

.py-5 {
    padding-top: 3rem !important;
    padding-bottom: 3rem !important;
}
</style>
</style>
</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">
<div class="col-lg-8 col-md-10">

<div class="card card-custom p-4">

<h3 class="mb-4 text-center">Complete Your Portfolio</h3>

<form method="POST">

<!-- Experience -->
<div class="mb-3">
    <label class="form-label">Experience (Years)</label>
    <input type="number" name="experience" class="form-control" required min="0">
</div>

<!-- Hourly Rate -->
<div class="mb-3">
    <label class="form-label">Hourly Rate (₹)</label>
    <input type="number" name="rate" class="form-control" required min="0">
</div>

<!-- Services -->
<div class="mb-3">
    <label class="form-label">Select Services</label>

    <div class="service-box">

    <?php while($service = mysqli_fetch_assoc($service_query)){ ?>

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="services[]"
                   value="<?php echo $service['service_name']; ?>"
                   id="service<?php echo $service['id']; ?>">

            <label class="form-check-label"
                   for="service<?php echo $service['id']; ?>">
                   <?php echo $service['service_name']; ?>
            </label>
        </div>

    <?php } ?>

    </div>
</div>

<!-- About -->
<div class="mb-3">
    <label class="form-label">About You</label>
    <textarea name="about" class="form-control" rows="4"
    placeholder="Write about your experience and skills..."></textarea>
</div>

<button type="submit"
        name="save_portfolio"
        class="btn btn-save w-100 py-2">
        Save & Continue
</button>

</form>

</div>
</div>
</div>
</div>

<script>
document.querySelector("form").addEventListener("submit", function(e){
    const checkboxes = document.querySelectorAll("input[type='checkbox']:checked");
    if(checkboxes.length === 0){
        alert("Please select at least one service!");
        e.preventDefault();
    }
});
</script>

</body>
</html>